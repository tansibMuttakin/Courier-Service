<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */

    public function index(){
        return view('login-registration.login');
    } 
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            if (Auth::user()->type == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if (! Auth::user()->approved) {
                Auth::logout();
                return redirect()->route('merchant.login')->with('status','You will be able to login
                once Admin varifies your account.');
            }
            return redirect()->route('dashboard');
        }
        return redirect()->route('merchant.login')->with('status','credentials does not match with the data');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('merchant.login');
    }
}