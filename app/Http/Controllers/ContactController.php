<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Notifications\NewContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Honeypot: real visitors never see or fill this field, bots usually do.
        // Pretend it worked so the bot has no signal to adapt to.
        if ($request->filled('website')) {
            return $this->thanks();
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = ContactMessage::create($data);

        if ($recipients = config('mail.contact_to')) {
            try {
                Notification::route('mail', $recipients)->notify(new NewContactMessage($message));
            } catch (Throwable $e) {
                // The message is already saved in the admin; don't fail the visitor's submission.
                report($e);
            }
        }

        return $this->thanks();
    }

    private function thanks(): RedirectResponse
    {
        return redirect()
            ->to(url('/').'#contact')
            ->with('contact_success', 'Thank you — we will get back to you soon.');
    }
}
