<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Æther</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@600;700&family=Mulish:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100">
<div class="flex min-h-screen">
    <aside class="hidden w-64 shrink-0 bg-aether-ink p-6 text-white md:block">
        <a href="{{ route('admin.dashboard') }}" class="font-display text-xl font-bold">Æther Admin</a>
        <nav class="mt-10 space-y-2 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="block rounded-md px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}">Dashboard</a>
            <a href="{{ route('admin.projects.index') }}" class="block rounded-md px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.projects.*') ? 'bg-white/10' : '' }}">Projects</a>
            <a href="{{ route('admin.messages.index') }}" class="block rounded-md px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.messages.*') ? 'bg-white/10' : '' }}">Messages</a>
            <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 hover:bg-white/10" target="_blank">View site</a>
            <form method="POST" action="{{ route('logout') }}" class="pt-4">
                @csrf
                <button class="block w-full rounded-md px-3 py-2 text-left hover:bg-white/10">Log out</button>
            </form>
        </nav>
    </aside>
    <div class="flex-1">
        <header class="flex items-center justify-between border-b bg-white px-6 py-4 md:hidden">
            <span class="font-display font-bold">Æther Admin</span>
            <a href="{{ route('admin.projects.index') }}" class="text-sm text-aether-primary">Projects</a>
        </header>
        <main class="p-6 md:p-10">
            @if (session('status'))
                <div class="mb-6 rounded-md bg-aether-cream px-4 py-3 text-sm text-aether-primary">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
