<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\NewContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function store(StoreContactMessageRequest $request)
    {
        $contactMessage = ContactMessage::create([
            ...$request->safe()->except(['website']),
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        $notifyAddress = config('mail.admin_notify_address');

        if ($notifyAddress) {
            Mail::to($notifyAddress)->send(new NewContactMessageMail($contactMessage));
        }

        return back()->with('contact_success', true);
    }
}
