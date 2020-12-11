<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Twitter">
    <meta name="author" content="Renan Rodrigues">
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Cadastro</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form method="POST" class="form-signin">
       @csrf 
      <input type="text" style="display:none">
      <input type="password" style="display:none">
      <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="80" height="80">
      <h1 class="h3 mb-3 font-weight-normal">Tela de cadastro</h1>
      <label for="email" class="sr-only">Nome completo</label>
      <input autocomplete="off" type="text" name="name" class="form-control" placeholder="Nome completo" required autofocus>
      <label for="email" class="sr-only">Endereço de e-mail</label>
      <input autocomplete="off" type="email" name="email" class="form-control" placeholder="Endereço de e-mail" required autofocus>
      <label for="email" class="sr-only">Nome de usuário</label>
      <input autocomplete="off" type="text" name="username" class="form-control" placeholder="Nome de usuário" required autofocus>
      <label for="email" class="sr-only">Senha</label>
      <input autocomplete="off" type="password" name="password" class="form-control" placeholder="Senha" required autofocus>
      
      <label for="password" class="sr-only">Confirme a senha</label>
      <input autocomplete="off" type="password" name="password_confirmation" class="form-control" placeholder="Confirmar senha" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Lembrar-me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Fazer cadastrado</button>
      <a href="{{route('register')}}" class="btn btn-lg btn-primary btn-block">Já possui conta? faça login</a>
      <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
  </body>
</html>