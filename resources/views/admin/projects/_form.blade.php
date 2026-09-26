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
        <textarea id="excerpt" name="excerpt" rows="2" maxlength="255" class="w-full rounded-md border-slate-300">{{ old('excerpt', $project->excerpt ?? '') }}</textarea>
        <p class="mt-1 text-xs text-slate-500">One or two sentences. Shown on the portfolio card and in Google / social link previews.</p>
        @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold" for="body-editor">Description</label>
        <input id="body" type="hidden" name="body" value="{{ old('body', $project->body ?? '') }}">
        <trix-editor id="body-editor" input="body" class="trix-content prose prose-aether min-h-[14rem] max-w-none rounded-md border border-slate-300 bg-white"></trix-editor>
        @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
        <p class="mt-1 text-xs text-slate-500">Shown on the portfolio card (5:4 crop) and as the social preview image. Max 5 MB.</p>
        @if ($isEdit && $project->coverUrl())
            <img src="{{ $project->coverUrl() }}" alt="" class="mt-3 h-28 rounded object-cover">
        @endif
        @error('cover') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <fieldset class="rounded-lg border border-slate-200 p-4">
        <legend class="px-1 text-sm font-semibold">Gallery</legend>
        <p class="text-xs text-slate-500">Extra images or short videos shown on the project page (JPG, PNG, WebP, GIF, MP4, WebM — up to 20 MB each). Export images at around 1600px wide.</p>

        @if ($isEdit && $project->media->isNotEmpty())
            <ul class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($project->media as $media)
                    <li class="rounded-lg border border-slate-200 p-3">
                        @if ($media->isVideo())
                            <video src="{{ $media->url() }}" poster="{{ $media->posterUrl() }}" class="h-28 w-full rounded bg-slate-100 object-cover" muted preload="metadata"></video>
                        @else
                            <img src="{{ $media->url() }}" alt="" class="h-28 w-full rounded bg-slate-100 object-cover" loading="lazy">
                        @endif
                        <label class="sr-only" for="media_caption_{{ $media->id }}">Caption</label>
                        <input id="media_caption_{{ $media->id }}" name="media_caption[{{ $media->id }}]" value="{{ old('media_caption.'.$media->id, $media->caption) }}" placeholder="Caption (optional)" class="mt-2 w-full rounded-md border-slate-300 text-sm">
                        <label class="mt-2 flex items-center gap-2 text-xs text-red-700">
                            <input type="checkbox" name="remove_media[]" value="{{ $media->id }}"> Remove
                        </label>
                    </li>
                @endforeach
            </ul>
        @endif

        <label class="mt-4 block text-sm font-semibold" for="gallery">Add files</label>
        <input id="gallery" type="file" name="gallery[]" multiple accept="image/*,video/mp4,video/webm" class="mt-1 w-full text-sm">
        @error('gallery') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        @error('gallery.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </fieldset>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published ?? true))>
        Published on public site
    </label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">{{ $isEdit ? 'Save changes' : 'Create project' }}</button>
        <a href="{{ route('admin.projects.index') }}" class="rounded-md px-4 py-3 text-sm text-slate-600 hover:bg-slate-100">Cancel</a>
    </div>
</form>
