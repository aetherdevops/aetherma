<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Æther Marketing Agency')</title>
    <meta name="description" content="@yield('description', 'Making your business profitable for today & tomorrow. Let your brand\'s story spark across digital aether.')">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" href="{{ asset('favicon-192.png') }}" type="image/png" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@500;600;700&family=Mulish:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
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
                <img src="{{ asset('media/logo.webp') }}" alt="Æther" width="40" height="40" class="h-10 w-auto">
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
