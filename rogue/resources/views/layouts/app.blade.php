<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rogue') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                   <img id="logo_navbar"  src="/images/Allblack1.png" alt="Logo"/>

                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('explore') }}">Explore</a>
                        </li>
                    </ul>
                    @endauth

                    <!-- Center of Navbar -->
                    <ul class="navbar-nav ml-auto mr-auto">
                                <form method="post" action="{{ url('/search') }}">
                                    @csrf
                                    <input type="text" placeholder="Search" name="search" class="form-control mt-2" style="width: 350px;">
                                </form>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                        <!--create post button-->

                        <li class="nav-item">
                                <a class="nav-link" href="{{ url('/posts/create') }}">{{ __('Post Image') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/profile') }}">{{ '@'.Auth::user()->username }}
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="badge badge-danger">{{ Auth::user()->unreadNotifications->count()  }}</span>
                            @endif
                            </a>
                        </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
