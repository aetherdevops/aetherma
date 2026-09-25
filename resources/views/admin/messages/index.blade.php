@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<h1 class="font-display text-3xl font-bold text-aether-ink">Contact messages</h1>

<div class="mt-8 space-y-4">
    @forelse ($messages as $message)
        <div class="rounded-xl bg-white p-5 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="font-semibold">{{ $message->name }}</p>
                    <p class="text-sm text-slate-500">{{ $message->email }} · {{ $message->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete message?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-sm text-red-600 hover:underline">Delete</button>
                </form>
            </div>
            <p class="mt-3 whitespace-pre-wrap text-slate-700">{{ $message->message }}</p>
        </div>
    @empty
        <p class="text-slate-500">No messages yet.</p>
    @endforelse
</div>

<div class="mt-6">{{ $messages->links() }}</div>
@endsection
