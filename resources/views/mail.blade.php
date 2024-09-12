<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-primary {
            background-color: #1e9a2c;
        }
    </style>
</head>

<body>
    <div style="padding: 50px">
        <img style="display: block; margin: 0 auto; width: 200px" src="{{ asset('assets/img/logo.png') }}"
            alt="biodivcenter">
        <h1 style="font-size: 20px">Bienvenue sur BiodivCenter M/Mme {{ $user->name }}</h1>
        <p>
            Vous avez été ajouté sur la plateforme BiodivCenter en tant que {{ $user->role_label }} de
            {{ $user->ong->name }} @if ($user->role == 'agent')
                sur le site {{ $user->site->name }}
            @endif. Vos identifiants de connexion :
        <ul>
            <li>Email : {{ $user->email }}</li>
            <li>Mot de passe : {{ $password }}</li>
        </ul>
        </p>
        @if ($user->role == 'agent')
            <p>
                Télécharger l'application BiodivCenter <br>
                <button class="bg-primary" style="padding: 5px 10px; border-radius: 5px"><a
                        style="color: #fff">Télécharger</a></button>
            </p>
        @else
            <p>
                Cliquez sur le lien ci-dessous pour vous connecter. <br>
                <button class="bg-primary" style="padding: 5px 10px; border-radius: 5px; border: none"><a style="color: #fff; text-decoration: none"
                        href="{{ route('login') }}">Se connecter</a></button>
            </p>
        @endif
        <p style="font-weight: bold; font-size: 12px; font-style: italic">
            Cordialement, L'équipe BiodivCenter.
        </p>
    </div>

</body>

</html>
