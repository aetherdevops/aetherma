<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $projects = Project::published()->get(['slug', 'updated_at']);

        return response()
            ->view('seo.sitemap', compact('projects'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $lines = app()->isProduction()
            ? ['User-agent: *', 'Disallow: /admin', 'Disallow: /login', 'Disallow: /forgot-password', 'Disallow: /reset-password', '', 'Sitemap: '.route('sitemap')]
            // Keep staging / local copies out of search results.
            : ['User-agent: *', 'Disallow: /'];

        return response(implode("\n", $lines)."\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
