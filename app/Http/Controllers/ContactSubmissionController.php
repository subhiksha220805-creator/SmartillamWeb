<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Services\ContentStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function store(Request $request, ContentStore $contentStore): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'service' => ['required', 'string', 'max:150'],
            'contact_method' => ['nullable', 'string', 'max:80'],
            'requirements' => ['nullable', 'string', 'max:5000'],
        ]);

        ContactSubmission::create($validated);

        $content = $contentStore->all();
        $defaults = config('cms.defaults', []);
        $statusKey = $validated['service'] === 'Brochure Request'
            ? 'contact.brochure_success_message'
            : 'contact.form_success_message';
        $status = $content[$statusKey] ?? $defaults[$statusKey] ?? 'Your message has been sent successfully.';

        return redirect()->route('contact')->with('contact_submission_status', $status);
    }
}
