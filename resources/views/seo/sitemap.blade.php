{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ optional($projects->max('updated_at'))->toAtomString() ?? now()->toAtomString() }}</lastmod>
        <priority>1.0</priority>
    </url>
@foreach ($projects as $project)
    <url>
        <loc>{{ route('portfolio.show', $project) }}</loc>
        <lastmod>{{ $project->updated_at->toAtomString() }}</lastmod>
        <priority>0.8</priority>
    </url>
@endforeach
    <url>
        <loc>{{ route('privacy') }}</loc>
        <priority>0.2</priority>
    </url>
</urlset>
