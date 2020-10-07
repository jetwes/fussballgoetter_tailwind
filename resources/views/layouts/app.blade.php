<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="manifest" href="/site.webmanifest">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script>
    @yield('js-head')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @yield('styles-head')
</head>
<body>
    <div id="app" x-data="{ sidebarOpen: false }">
        @if(auth()->id())
            @include('layouts.nav')
        @endif
        @yield('content')
    </div>
@yield('js-body')
<footer class="bg-white">
  <div class="max-w-screen-xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
    <div class="mt-8 md:mt-0 md:order-1">
      <p class="text-center text-base leading-6 text-gray-400">
        &copy; 2020 Jens Twesmann, Quelltext/source code: <a href="https://github.com/jetwes/fussballgoetter_tailwind" class="hover:text-gray-700">Github Repository</a>
      </p>
    </div>
  </div>
</footer>
</body>
</html>
