<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $site = config('site');
        $pageTitle = trim($__env->yieldContent('title')) ?: $site['name'];
        $pageDescription = trim($__env->yieldContent('description')) ?: $site['description'];
        $ogImage = trim($__env->yieldContent('og_image')) ?: asset($site['og_image']);
        $canonical = url()->current();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:site_name" content="{{ $site['name'] }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="theme-color" content="#124559">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" href="{{ asset('favicon-192.png') }}" type="image/png" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.structured-data')
    @stack('head')
    @include('partials.analytics')
</head>
<body class="min-h-screen">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:shadow">Skip to content</a>
    @php
        $navLinks = [
            'top' => 'Home',
            'services' => 'Services',
            'about' => 'Our Story',
            'clients' => 'Portfolio',
            'contact' => 'Contact',
        ];
    @endphp
    <header x-data="{ open: false }" @keydown.escape.window="open = false" class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-aether-mist/90 backdrop-blur">
        <div class="container-narrow flex items-center justify-between gap-6 px-6 py-4 md:px-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('media/logo.webp') }}" alt="" width="40" height="40" class="h-10 w-auto">
                <span class="font-display text-lg font-bold text-aether-primary">Æther</span>
            </a>
            <nav class="hidden items-center gap-7 md:flex" aria-label="Main">
                @foreach ($navLinks as $anchor => $label)
                    <a class="nav-link" href="{{ route('home') }}#{{ $anchor }}">{{ $label }}</a>
                @endforeach
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#contact" class="btn-primary !px-4 !py-2 text-xs">Contact</a>
                <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-aether-ink hover:bg-aether-line/40 md:hidden"
                        @click="open = ! open" :aria-expanded="open.toString()" aria-controls="mobile-nav" aria-label="Toggle menu">
                    <svg x-show="! open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                    <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
        </div>
        <nav id="mobile-nav" x-show="open" x-cloak x-transition.opacity @click.outside="open = false" class="border-t border-aether-line/60 bg-aether-mist md:hidden" aria-label="Mobile">
            <div class="flex flex-col px-6 py-3">
                @foreach ($navLinks as $anchor => $label)
                    <a class="nav-link py-3" href="{{ route('home') }}#{{ $anchor }}" @click="open = false">{{ $label }}</a>
                @endforeach
            </div>
        </nav>
    </header>

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.cookie-banner')
</body>
</html>
