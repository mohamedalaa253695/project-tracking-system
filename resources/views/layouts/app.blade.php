<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="theme-light bg-page ">
    <div id="app">
        <nav class="bg-header section">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-1">
                    <logo></logo>

                    <div>
                        <!-- Right Side Of Navbar -->
                        <div class="flex items-center ml-auto ">
                            <!-- Authentication Links -->
                            @guest
                                <div>
                                    <a href="{{ route('login') }}">
                                        <button class="login-btn font-medium text-base">Login</button>
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}">
                                            <button class="register-btn font-medium text-base">Register</button>
                                        </a>
                                    @endif

                                </div>
                            @else
                                <theme-switcher></theme-switcher>
                                <dropdown align="right" width="200px">
                                    <template v-slot:trigger>
                                        <button
                                            class="flex items-center text-default no-underline text-sm focus:outline-none"
                                            v-pre>
                                            <img width="35" class="rounded-full mr-3"
                                                src="{{ gravatar_url(auth()->user()->email) }}">
                                            {{ auth()->user()->name }}
                                        </button>
                                    </template>

                                    <form id="logout-form" method="POST" action="/logout">
                                        @csrf
                                        <button type="submit" class="dropdown-menu-link w-full text-left">Logout</button>
                                    </form>
                                </dropdown>

                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="section">
            <main class="container mx-auto py-6">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('footer-scripts')
</body>

</html>
