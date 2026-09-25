@php
    $isEdit = isset($project) && $project;
@endphp

<h1 class="font-display text-3xl font-bold text-aether-ink">{{ $isEdit ? 'Edit project' : 'Add project' }}</h1>

<form method="POST"
      action="{{ $isEdit ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
      enctype="multipart/form-data"
      class="mt-8 max-w-3xl space-y-5 rounded-xl bg-white p-6 shadow-sm">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div>
        <label class="mb-1 block text-sm font-semibold" for="title">Title</label>
        <input id="title" name="title" value="{{ old('title', $project->title ?? '') }}" required class="w-full rounded-md border-slate-300">
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold" for="slug">Slug (optional)</label>
        <input id="slug" name="slug" value="{{ old('slug', $project->slug ?? '') }}" class="w-full rounded-md border-slate-300">
        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold" for="client_name">Client name</label>
        <input id="client_name" name="client_name" value="{{ old('client_name', $project->client_name ?? '') }}" class="w-full rounded-md border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold" for="excerpt">Excerpt</label>
        <textarea id="excerpt" name="excerpt" rows="2" class="w-full rounded-md border-slate-300">{{ old('excerpt', $project->excerpt ?? '') }}</textarea>
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold" for="body">Body (HTML allowed)</label>
        <textarea id="body" name="body" rows="8" class="w-full rounded-md border-slate-300 font-mono text-sm">{{ old('body', $project->body ?? '') }}</textarea>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-semibold" for="completed_at">Completed at</label>
            <input id="completed_at" type="date" name="completed_at" value="{{ old('completed_at', isset($project) && $project->completed_at ? $project->completed_at->format('Y-m-d') : '') }}" class="w-full rounded-md border-slate-300">
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold" for="sort_order">Sort order</label>
            <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" class="w-full rounded-md border-slate-300">
        </div>
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold" for="cover">Cover image</label>
        <input id="cover" type="file" name="cover" accept="image/*" class="w-full text-sm">
        @if ($isEdit && $project->coverUrl())
            <img src="{{ $project->coverUrl() }}" alt="" class="mt-3 h-28 rounded object-cover">
        @endif
        @error('cover') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published ?? true))>
        Published on public site
    </label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">{{ $isEdit ? 'Save changes' : 'Create project' }}</button>
        <a href="{{ route('admin.projects.index') }}" class="rounded-md px-4 py-3 text-sm text-slate-600 hover:bg-slate-100">Cancel</a>
    </div>
</form>
