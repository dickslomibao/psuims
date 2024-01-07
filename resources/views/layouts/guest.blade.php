<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            width: 100%;
            height: 100vh;
            margin: 0;
            padding: 0;
            background-image: url('/b1.png') !important;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .login {
            background-color: white;
            padding: 50px;
            width: 400px;
            border-radius: 10px;
        }

        .r {
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 50px;
        }

        p {
            margin: 15px 0;
            text-align: center
        }

        .r a {
            font-size: 15px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div>
        <center>
            <img src="/logo/LOGO 1.png" style="margin-bottom: 20px;height:100px" alt="" style=""
                srcset="">
        </center>
        <div class="login">
            {{ $slot }}
            <div class="r">
                <a href="/register">Don't have account yet? Sign up</a>
            </div>
        </div>
    </div>
</body>

</html>
