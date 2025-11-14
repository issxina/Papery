<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\UserModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        try {
            Paginator::useBootstrap();
            $userList = UserModel::orderBy('id', 'asc')->paginate(10); //order by & pagination
            return view('user.list', compact('userList'));
        } catch (\Exception $e) {
            // \Log::error('Admin list error: '.$e->getMessage());
            return view('errors.404');
        }
    }

    public function adding()
    {
        return view('user.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'user_name.required' => 'กรุณากรอกข้อมูล',
            'user_name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'user_name.unique' => 'ชื่อถูกใช้ไปแล้ว!!',

            'user_email.required' => 'กรุณาระบุอีเมล',
            'user_email.email' => 'กรอกอีเมลให้ถูกต้อง',
            'user_email.unique' => 'อีเมลถูกใช้แล้ว!!',

            'user_password.required' => 'กรุณากรอกข้อมูล',
            'user_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',

            'user_address.required' => 'กรุณากรอกที่อยู่',

            'user_phone.required' => 'กรุณากรอกเบอร์โทร',
            'user_phone.min' => 'กรุณากรอกเบอร์ให้ครบถ้วน',
            'user_phone.max' => 'กรุณากรอกข้อมูลไม่เกิน :max ตัว',
        ];

        //rule 
        $validator = Validator::make($request->all(), [
            'user_name'     => 'required|min:3|unique:tbl_users,user_name',
            'user_email'    => 'required|email|unique:tbl_users,user_email',
            'user_password' => 'required|min:8',
            'user_address'  => 'required',
            'user_phone'    => 'required|min:10|max:10',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('user/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            UserModel::create([
                'user_name' => strip_tags($request->input('user_name')),
                'user_email' => strip_tags($request->input('user_email')),
                'user_password' => bcrypt($request->input('user_password')),
                'user_address' => strip_tags($request->input('user_address')),
                'user_phone' => strip_tags($request->input('user_phone')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create



    public function edit($id)
    {
        try {
            //query data for form edit 
            $user = UserModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($user)) {
                $id = $user->id;
                $user_name = $user->user_name;
                $user_email = $user->user_email;
                $user_password = $user->user_password;
                $user_address = $user->user_address;
                $user_phone = $user->user_phone;
                return view('user.edit', compact('id', 'user_name', 'user_email', 'user_password', 'user_address', 'user_phone'));
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
            'user_name.required' => 'กรุณากรอกข้อมูล',
            'user_name.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'user_name.unique'   => 'ชื่อนี้ถูกใช้แล้ว!!',

            'user_email.required' => 'กรุณาระบุอีเมล',
            'user_email.email'   => 'กรอกอีเมลให้ถูกต้อง',
            'user_email.unique'  => 'อีเมลถูกใช้แล้ว!!',

            'user_address.required' => 'กรุณากรอกที่อยู่',

            'user_phone.required' => 'กรุณากรอกเบอร์โทร',
            'user_phone.min'     => 'กรุณากรอกเบอร์ให้ครบถ้วน',
            'user_phone.max'     => 'กรุณากรอกข้อมูลไม่เกิน :max ตัว',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'user_name'  => ['required', 'min:3', Rule::unique('tbl_users', 'user_name')->ignore($id, 'id'),],
            'user_email' => ['required', 'email', Rule::unique('tbl_users', 'user_email')->ignore($id, 'id'),],
            'user_address' => 'required',
            'user_phone'   => 'required|min:10|max:10',


        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('user/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = UserModel::find($id);
            $user->update([
                'user_name' => strip_tags($request->input('user_name')),
                'user_email' => strip_tags($request->input('user_email')),
                'user_address' => strip_tags($request->input('user_address')),
                'user_phone' => strip_tags($request->input('user_phone')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $user = UserModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $user->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //remove 

    public function reset($id)
    {
        try {
            //query data for form edit 
            $user = UserModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($user)) {
                $id = $user->id;
                $user_name = $user->user_name;
                $user_email = $user->user_email;
                return view('user.editPassword', compact('id', 'user_name', 'user_email'));
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
            'user_password.required' => 'กรุณากรอกข้อมูล',
            'user_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'user_password.confirmed' => 'รหัสผ่านไม่ตรงกัน',

            'user_password_confirmation.required' => 'กรุณากรอกข้อมูล',
            'user_password_confirmation.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
        ];

        //rule
        $validator = Validator::make($request->all(), [

            'user_password' => 'required|min:8|confirmed',
            'user_password_confirmation' => 'required|min:8',

        ], $messages);

        //check
        if ($validator->fails()) {
            return redirect('user/reset/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = UserModel::find($id);
            $user->update([
                'user_password' => bcrypt($request->input('user_password')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('แก้ไขรหัสผ่านสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun resetPassword


    public function editProfile()
    {
        $user = Auth::guard('web')->user();
        return view('profile.edit', compact('user'));
    }

    // อัปเดตข้อมูล
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }

        $messages = [
            'user_name.unique' => 'ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว กรุณาเลือกชื่อใหม่',
            'user_name.required' => 'กรุณากรอกชื่อผู้ใช้',
            'user_name.min' => 'ชื่อผู้ใช้ต้องมีอย่างน้อย :min ตัวอักษร',
            'user_phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'user_phone.min' => 'กรุณากรอกเบอร์โทรศัพท์ให้ครบถ้วน',
            'user_phone.max' => 'กรุณากรอกเบอร์โทรศัพท์ไม่เกิน :max ตัว',
            'user_address.required' => 'กรุณากรอกที่อยู่',
        ];

        $validator = Validator::make($request->all(), [
            'user_name'    => 'required|min:3|unique:tbl_users,user_name,' . $user->id . ',id',
            'user_phone'   => 'required|min:10|max:10',
            'user_address' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('profile.edit')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'user_name'    => strip_tags($request->input('user_name')),
                'user_address' => strip_tags($request->input('user_address')),
                'user_phone'   => strip_tags($request->input('user_phone')),
            ];

            if ($request->filled('user_password')) {
                $data['user_password'] = bcrypt($request->input('user_password'));
            }

            UserModel::where('id', $user->id)->update($data);

            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect()->route('profile.edit');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} //class
