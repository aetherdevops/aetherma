@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 class="font-display text-3xl font-bold text-aether-ink">Dashboard</h1>
<div class="mt-8 grid gap-4 sm:grid-cols-3">
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Projects</p>
        <p class="mt-2 text-3xl font-bold text-aether-primary">{{ $projectCount }}</p>
    </div>
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Published</p>
        <p class="mt-2 text-3xl font-bold text-aether-primary">{{ $publishedCount }}</p>
    </div>
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Messages</p>
        <p class="mt-2 text-3xl font-bold text-aether-primary">{{ $messageCount }}</p>
    </div>
</div>

<div class="mt-10 rounded-xl bg-white p-6 shadow-sm">
    <div class="flex items-center justify-between">
        <h2 class="font-display text-xl font-bold">Recent messages</h2>
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-aether-primary">View all</a>
    </div>
    <ul class="mt-4 divide-y">
        @forelse ($recentMessages as $message)
            <li class="py-3">
                <p class="font-semibold">{{ $message->name }} <span class="font-normal text-slate-500">&lt;{{ $message->email }}&gt;</span></p>
                <p class="mt-1 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($message->message, 120) }}</p>
            </li>
        @empty
            <li class="py-3 text-sm text-slate-500">No messages yet.</li>
        @endforelse
    </ul>
</div>
@endsection
