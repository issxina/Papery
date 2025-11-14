<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\CategoryModel;
use App\Models\BookModel;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
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
            $categoryList = CategoryModel::orderBy('id', 'asc')->paginate(10); //order by & pagination
            return view('category.list', compact('categoryList'));
        } catch (\Exception $e) {
            // \Log::error('Admin list error: '.$e->getMessage());
            return view('errors.404');
        }
    }

    public function adding()
    {
        return view('category.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'category_name.required' => 'กรุณากรอกข้อมูล',
            'category_name.unique' => 'มีหมวดหมู่นี้ในระบบแล้ว',
            'category_slug.required' => 'กรุณากรอกข้อมูล',
            'catrgory_slug.unique' => 'มีหมวดหมู่นี้ในระบบแล้ว',
        ];

        //rule 
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:tbl_categories,category_name',
            'category_slug' => 'required|unique:tbl_categories,category_slug',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('category/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            CategoryModel::create([
                'category_name' => strip_tags($request->input('category_name')),
                'category_slug' => strip_tags($request->input('category_slug')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/category');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create



    public function edit($id)
    {
        try {
            //query data for form edit 
            $category = CategoryModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($category)) {
                $id = $category->id;
                $category_name = $category->category_name;
                $category_slug = $category->category_slug;
                return view('category.edit', compact('id', 'category_name','category_slug'));
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
            'category_name.required' => 'กรุณากรอกข้อมูล',
            'category_name.unique' => 'มีหมวดหมู่นี้ในระบบแล้ว',
            'category_slug.required' => 'กรุณากรอกข้อมูล',
            'catrgory_slug.unique' => 'มีหมวดหมู่นี้ในระบบแล้ว',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'category_name' => ['required', Rule::unique('tbl_categories')->ignore($id)],
            'category_slug' => ['required', Rule::unique('tbl_categories')->ignore($id)],

        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('category/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $category = CategoryModel::find($id);
            $category->update([
                'category_name' => strip_tags($request->input('category_name')),
                'category_slug' => strip_tags($request->input('category_slug')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/category');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun update 

    public function remove($id)
    {
        try {
            $category = CategoryModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $category->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/category');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //remove 

} //class
