<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $projects = Project::published()->get();
        $testimonials = Testimonial::published()->get();

        return view('home', compact('projects', 'testimonials'));
    }
}
