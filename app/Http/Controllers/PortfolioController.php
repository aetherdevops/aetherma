<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        return view('portfolio.show', compact('project'));
    }
}
