<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    
    function panel()
    {
    
        return view('settings.panel');
    }

    public function authenticate(Request $request)
    {
        $password = $request->pwd;

        $user = auth()->user();

        if (Hash::check($password, $user->password)) {
            Session::put('auth', 'true');
            // Session::forget('auth');
            return redirect('/settings/panel');
        } else {
            return redirect()->back()->withErrors(['잘못된 비밀번호입니다']);
        }

    }
}
