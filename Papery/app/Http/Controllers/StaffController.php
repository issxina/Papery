<?php

namespace App\Http\Controllers;

use App\Models\StaffModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;

class StaffController extends Controller
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
            $staffList = StaffModel::orderBy('id', 'asc')->paginate(10); //order by & pagination
            return view('staff.list', compact('staffList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    }

    public function adding()
    {
        return view('staff.create');
    }

public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();
 
        //vali msg
        $messages = [
            'st_name.required' => 'กรุณากรอกข้อมูล',
            'st_name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
 
            'st_email.required' => 'กรุณากรอกข้อมูล',
            'st_email.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'st_email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'st_email.unique' => 'Email ซ้ำ เพิ่มใหม่อีกครั้ง !!',

            'st_password.required' => 'กรุณากรอกข้อมูล',
            'st_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
           
        ];
 
        //rule
        $validator = Validator::make($request->all(), [
            'st_name' => 'required|min:3',
            'st_email' => 'required|email|min:10|unique:tbl_staff',
            'st_password' => 'required|min:4',
        ], $messages);
 
        //check vali
        if ($validator->fails()) {
            return redirect('staff/adding')
                ->withErrors($validator)
                ->withInput();
        }
 
        try {
 
            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            StaffModel::create([
                'st_name' => strip_tags($request->input('st_name')),
                'st_email' => strip_tags($request->input('st_email')),
                'st_password' => bcrypt($request->input('st_password')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/staff');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
           // return view('errors.404');
        }
    } //fun create



    public function edit($id)
    {
        try {
            //query data for form edit 
            $staff = StaffModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($staff)) {
                $id = $staff->id;
                $st_name = $staff->st_name;
                $st_email = $staff->st_email;
                return view('staff.edit', compact('id', 'st_name', 'st_email'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //func edit


    public function update($id, Request $request)
    {
        //vali msg 
        $messages = [
            'st_name.required' => 'กรุณากรอกข้อมูล',
            'st_name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
 
            'st_email.required' => 'กรุณากรอกข้อมูล',
            'st_email.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'st_email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'st_email.unique' => 'Email ซ้ำ เพิ่มใหม่อีกครั้ง !!',

        ];

        //rule
        $validator = Validator::make($request->all(), [
            'st_name' => 'required|min:3',
            'st_email' => 'required','email','min:10',Rule::unique('tbl_staff','st_email')->ignore($id, 'id'),

        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('staff/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $staff = StaffModel::find($id);
            $staff->update([
                'st_name' => strip_tags($request->input('st_name')),
                'st_email' => strip_tags($request->input('st_email')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/staff');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $staff = StaffModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $staff->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/staff');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //remove 

    public function reset($id)
    {
        try {
            //query data for form edit 
            $staff = StaffModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($staff)) {
                $id = $staff->id;
                $st_name = $staff->st_name;
                $st_email = $staff->st_email;
                return view('staff.editPassword', compact('id', 'st_name', 'st_email'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func reset

    public function resetPassword($id, Request $request)
    {
        //vali msg
        $messages = [
            'st_password.required' => 'กรุณากรอกข้อมูล',
            'st_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'st_password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
 
            'st_password_confirmation.required' => 'กรุณากรอกข้อมูล',
            'st_password_confirmation.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
        ];
 
        //rule
        $validator = Validator::make($request->all(), [
           
            'st_password' => 'required|min:4|confirmed',
            'st_password_confirmation' => 'required|min:4',
 
    ], $messages);
 
    //check
        if ($validator->fails()) {
            return redirect('staff/reset/' . $id)
                ->withErrors($validator)
                ->withInput();
        }
 
        try {
            $staff = StaffModel::find($id);
            $staff->update([
                'st_password' => bcrypt($request->input('st_password')),
                ]);
            // แสดง Alert ก่อน return
            Alert::success('แก้ไขรหัสผ่านสำเร็จ');
            return redirect('/staff');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun resetPassword

} //class
