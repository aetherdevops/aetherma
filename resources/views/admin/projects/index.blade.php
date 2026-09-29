@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4">
    <h1 class="font-display text-3xl font-bold text-aether-ink">Projects</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">Add project</a>
</div>

<div class="mt-8 overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="bg-slate-50 text-slate-500">
            <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Published</th>
                <th class="px-4 py-3">Order</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($projects as $project)
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if ($project->coverUrl())
                                <img src="{{ $project->coverUrl() }}" alt="" class="h-12 w-16 rounded object-cover">
                            @endif
                            <div>
                                <p class="font-semibold">{{ $project->title }}</p>
                                <p class="text-xs text-slate-500">/{{ $project->slug }} · {{ $project->media_count }} gallery {{ Str::plural('item', $project->media_count) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.projects.toggle', $project) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" title="{{ $project->is_published ? 'Click to hide from the site' : 'Click to publish' }}" @class([
                                'rounded-full px-2.5 py-0.5 text-xs font-semibold',
                                'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' => $project->is_published,
                                'bg-slate-100 text-slate-600 hover:bg-slate-200' => ! $project->is_published,
                            ])>{{ $project->is_published ? 'Live' : 'Hidden' }}</button>
                        </form>
                    </td>
                    <td class="px-4 py-3">{{ $project->sort_order }}</td>
                    <td class="px-4 py-3 text-right">
                        @if ($project->is_published)
                            <a href="{{ route('portfolio.show', $project) }}" class="mr-3 text-slate-600 hover:underline" target="_blank" rel="noopener">View</a>
                        @endif
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-aether-primary hover:underline">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="ml-3 inline" onsubmit="return confirm('Delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $projects->links() }}</div>
@endsection
