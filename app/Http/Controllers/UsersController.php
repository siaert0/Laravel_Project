<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //


    /**
     * UsersController constructor.
     */
    /*public function __construct()
    {
        $this->middleware('guest');
    }*/


    public function create(){
        return view('users.create');
    }

    public function store(Request $request){
        if($socialUser = \App\User::socialUser($request->get('email'))->first()){
            return $this->updateSocialAccount($request,$socialUser);
        }

        return $this->createNativeAccount($request);
    }

    public function confirm($code){
        $user = \App\User::whereConfirmCode($code)->first();

        if(! $user){
            flash('URL이 정확하지 않습니다.');
            return redirect('/');
        }

        $user->activated=1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);

        return $this->respondCreated(auth()->user()->name . '님 환영합니다. 가입이 확인 되었습니다.');
    }








    protected function respondCreated($message){
        flash($message);
        return redirect('/');
    }

    protected function updateSocialAccount(Request $request, \App\User $user){
        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ]);

        auth()->login($user);
        return $this->respondCreated($user->name .'님 환영합니다.');
    }


    protected function createNativeAccount(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $confirmCode = str_random(60);

        $user = \App\User::create([
            'name' => $request -> input('name'),
            'email' => $request -> input('email'),
            'password' => bcrypt($request ->input('password')),
            'confirm_code' => $confirmCode,
        ]);

        event(new \App\Events\UserCreated($user));
        return $this->respondCreated('가입하신 메일 계정으로 가입확인메일을 보냈습니다. 
        확인해 주시고 로그인 해 주세요.');
    }


}
