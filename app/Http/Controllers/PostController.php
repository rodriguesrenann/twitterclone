<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function makepost(Request $request){
        $loggedId = intval(Auth::id());
        $user = $this->getData($loggedId);
        $body = $request->only([
            'body'
        ]);

        $validator = Validator::make($body, [
            'body' => ['required', 'string', 'max:120']
        ]);

        if($validator->fails()){
            echo 'Errou!';
        }else{
            $newPost = new Post();
            $newPost->id_user = $loggedId;
            $newPost->data_post = date('Y-m-d H:i:s');
            $newPost->body = $body['body'];
            $newPost->save();

            return redirect('/'.$user['username'])->with('warning', 'Post feito');
        }

    }

    private function getData($id){
        $user = User::where('id', $id)->first();

        if($user){
            return $user;
        }else{
            return false;
        }
    }

    
}
