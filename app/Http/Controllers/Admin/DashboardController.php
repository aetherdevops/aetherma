<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'publishedCount' => Project::where('is_published', true)->count(),
            'messageCount' => ContactMessage::count(),
            'unreadCount' => ContactMessage::unread()->count(),
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }
}
