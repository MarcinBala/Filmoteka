<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="/img/favicon.png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@1,700&display=swap" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @yield('fonts')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">

                <a class="navbar-brand d-flex" href="{{ url('/') }}">
                    <img class="logo" src="/img/Filmoteka_Logo.png">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <form action="{{route('search.index')}}" method="GET" id="searchForm" autocomplete="off">
                            <div class="search-bar">
                                <img id="search" src="/img/Search_Icon.png">
                                <input type="text" name="search" required placeholder="Szukaj"/>
                            </div>
                        </form>
                    </ul>
                </div>

                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="login-btn" href="{{ route('login') }}">{{ __('Zaloguj się') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <div></div>
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if ( empty(Auth::user()->avatar) )
                                    <img src="/img/User_Icon.png" style="height: 20px">
                                @else
                                    <img src="/storage/{{Auth::user()->avatar}}" style="height: 20px">
                                @endif
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="z-index:2147483647">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Wyloguj') }}
                                </a>

                                <a class="dropdown-item" href="{{ url('/user/'.Auth::user()->username) }}">
                                    {{ __('Profil') }}
                                </a>

                                @if(Auth::user()->user_type == 'admin')
                                    <a class="dropdown-item" href="{{ route('news.create') }}">
                                        {{ __('Dodaj News') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('film.create') }}">
                                        {{ __('Dodaj Film') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('actor.create') }}">
                                        {{ __('Dodaj Aktora') }}
                                    </a>
                                @endif

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <nav class="shadow text-center menu">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-4 col-md-2 text-center menu-section-container @if(Request::segment(1) == 'news') hover @endif">
                        <a href="/news"><div class="menu-section">AKTUALNOŚCI</div></a>
                    </div>
                    <div class="col-4 col-md-2 text-center menu-section-container @if(Request::segment(1) == 'films') hover @endif">
                        <a href="/films"><div class="menu-section">FILMY</div></a>
                    </div>
                    <div class="col-4 col-md-2 text-center menu-section-container @if(Request::segment(1) == 'releases') hover @endif">
                        <a href="/releases/1"><div class="menu-section">PREMIERY</div></a>
                    </div>
                    <div class="col-4 col-md-2 text-center menu-section-container @if(Request::segment(1) == 'discover') hover @endif">
                        <a href="/discover"><div class="menu-section">ODKRYJ</div></a>
                    </div>
                    <div class="col-4 col-md-2 text-center menu-section-container @if(Request::segment(1) == 'forum') hover @endif">
                        <a href="/forum"><div class="menu-section">FORUM</div></a>
                    </div>
                </div>
            </div>
        </nav>

        @if(Session::has('msg'))
            <div class="d-flex justify-content-center"><span class="session-success-msg">{{Session::get('msg')}}</span></div>
        @endif
        @if(Session::has('error-msg'))
            <div class="d-flex justify-content-center"><span class="session-error-msg">{{Session::get('error-msg')}}</span></div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>

    </div>

    <footer>Filmoteka</footer>

    @yield('scripts')
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
</body>
<script>

</script>

</html>
