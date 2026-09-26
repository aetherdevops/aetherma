<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') — Æther</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin.js'])
</head>
<body class="min-h-screen bg-slate-100">
@php
    $unreadMessages = \App\Models\ContactMessage::unread()->count();
    $adminLinks = [
        ['admin.dashboard', 'admin.dashboard', 'Dashboard', null],
        ['admin.projects.index', 'admin.projects.*', 'Projects', null],
        ['admin.testimonials.index', 'admin.testimonials.*', 'Testimonials', null],
        ['admin.messages.index', 'admin.messages.*', 'Messages', $unreadMessages ?: null],
        ['profile.edit', 'profile.*', 'Account', null],
    ];
    // Breeze's account forms flash these codes for their own inline "Saved." notes.
    $flash = in_array(session('status'), ['profile-updated', 'password-updated', 'verification-link-sent'], true) ? null : session('status');
@endphp
<div class="flex min-h-screen" x-data="{ menu: false }" @keydown.escape.window="menu = false">
    {{-- Sidebar: fixed on desktop, slide-over on mobile --}}
    <div x-show="menu" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-aether-ink/50 md:hidden" @click="menu = false"></div>
    <aside class="fixed inset-y-0 left-0 z-50 w-64 shrink-0 -translate-x-full bg-aether-ink p-6 text-white transition-transform md:static md:translate-x-0"
           :class="menu && '!translate-x-0'" aria-label="Admin">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="font-display text-xl font-bold">Æther Admin</a>
            <button type="button" class="rounded p-1 hover:bg-white/10 md:hidden" @click="menu = false" aria-label="Close menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>
        <nav class="mt-10 space-y-1 text-sm">
            @foreach ($adminLinks as [$route, $pattern, $label, $badge])
                <a href="{{ route($route) }}" @class([
                    'flex items-center justify-between rounded-md px-3 py-2 hover:bg-white/10',
                    'bg-white/10' => request()->routeIs($pattern),
                ]) @if (request()->routeIs($pattern)) aria-current="page" @endif>
                    <span>{{ $label }}</span>
                    @if ($badge)
                        <span class="rounded-full bg-aether-soft px-2 text-xs font-semibold">{{ $badge }}<span class="sr-only"> unread</span></span>
                    @endif
                </a>
            @endforeach
            <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 hover:bg-white/10" target="_blank" rel="noopener">View site &nearr;</a>
            <form method="POST" action="{{ route('logout') }}" class="pt-4">
                @csrf
                <button class="block w-full rounded-md px-3 py-2 text-left hover:bg-white/10">Log out</button>
            </form>
        </nav>
    </aside>
    <div class="min-w-0 flex-1">
        <header class="flex items-center justify-between border-b bg-white px-6 py-4 md:hidden">
            <span class="font-display font-bold">Æther Admin</span>
            <button type="button" class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm text-aether-primary hover:bg-slate-100"
                    @click="menu = true" :aria-expanded="menu.toString()">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                Menu
                @if ($unreadMessages)
                    <span class="rounded-full bg-aether-primary px-2 text-xs font-semibold text-white">{{ $unreadMessages }}</span>
                @endif
            </button>
        </header>
        <main class="p-6 md:p-10">
            @if ($flash)
                <div class="mb-6 rounded-md bg-aether-cream px-4 py-3 text-sm text-aether-primary" role="status">{{ $flash }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
