<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return redirect()->route('home', ['login' => 1]);
    }

    public function login(Request $request)
    {
        $messages = [
            'login.required'    => 'กรุณากรอกอีเมล/ชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min'      => 'กรอกรหัสผ่านอย่างน้อย :min ตัวอักษร',
        ];

        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string|min:4',
        ], $messages);

        $login    = $request->input('login');
        $password = $request->input('password');

        try {
            // 🔹 admin
            if (Auth::guard('admin')->attempt([
                'st_name'  => $login,
                'password' => $password,
            ])) {
                $request->session()->regenerate();
                session(['st_name' => Auth::guard('admin')->user()->st_name]);
                return redirect()->intended('/dashboard');
            }

            // 🔹 user
            if (Auth::guard('web')->attempt([
                'user_email' => $login,
                'password'   => $password,
            ])) {
                $request->session()->regenerate();
                session(['user_name' => Auth::guard('web')->user()->user_name]);
                return redirect()->intended('/');
            }

            // 🔹 error → กลับไป tab login
            return redirect()->to('/?login=1')
                ->with('auth_error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง')
                ->withInput();
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {
        $messages = [
            'user_name.required' => 'กรุณากรอกข้อมูล',
            'user_name.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'user_name.unique'   => 'ชื่อถูกใช้ไปแล้ว!!',

            'user_email.required' => 'กรุณาระบุอีเมล',
            'user_email.email'    => 'กรอกอีเมลให้ถูกต้อง',
            'user_email.unique'   => 'อีเมลถูกใช้แล้ว!!',

            'user_password.required' => 'กรุณากรอกข้อมูล',
            'user_password.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัว',

            'user_address.required' => 'กรุณากรอกที่อยู่',

            'user_phone.required' => 'กรุณากรอกเบอร์โทร',
            'user_phone.min'      => 'กรุณากรอกเบอร์ให้ครบถ้วน',
            'user_phone.max'      => 'กรุณากรอกข้อมูลไม่เกิน :max ตัว',
        ];

        $validator = Validator::make($request->all(), [
            'user_name'     => 'required|min:3|unique:tbl_users,user_name',
            'user_email'    => 'required|email|unique:tbl_users,user_email',
            'user_password' => 'required|min:8',
            'user_address'  => 'required',
            'user_phone'    => 'required|min:10|max:10',
        ], $messages);

        if ($validator->fails()) {
            // 🔹 ส่งกลับไป modal tab register
            return redirect('/?register=1')
                ->withErrors($validator)
                ->with('auth_error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง')
                ->withInput();
        }

        try {
            $user = UserModel::create([
                'user_name'     => strip_tags($request->input('user_name')),
                'user_email'    => strip_tags($request->input('user_email')),
                'user_password' => bcrypt($request->input('user_password')),
                'user_address'  => strip_tags($request->input('user_address')),
                'user_phone'    => strip_tags($request->input('user_phone')),
            ]);

            Auth::guard('web')->login($user);
            Alert::success('สมัครสมาชิกสำเร็จ', 'ยินดีต้อนรับ ' . $user->user_name);

            return redirect('/');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
