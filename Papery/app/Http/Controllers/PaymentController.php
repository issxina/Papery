<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PaymentModel;
use App\Models\OrderModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct()
    {
        // ใช้ middleware 'auth:admin' เพื่อบังคับให้ต้องล็อกอินในฐานะ admin ก่อนใช้งาน controller นี้
        // ถ้าไม่ล็อกอินหรือไม่ได้ใช้ guard 'admin' จะถูก redirect ไปหน้า login
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            Paginator::useBootstrap();
            $paymentList = PaymentModel::orderBy('id', 'asc')->paginate(10);
            return view('payment.list', compact('paymentList'));
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function adding()
    {
        $orderList = OrderModel::orderBy('id', 'desc')->get();
        return view('payment.create', compact('orderList'));
    }

    public function create(Request $request)
    {
        $messages = [
            'order_id.required' => 'กรุณาเลือกคำสั่งซื้อ',
            'pay_method.required' => 'กรุณาเลือกวิธีการชำระเงิน',
            'pay_amount.required' => 'กรุณากรอกจำนวนเงิน',
            'pay_amount.numeric' => 'จำนวนเงินต้องเป็นตัวเลข',
            'pay_paid_at.required' => 'กรุณาระบุวันที่ชำระ',
            'pay_paid_at.date' => 'รูปแบบวันที่ไม่ถูกต้อง',
        ];

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:tbl_orders,id',
            'pay_method' => ['required', Rule::in(['bank_transfer', 'promptpay', 'credit_card', 'cod'])],
            'pay_amount' => 'required|numeric|min:0',
            'pay_paid_at' => 'required|date',
            'pay_proof_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return redirect('payment/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $proofPath = null;
            if ($request->hasFile('pay_proof_path')) {
                $proofPath = $request->file('pay_proof_path')->store('payments', 'public');
            }

            PaymentModel::create([
                'order_id' => $request->order_id,
                'pay_method' => $request->pay_method,
                'pay_amount' => $request->pay_amount,
                'pay_proof_path' => $proofPath,
                'pay_paid_at' => $request->pay_paid_at,
            ]);

            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/payment');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $payment = PaymentModel::findOrFail($id);
            $orderList = OrderModel::orderBy('id', 'desc')->get();

            return view('payment.edit', [
                'id' => $payment->id,
                'order_id' => $payment->order_id,
                'pay_method' => $payment->pay_method,
                'pay_amount' => $payment->pay_amount,
                'pay_proof_path' => $payment->pay_proof_path,
                'pay_paid_at' => $payment->pay_paid_at,
                'orderList' => $orderList
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, Request $request)
    {
        $messages = [
            'order_id.required' => 'กรุณาเลือกคำสั่งซื้อ',
            'pay_method.required' => 'กรุณาเลือกวิธีการชำระเงิน',
            'pay_amount.required' => 'กรุณากรอกจำนวนเงิน',
            'pay_paid_at.required' => 'กรุณาระบุวันที่ชำระ',
        ];

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:tbl_orders,id',
            'pay_method' => ['required', Rule::in(['bank_transfer', 'promptpay', 'credit_card', 'cod'])],
            'pay_amount' => 'required|numeric|min:0',
            'pay_paid_at' => 'required|date',
            'pay_proof_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return redirect('payment/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $payment = PaymentModel::find($id);

            $proofPath = $payment->pay_proof_path;
            if ($request->hasFile('pay_proof_path')) {
                if ($proofPath) {
                    Storage::disk('public')->delete($proofPath);
                }
                $proofPath = $request->file('pay_proof_path')->store('payments', 'public');
            }

            $payment->update([
                'order_id' => $request->order_id,
                'pay_method' => $request->pay_method,
                'pay_amount' => $request->pay_amount,
                'pay_proof_path' => $proofPath,
                'pay_paid_at' => $request->pay_paid_at,
            ]);

            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/payment');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function remove($id)
    {
        try {
            $payment = PaymentModel::find($id);
            if ($payment->pay_proof_path) {
                Storage::disk('public')->delete($payment->pay_proof_path);
            }
            $payment->delete();

            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/payment');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
