<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Relation;

class UserController extends Controller
{
    public function __construct()
    {
        
    }

    public function index($slug){
        
        $loggedUser = intval(Auth::id());

        $user = User::where('username', $slug)->first();

        if($user){

        //Pegar seguidores
        $followersList = [];

        $followers = Relation::where('id_following', $user->id)->get();
        foreach($followers as $follower){
            $userData = User::where('id', $follower['id_follower'])->first();

            $newUser = new User();
            $newUser->id = $userData['id'];
            $newUser->username = $userData['username'];
            $newUser->name = $userData['name'];

            $followersList[] = $newUser;
            


        }
        //Pegar seguindo
        $following = Relation::where('id_follower', $user->id)->get();
        $followingCount = count($following);

        //isFollowing
        $isFollowing = false;
        if($loggedUser != $user->id){
            $isFollowing = $this->isFollowing($loggedUser, $user->id);
        }
        

        if($user->id != $loggedUser){
            $feed = $this->getUserFeed($user->id);
        }else {
            $feed = $this->getHomeFeed($user['id']);
        }
            return view('twitter.home', [
                'user' => $user,
                'feed' => $feed,
                'loggedUser' => $loggedUser,
                'followers' => $followersList,
                'following' => $followingCount,
                'isFollowing' => $isFollowing
            ]);
         }else{
             echo 'Usuário não cadastrado!';
         }

        
        
        
    }

    public function follow($id){
        $loggedId = Auth::id();
        $user = User::where('id', $id)->first();

        if($user){
            $relation = new Relation();
            $relation->id_follower = $loggedId;
            $relation->id_following = $id;
            $relation->save();
            
            return redirect('/'.$user['username']);
        }else{
            echo 'Usuário não encontrado';
        }
        
    }

    public function unfollow($id){
        $loggedId = Auth::id();
        $user = User::where('id', $id)->first();

        if($user){
            Relation::where('id_follower', $loggedId)->where('id_following', $id)->delete();
            return redirect('/'.$user['username']);
        }else{
            echo 'Usuário não encontrado';
        }

    }

    private function getHomeFeed($idUser){
        $userList = Relation::where('id_follower', $idUser)->get();
        $users = [];
        foreach($userList as $userItem){
            $users[] = $userItem['id_following'];
        }
        $users[] = $idUser;
        
        $postList = Post::whereIn('id_user', $users)->orderBy('data_post', 'desc')->get();
        $posts = [];

        foreach($postList as $postItem){
            $newPost = new Post();
            $newPost->id = $postItem['id'];
            $newPost->data_post = $postItem['data_post'];
            $newPost->body = $postItem['body'];

            $newUser = User::where('id', $postItem['id_user'])->first();
            $newPost->user = new User();
            $newPost->user->id = $newUser['id'];
            $newPost->user->name = $newUser['name'];
            $newPost->user->username = $newUser['username'];
            $posts[] = $newPost;
        }

        return $posts;

    }

    private function getUserFeed($idUser){
        $postList = Post::where('id_user', $idUser)->orderBy('data_post', 'desc')->get();
        $posts = [];

        foreach($postList as $postItem){
            $newPost = new Post();
            $newPost->id = $postItem['id'];
            $newPost->data_post = $postItem['data_post'];
            $newPost->body = $postItem['body'];

            $newUser = User::where('id', $postItem['id_user'])->first();
            $newPost->user = new User();
            $newPost->user->id = $newUser['id'];
            $newPost->user->name = $newUser['name'];
            $newPost->user->username = $newUser['username'];
            $posts[] = $newPost;
        }

        return $posts;
    }

    private function isFollowing($loggedId, $userId){
        $user = Relation::where('id_follower', $loggedId)->where('id_following', $userId)->first();
        if($user){
            return true;
        }else{
            return false;
        }
    }
}
