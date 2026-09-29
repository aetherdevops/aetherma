@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4">
    <h1 class="font-display text-3xl font-bold text-aether-ink">Contact messages</h1>
    <form method="POST" action="{{ route('admin.messages.read-all') }}">
        @csrf
        @method('PATCH')
        <button class="rounded-md px-3 py-2 text-sm text-aether-primary hover:bg-white">Mark all as read</button>
    </form>
</div>

<nav class="mt-6 flex gap-2 text-sm" aria-label="Filter messages">
    @foreach (['all' => 'All', 'unread' => 'Unread'] as $key => $label)
        <a href="{{ route('admin.messages.index', $key === 'all' ? [] : ['filter' => $key]) }}" @class([
            'rounded-full px-4 py-1.5',
            'bg-aether-primary text-white' => $filter === $key,
            'bg-white text-slate-600 hover:bg-slate-50' => $filter !== $key,
        ])>{{ $label }}</a>
    @endforeach
</nav>

<div class="mt-6 space-y-4">
    @forelse ($messages as $message)
        <div @class([
            'rounded-xl bg-white p-5 shadow-sm',
            'ring-2 ring-aether-soft/60' => ! $message->isRead(),
        ])>
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="font-semibold">
                        @unless ($message->isRead())
                            <span class="mr-1 inline-block h-2 w-2 rounded-full bg-aether-soft align-middle" aria-hidden="true"></span><span class="sr-only">Unread: </span>
                        @endunless
                        {{ $message->name }}
                    </p>
                    <p class="text-sm text-slate-500">{{ $message->email }} · <time datetime="{{ $message->created_at->toIso8601String() }}" title="{{ $message->created_at->format('Y-m-d H:i') }}">{{ $message->created_at->diffForHumans() }}</time></p>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <a href="{{ $message->replyUrl() }}" class="font-semibold text-aether-primary hover:underline">Reply</a>
                    <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
                        @csrf
                        @method('PATCH')
                        <button class="text-slate-600 hover:underline">{{ $message->isRead() ? 'Mark unread' : 'Mark read' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete message?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
            <p class="mt-3 whitespace-pre-wrap break-words text-slate-700">{{ $message->message }}</p>
        </div>
    @empty
        <p class="text-slate-500">{{ $filter === 'unread' ? 'No unread messages — you\'re all caught up.' : 'No messages yet.' }}</p>
    @endforelse
</div>

<div class="mt-6">{{ $messages->links() }}</div>
@endsection
