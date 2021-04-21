<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
 
        <title>Home</title>
    </head>
    <body>
        <div class="container">
            <div class="text-white bg-light border p-5">
                <div class="text-center p-5">

                    @if (Route::has('admin.login'))
                    @if (Auth::guard('admin')->check())
                        <a href={{route('login')}} class="btn btn-lg btn-primary">Entrar como usuário</a>
                        <a href={{route('register')}} class="btn btn-lg btn-primary">Cadastrar usuário</a>
                        <a href={{url('/admin/login')}} class="btn btn-lg btn-primary">Área de administrador</a>                                           
                    @else
                        @if (Route::has('login'))
                            @auth
                                <a href={{url('login')}} class="btn btn-lg btn-primary">Área de usuário</a>
                                <a href={{url('/admin/login')}} class="btn btn-lg btn-primary">Entrar como administrador</a>
                             @else
                                <a href={{route('login')}} class="btn btn-lg btn-primary">Entrar como usuário</a>
                                <a href={{url('/admin/login')}} class="btn btn-lg btn-primary">Entrar como administrador</a>

                                @if (Route::has('register'))
                                    <a href={{route('register')}} class="btn btn-lg btn-primary">Cadastrar usuário</a>
                                @endif
                            @endauth
                        @endif                
                    @endif                     
                @endif

                </div>
            </div>
       </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>
