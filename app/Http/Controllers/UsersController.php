<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth',[
            'expect' => ['show','create','store','index']   //除了這幾個function其他都要經過middleware
        ]);

        $this->middleware('guest', [
            'only' => ['create']    //只有未登入可以看到註冊頁
        ]);
    }

    public function index() {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    public function create() {
        return view('users.create');
    }

    public function show(User $user) {
        return view('users.show',compact('user'));
    }

    public function store(Request $request) {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        Auth::login($user);
        session()->flash('success', '歡迎，您將在這裡開啟一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user) {
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user, Request $request) {
        $this->authorize('update', $user);

        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        $session->flash('success','個人資料更新成功！');

        return redirect()->route('users.show',$user->id);
    }
}
