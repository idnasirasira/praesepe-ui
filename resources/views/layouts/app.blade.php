<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="praesepe">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('ui-docs.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Copy-paste Blade components for Laravel with Tailwind CSS 4 and Alpine.js 3.')">
    <link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml">
    <link rel="icon" href="/favicon-32x32.png?v=2" type="image/png" sizes="32x32">
    <link rel="alternate icon" href="/favicon.ico?v=2" sizes="any">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png?v=2">
    <meta name="theme-color" content="#4745b3">
    <script>
        (function () {
            try {
                var theme = localStorage.getItem('praesepe-ui.theme') || 'praesepe';
                var scheme = localStorage.getItem('praesepe-ui.color-scheme') || 'system';
                var root = document.documentElement;
                root.setAttribute('data-theme', theme);
                var dark = scheme === 'dark' || (scheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                root.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-dvh bg-surface text-fg antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-control focus:bg-brand focus:px-3 focus:py-2 focus:text-on-brand">
        Skip to content
    </a>

    @yield('body')

    <x-ui.toast-viewport />

    @stack('scripts')
</body>
</html>
