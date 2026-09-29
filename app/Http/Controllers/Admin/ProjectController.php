<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\RichText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()->withCount('media')->orderBy('sort_order')->orderByDesc('id')->paginate(12);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('cover')) {
            $data['cover_image'] = $request->file('cover')->store('projects', 'public');
        }

        $project = Project::create($data);
        $this->syncGallery($request, $project);

        return redirect()->route('admin.projects.index')->with('status', 'Project created.');
    }

    public function edit(Project $project): View
    {
        $project->load('media');

        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request, $project);

        if ($request->hasFile('cover')) {
            $this->deleteUpload($project->cover_image);
            $data['cover_image'] = $request->file('cover')->store('projects', 'public');
        }

        $project->update($data);
        $this->syncGallery($request, $project);

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project updated.');
    }

    public function togglePublished(Project $project): RedirectResponse
    {
        $project->update(['is_published' => ! $project->is_published]);

        return back()->with('status', $project->is_published
            ? "“{$project->title}” is now live."
            : "“{$project->title}” is now hidden from the site.");
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteUpload($project->cover_image);
        $project->media->each->deleteFiles();

        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('projects', 'slug')->ignore($project?->id)],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'max:200000'],
            'client_name' => ['nullable', 'string', 'max:190'],
            'completed_at' => ['nullable', 'date'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover' => ['nullable', 'image', 'max:5120'],
            'gallery' => ['nullable', 'array', 'max:12'],
            'gallery.*' => ['file', 'mimes:jpg,jpeg,png,webp,gif,mp4,webm', 'max:20480'],
            'remove_media' => ['nullable', 'array'],
            'remove_media.*' => ['integer'],
            'media_caption' => ['nullable', 'array'],
            'media_caption.*' => ['nullable', 'string', 'max:190'],
        ]);

        $data['slug'] = Str::slug(($data['slug'] ?? null) ?: $data['title']);
        $data['body'] = RichText::sanitize($data['body'] ?? null);
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return collect($data)->only([
            'title', 'slug', 'excerpt', 'body', 'client_name', 'completed_at', 'is_published', 'sort_order',
        ])->all();
    }

    private function syncGallery(Request $request, Project $project): void
    {
        // Only ever touch media that belongs to this project.
        $existing = $project->media()->get()->keyBy('id');

        foreach ((array) $request->input('remove_media', []) as $id) {
            if ($media = $existing->pull((int) $id)) {
                $media->deleteFiles();
                $media->delete();
            }
        }

        foreach ((array) $request->input('media_caption', []) as $id => $caption) {
            $existing->get((int) $id)?->update(['caption' => $caption ?: null]);
        }

        $nextOrder = (int) $project->media()->max('sort_order') + 1;

        foreach ((array) $request->file('gallery', []) as $file) {
            $project->media()->create([
                'path' => $file->store('projects/gallery', 'public'),
                'sort_order' => $nextOrder++,
            ]);
        }
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && Str::startsWith($path, 'projects/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
