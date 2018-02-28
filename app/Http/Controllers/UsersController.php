<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Mail;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth',[
            'expect' => ['show','create','store','index','confirmEmail']   //除了這幾個function其他都要經過middleware
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
        $statuses - $user->statuses()
                            ->orderBy('created_dt','desc')
                            ->paginate(30);
        return view('users.show',compact('user', 'statuses'));
    }

    public function edit(User $user) {
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
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
        
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '註冊驗證信已發到您的信箱，請至信箱查收。');
        return redirect('/');
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

    public function destroy(User $user) {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','成功刪除用戶！');
        return back();
    }

    public function confirmEmail($token) {
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success','帳號驗證成功！');
        return redrect()->route('users.show',$user->id);
    }

    protected function sendEmailConfirmationTo($user) {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'abc@email.com';
        $name = 'admin';
        $to = $user->email;
        $subject = '感謝註冊Sample網站，請驗證您的信箱。';

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject){
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
}
