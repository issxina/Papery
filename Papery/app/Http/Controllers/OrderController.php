<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\OrderModel;
use App\Models\UserModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
        $orderList = OrderModel::orderBy('id', 'asc')->paginate(10); // ✅ ใช้ id แทน order_number
        return view('order.list', compact('orderList'));
    } catch (\Exception $e) {
        return view('errors.404');
    }
}



    public function adding()
    {
        $userList = \App\Models\UserModel::orderBy('user_name')->get();
        return view('order.create', compact('userList'));
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'user_id.required' => 'กรุณากรอกข้อมูล',
            'order_status.required' => 'กรุณากรอกข้อมูล',
            'order_subtotal.required' => 'กรุณากรอกข้อมูล',
            'order_discount.required' => 'กรุณากรอกข้อมูล',
            'order_date.required' => 'กรุณากรอกข้อมูล',
            'order_shipping_address.required' => 'กรุณากรอกข้อมูล',
            'order_shipping_address.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:tbl_users,id',
            'order_status' => ['required', Rule::in(['pending', 'paid', 'packed', 'shipped', 'completed', 'cancelled'])],
            'order_subtotal' => 'required|numeric|min:0',
            'order_discount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'order_shipping_address' => 'required|min:10',
        ], $messages);

        if ($validator->fails()) {
            return redirect('order/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $subtotal = (float) $request->input('order_subtotal');
            $discount = (float) $request->input('order_discount');
            $amount   = $subtotal - $discount;


            OrderModel::create([
                'user_id' => strip_tags($request->input('user_id')),
                'order_status' => strip_tags($request->input('order_status')),
                'order_subtotal' => $subtotal,
                'order_discount' => $discount,
                'order_amount' => $amount,
                'order_date' => strip_tags($request->input('order_date')),
                'order_shipping_address' => strip_tags($request->input('order_shipping_address')),
            ]);

            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/order');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create



    public function edit($id)
    {
        try {
            //query data for form edit 
            $order = OrderModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            $userList = UserModel::orderBy('user_name')->get();
            if (isset($order)) {
                $id = $order->id;
                $user_id = $order->user_id;
                $order_status = $order->order_status;
                $order_subtotal = $order->order_subtotal;
                $order_discount = $order->order_discount;
                $order_amount = $order->order_amount;
                $order_date = $order->order_date;
                $order_shipping_address = $order->order_shipping_address;

                return view('order.edit', compact('id', 'user_id', 'order_status', 'order_subtotal', 'order_discount', 'order_amount', 'order_date', 'order_shipping_address', 'userList'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            // return view('errors.404');
        }
    } //func edit


    public function update($id, Request $request)
    {
        //vali msg 
        $messages = [
            'user_id.required' => 'กรุณากรอกข้อมูล',
            'order_status.required' => 'กรุณากรอกข้อมูล',
            'order_subtotal.required' => 'กรุณากรอกข้อมูล',
            'order_discount.required' => 'กรุณากรอกข้อมูล',
            'order_date.required' => 'กรุณากรอกข้อมูล',
            'order_shipping_address.required' => 'กรุณากรอกข้อมูล',
            'order_shipping_address.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:tbl_users,id',
            'order_status' => ['required', Rule::in(['pending', 'paid', 'packed', 'shipped', 'completed', 'cancelled'])],
            'order_subtotal' => 'required|numeric|min:0',
            'order_discount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'order_shipping_address' => 'required|min:10',
        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('order/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $subtotal = (float) $request->input('order_subtotal');
            $discount = (float) $request->input('order_discount');
            $amount   = $subtotal - $discount;

            $order = OrderModel::findOrFail($id);
            $order->update([
                'user_id' => strip_tags($request->input('user_id')),
                'order_status' => strip_tags($request->input('order_status')),
                'order_subtotal' => $subtotal,
                'order_discount' => $discount,
                'order_amount' => $amount,
                'order_date' => strip_tags($request->input('order_date')),
                'order_shipping_address' => strip_tags($request->input('order_shipping_address')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/order');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $order = OrderModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $order->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/order');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //remove 

} //class
