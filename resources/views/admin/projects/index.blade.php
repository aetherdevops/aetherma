@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4">
    <h1 class="font-display text-3xl font-bold text-aether-ink">Projects</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">Add project</a>
</div>

<div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">
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
                                <p class="text-xs text-slate-500">/{{ $project->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">{{ $project->is_published ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-3">{{ $project->sort_order }}</td>
                    <td class="px-4 py-3 text-right">
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
