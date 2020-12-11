<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index(){
        return view('home.register');
    }

    public function registerAction(Request $request){
        $data = $request->only([
            'name',
            'username',
            'email',
            'password',
            'password_confirmation'
        ]);
        

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['email', 'string', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:4']
        ]);

        if($validator->fails()){
            return redirect()->route('register')->withErrors($validator)->withInput();
        }else {
            $newUser = new User();
            $newUser->name = $data['name'];
            $newUser->username = trim($data['username']);
            $newUser->email = $data['email'];
            $newUser->password = Hash::make($data['password']);
            $newUser->save();

            Auth::login($newUser);

            return redirect('/'.$data['username']);
        }

        
    }
}
