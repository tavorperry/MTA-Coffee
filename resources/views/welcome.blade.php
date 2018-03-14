<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome</title>
    </head>
    <body>
        @if(Auth::user())
        <div>
            <h1>Welcome, {{ Auth::user()->first_name }}</h1>
            <a href="{{ route('logout') }}">Logout</a>
        </div>
        @else
        <div>
            <h1>Welcome to MTAcoffee!</h1>
            <a href="{{ route('login') }}">Login</a>
        </div>
        @endif
    </body>
</html>
