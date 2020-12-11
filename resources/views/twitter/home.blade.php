<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/app.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <div class="row">
        <div class="col-sm">
            <div class="sidebar">{{$user->username}} || @if ($loggedUser != $user->id)
                    @if ($isFollowing==false)
                        <a class="btn btn-primary" href="{{route('follow', ['id' => $user->id])}}">Seguir</a>      
                    @else
                        <a class="btn btn-primary "href="{{route('unfollow', ['id' => $user->id])}}">Parar de seguir</a>                        
                    @endif
                    
            @endif</div>
        </div>
        <div class="col-sm">
            <div class="postarea">
                <div class="makeposts">
                    <form action="{{route('make.post')}}" method="POST">
                        @csrf
                        <textarea name="body" id="" cols="30" rows="10">
                
                        </textarea>
                        <input type="submit" value="Fazer post" id="">
                    </form>   
                </div> 
                <h1>Posts de {{$user->username}}</h1>
                <ul>
                 @foreach ($feed as $item)
                     <div class="username">{{$item['user']['username']}}</div>
                     <div class="post">{{$item['body']}}</div>
                 @endforeach
                </ul>
             </div>
        </div>
        <div class="col-sm">
            <div class="user-info">Seguidores:{{count($followers)}} | Seguindo: {{$following}} | <a href="{{route('logout')}}">Logout</a></div>
        </div>
      </div>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
