<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        $project->load('media');
        [$previous, $next] = $project->neighbours();

        return view('portfolio.show', compact('project', 'previous', 'next'));
    }
}
