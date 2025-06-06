<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = User::where('email', $credentials['email'])->first();               //ดึงข้อมูลผู้ทำการ login
            $user->tokens()->delete();                                                  //ลบข้อมูลเดิมออกก่อน
            $token = $user->createToken($request['email']);                             //สร้าง token ขึ้นมาใหม่เก็บไว้ใน table personal_access_tokens

            return response()->json([
                'message' => 'Login Success!',
                'token' => $token->plainTextToken                                       //ส่งค่ากลับคืนไป โดยค่านี้จะถูกเข้ารหัส
            ]);
        } else {
            return response()->json([
                'message' => 'The provided credentials do not match our records.'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logout Success!'
        ]);
    }

    public function guard($guard = 'web')
    {
        return Auth::guard($guard);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
