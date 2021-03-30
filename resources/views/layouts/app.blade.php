<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="img/favicon.ico" rel="icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-stripped shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <font-awesome-icon :icon="['fa', 'user']" class="fa-icon"
                                                   fixed-width></font-awesome-icon>
                                {{ __('main.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <font-awesome-icon :icon="['fa', 'user-plus']" class="fa-icon"
                                                       fixed-width></font-awesome-icon>
                                    {{ __('main.register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <font-awesome-icon :icon="['fas', 'bell']" class="fa-icon"
                                                   fixed-width></font-awesome-icon>
                                {{ __('menu.notifications') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                <font-awesome-icon :icon="['fas', 'tools']" class="fa-icon"
                                                   fixed-width></font-awesome-icon>
                                {{ __('menu.tools') }}
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <router-link class="dropdown-item"
                                                 to='/weather'>
                                        <font-awesome-icon :icon="['fas', 'cloud-sun']" class="fa-icon"
                                                           fixed-width></font-awesome-icon>
                                        {{ __('weather.check_weather_for_basketball') }}</router-link>
                                </li>
                                <li>
                                    <router-link class="dropdown-item"
                                                 to='/radiation-info'>
                                        <font-awesome-icon :icon="['fas', 'radiation']" class="fa-icon"
                                                           fixed-width></font-awesome-icon>
                                        {{ __('main.radiation.radiation_background') }}</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <font-awesome-icon :icon="['fa', 'user']" class="fa-icon"
                                                   fixed-width></font-awesome-icon>
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <font-awesome-icon :icon="['fas', 'sign-out-alt']" class="fa-icon"
                                                       fixed-width></font-awesome-icon>
                                    {{ __('main.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
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
