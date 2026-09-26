@extends('layouts.admin')

@section('title', 'Account')

@section('content')
<h1 class="font-display text-3xl font-bold text-aether-ink">Account</h1>

<div class="mt-8 max-w-2xl space-y-6">
    <div class="rounded-xl bg-white p-6 shadow-sm">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        @include('profile.partials.update-password-form')
    </div>
</div>
@endsection
