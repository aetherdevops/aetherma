<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('filter') === 'unread' ? 'unread' : 'all';

        $messages = ContactMessage::query()
            ->when($filter === 'unread', fn ($query) => $query->unread())
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', compact('messages', 'filter'));
    }

    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $message->forceFill(['read_at' => $message->isRead() ? null : now()])->save();

        return back();
    }

    public function markAllRead(): RedirectResponse
    {
        ContactMessage::unread()->update(['read_at' => now()]);

        return back()->with('status', 'All messages marked as read.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return back()->with('status', 'Message deleted.');
    }
}
