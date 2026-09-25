<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Æther Marketing Agency')</title>
    <meta name="description" content="@yield('description', 'Making your business profitable for today & tomorrow. Let your brand\'s story spark across digital aether.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@500;600;700&family=Mulish:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-aether-mist/90 backdrop-blur">
        <div class="container-narrow flex items-center justify-between gap-6 px-6 py-4 md:px-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('media/logo.webp') }}" alt="Æther" class="h-10 w-auto">
                <span class="font-display text-lg font-bold text-aether-primary">Æther</span>
            </a>
            <nav class="hidden items-center gap-7 md:flex">
                <a class="nav-link" href="{{ route('home') }}#top">Home</a>
                <a class="nav-link" href="{{ route('home') }}#services">Services</a>
                <a class="nav-link" href="{{ route('home') }}#about">Our Story</a>
                <a class="nav-link" href="{{ route('home') }}#clients">Portfolio</a>
                <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
            </nav>
            <a href="{{ route('home') }}#contact" class="btn-primary !px-4 !py-2 text-xs">Contact</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-aether-ink text-aether-cream">
        <div class="container-narrow section-pad !py-12">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="font-display text-xl font-bold">Æther Marketing Agency</p>
                    <p class="mt-2 max-w-md text-sm text-aether-cream/70">Making your business profitable for today &amp; tomorrow.</p>
                </div>
                <div class="flex gap-5 text-sm">
                    <a href="{{ route('home') }}#services" class="hover:text-white">Services</a>
                    <a href="{{ route('home') }}#clients" class="hover:text-white">Portfolio</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-white">Contact</a>
                    <a href="{{ route('login') }}" class="hover:text-white">Admin</a>
                </div>
            </div>
            <p class="mt-8 border-t border-white/10 pt-6 text-xs text-aether-cream/50">&copy; {{ date('Y') }} Æther Marketing Agency</p>
        </div>
    </footer>
</body>
</html>
