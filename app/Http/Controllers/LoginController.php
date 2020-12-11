<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class LoginController extends Controller
{
    public function index() {
        return view('home.login');
    }

    public function authenticate(Request $request){
        $data = $request->only([
            'email',
            'password'
        ]);
        
        $validator = Validator::make($data, [
            'email' => ['required', 'max:100', 'string', 'email'],
            'password' => ['required', 'min:4', 'string']
        ]);

        if($validator->fails()){
            return redirect()->route('login')->withErrors($validator)->withInput();
        }
        
        $remember = $request->input('remember', false);

        
        if(Auth::attempt($data, $remember)){
            
            $data = $this->getData($data['email']);

            return redirect('/'.$data['username']);
        }else {
            $validator->errors()->add('password', 'E-mail e/ou senha incorretos!');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    private function getData($email){
        $data = User::where('email', $email)->first();

        if($data){
            return $data;
        }else {
            return false;
        }

        
    }
}
