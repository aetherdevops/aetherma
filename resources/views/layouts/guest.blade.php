<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>Sign in — {{ config('site.name') }}</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-aether-ink antialiased">
        <div class="flex min-h-screen flex-col items-center bg-aether-mist px-4 pt-10 sm:justify-center sm:pt-0">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('media/logo.webp') }}" alt="" width="56" height="56" class="h-14 w-14">
                <span class="font-display text-2xl font-bold text-aether-primary">Æther</span>
            </a>

            <div class="mt-8 w-full overflow-hidden rounded-2xl bg-white px-6 py-6 shadow-sm ring-1 ring-aether-line/60 sm:max-w-md">
                {{ $slot }}
            </div>

            <a href="{{ route('home') }}" class="mt-6 text-sm text-aether-accent hover:text-aether-primary">&larr; Back to the website</a>
        </div>
    </body>
</html>
