<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\BookModel;
use Illuminate\Pagination\Paginator;

class BookController extends Controller
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
            $bookList = BookModel::orderBy('id', 'asc')->paginate(10); //order by & pagination
            return view('book.list', compact('bookList'));
        } catch (\Exception $e) {
            // \Log::error('Admin list error: '.$e->getMessage());
            return view('errors.404');
        }
    }

    public function adding()
    {
        $categoryList = \App\Models\CategoryModel::orderBy('category_name')->get();
        return view('book.create', compact('categoryList'));
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'book_title.required' => 'กรุณากรอกข้อมูลหนังสือ',
            'book_title.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'book_author.required' => 'กรุณากรอกข้อมูล',
            'book_author.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'book_price.required' => 'กรุณากรอกราคา',
            'book_price.numeric' => 'กรุณากรอกเป็นตัวเลข',
            'book_stock_qty.required' => 'กรุณากรอกจำนวนคงเหลือ',
            'book_stock_qty.integer' => 'กรุณากรอกเป็นจำนวนเต็ม',
            'book_stock_qty.min' => 'ต้องไม่น้อยกว่า 0',
            'category_id.required' => 'กรุณาเลือกหมวดหมู่',
            'category_id.exists' => 'หมวดหมู่ไม่ถูกต้อง',
            'book_img.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'book_img.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
            'book_img.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
        ];

        $validator = Validator::make($request->all(), [
            'book_title'     => 'required|min:3',
            'book_author'    => 'required|min:2',
            'book_price'     => 'required|numeric',
            'book_stock_qty' => 'required|integer|min:0',
            'category_id'    => 'required|exists:tbl_categories,id',
            'book_img'       => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('book/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $imagePath = null;
            if ($request->hasFile('book_img')) {
                $imagePath = $request->file('book_img')->store('uploads/book', 'public');
            }

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            BookModel::create([
                'book_title' => strip_tags($request->input('book_title')),
                'book_author' => strip_tags($request->input('book_author')),
                'book_price' => strip_tags($request->input('book_price')),
                'book_stock_qty' => strip_tags($request->input('book_stock_qty')),
                'category_id' => strip_tags($request->input('category_id')),
                'book_category_sub' => strip_tags($request->input('book_category_sub')),
                'book_img' => $imagePath,
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/book');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create

    public function edit($id)
    {
        try {
            $book = BookModel::findOrFail($id);
            $categoryList = \App\Models\CategoryModel::orderBy('category_name')->get();

            if (isset($book)) {
                $id = $book->id;
                $book_title = $book->book_title;
                $book_author = $book->book_author;
                $book_price = $book->book_price;
                $book_stock_qty = $book->book_stock_qty;
                $category_id = $book->category_id;
                $book_category_sub = $book->book_category_sub;
                $book_img = $book->book_img;
                return view('book.edit', compact('id', 'book_title', 'book_author', 'book_price', 'book_stock_qty', 'category_id', 'book_img', 'categoryList', 'book_category_sub'));
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
            'book_title.required' => 'กรุณากรอกข้อมูลหนังสือ',
            'book_title.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'book_author.required' => 'กรุณากรอกข้อมูล',
            'book_author.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'book_price.required' => 'กรุณากรอกราคา',
            'book_price.numeric' => 'กรุณากรอกเป็นตัวเลข',
            'book_stock_qty.required' => 'กรุณากรอกจำนวนคงเหลือ',
            'book_stock_qty.integer' => 'กรุณากรอกเป็นจำนวนเต็ม',
            'book_stock_qty.min' => 'ต้องไม่น้อยกว่า 0',
            'category_id.required' => 'กรุณาเลือกหมวดหมู่',
            'category_id.exists' => 'หมวดหมู่ไม่ถูกต้อง',
            'book_img.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'book_img.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
            'book_img.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
        ];

        $validator = Validator::make($request->all(), [
            'book_title'     => 'sometimes|required|min:3',
            'book_author'    => 'sometimes|required|min:2',
            'book_price'     => 'sometimes|required|numeric',
            'book_stock_qty' => 'sometimes|required|integer|min:0',
            'category_id'    => 'sometimes|required|exists:tbl_categories,id',
            'book_img'       => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);


        //check 
        if ($validator->fails()) {
            return redirect('book/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $imagePath = null;
            if ($request->hasFile('book_img')) {
                $imagePath = $request->file('book_img')->store('uploads/book', 'public');
            }

            // ดึงข้อมูลหนังสือก่อนอัปเดต
            $book = BookModel::findOrFail($id);

            // เตรียม array สำหรับอัปเดต
            $updateData = $request->only([
                'book_title',
                'book_author',
                'book_price',
                'book_stock_qty',
                'category_id',
            ]);

            // ถ้ามีอัปโหลดรูปใหม่ → อัปเดต book_img ด้วย
            if ($request->hasFile('book_img')) {
                $updateData['book_img'] = $request->file('book_img')->store('uploads/book', 'public');
            }

            // อัปเดตเฉพาะฟิลด์ที่ส่งมา
            $book->update($updateData);
            
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/book');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $book = BookModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $book->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/book');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //remove 


} //class
