<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Vendors -->
        <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('vendors/mazer/app.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/mazer/bootstrap5.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/mazer/auth.css') }}">

        <style>
            #auth #auth-left .auth-logo {
                margin-bottom: 0;
            }
            #auth #auth-left .auth-logo img {
                height: 5rem;
            }
            #auth #auth-left {
                padding: 4rem 8rem;
            }
            @media screen and (max-width: 767px){
                #auth #auth-left {
                    padding: 1rem 4rem;
                }
            }
        </style>

        <!-- Scripts -->
        <script src="{{ asset('vendors/mazer/app.js') }}" defer></script>
    </head>
    <body>
        <div id="auth">
            <div class="row h-100">
                <div class="col-lg-6 col-12">
                    @yield('content')
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div id="auth-right">

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
