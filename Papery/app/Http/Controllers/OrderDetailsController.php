<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\OrderDetailsModel;
use App\Models\OrderModel;
use App\Models\BookModel;
use Illuminate\Pagination\Paginator;

class OrderDetailsController extends Controller
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

            $orderdetailsList = OrderDetailsModel::with(['order', 'book']) //ดึงข้อมูลชื่อหนังสือกับออเดอร์
                ->orderBy('id', 'asc') //order by & pagination
                ->paginate(10);

            return view('orderdetails.list', compact('orderdetailsList'));
        } catch (\Exception $e) {
            // \Log::error('Admin list error: '.$e->getMessage());
            return view('errors.404');
        }
    }

    public function adding()
    {
        $orderList = OrderModel::orderBy('id')->get();
        $bookList  = BookModel::orderBy('book_title')->get();

        return view('orderdetails.create', compact('orderList', 'bookList'));
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'order_id.required' => 'กรุณาเลือก Order',
            'book_id.required'  => 'กรุณาเลือก Book',
            'orderdetails_qty.required' => 'กรุณากรอกจำนวน',
        ];

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:tbl_orders,id',
            'book_id'  => 'required|exists:tbl_books,id',
            'orderdetails_qty' => 'required|numeric|min:1',
            'orderdetails_unit_price' => 'required|numeric|min:0',
        ], $messages);

        if ($validator->fails()) {
            return redirect('orderdetails/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $qty = (float) $request->input('orderdetails_qty');
            $unitPrice = (float) $request->input('orderdetails_unit_price');
            $total = $qty * $unitPrice;

            OrderDetailsModel::create([
                'order_id' => strip_tags($request->input('order_id')),
                'book_id'  => strip_tags($request->input('book_id')),
                'orderdetails_qty' => $qty,
                'orderdetails_unit_price' => $unitPrice,
                'orderdetails_total_price' => $total,
            ]);

            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/orderdetails');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            //return view('errors.404');
        }
    }


    public function edit($id)
    {
        try {
            $orderdetails = OrderDetailsModel::findOrFail($id);
            $orderList = OrderModel::orderBy('id')->get();
            $bookList  = BookModel::orderBy('book_title')->get();

            if (isset($orderdetails)) {
                $id = $orderdetails->id;
                $order_id = $orderdetails->order_id;
                $book_id = $orderdetails->book_id;
                $orderdetails_qty = $orderdetails->orderdetails_qty;
                $orderdetails_unit_price = $orderdetails->orderdetails_unit_price;
                $orderdetails_total_price = $orderdetails->orderdetails_total_price;


                return view('orderdetails.edit', compact('id', 'order_id', 'book_id', 'orderdetails_qty', 'orderdetails_unit_price', 'orderdetails_total_price', 'orderList', 'bookList'));
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
            'order_id.required' => 'กรุณาเลือก Order',
            'book_id.required'  => 'กรุณาเลือก Book',
            'orderdetails_qty.required' => 'กรุณากรอกจำนวน',
            'orderdetails_unit_price.required' => 'กรุณากรอกราคา',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:tbl_orders,id',
            'book_id'  => 'required|exists:tbl_books,id',
            'orderdetails_qty' => 'required|numeric|min:1',
            'orderdetails_unit_price' => 'required|numeric|min:0',
        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('orderdetails/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $orderdetails = OrderDetailsModel::findOrFail($id);

            $qty = (float) $request->input('orderdetails_qty');
            $unitPrice = (float) $request->input('orderdetails_unit_price');
            $total = $qty * $unitPrice;

            $orderdetails->update([
                'order_id' => strip_tags($request->input('order_id')),
                'book_id'  => strip_tags($request->input('book_id')),
                'orderdetails_qty' => $qty,
                'orderdetails_unit_price' => $unitPrice,
                'orderdetails_total_price' => $total,
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/orderdetails');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $order = OrderDetailsModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $order->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/orderdetails');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //remove 


} //class
