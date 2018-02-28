<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create() {
        return view('sessions.create');
    }

    public function store(Request $request) {
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials,$request->has('remember'))) {
            // 登入成功
            session()->flash('success','歡迎回來！');
            return redirect()->route('users.show',[Auth::user()]);
        } else {
            //登入失敗
            session()->flash('danger','很抱歉，帳號密碼輸入錯誤。');
            return redirect()->back();
        }
    }

    public function destory() {
        Auth::logout();
        session()->flash('success','您已成功登出！');
        return redirect('login');
    }
}
