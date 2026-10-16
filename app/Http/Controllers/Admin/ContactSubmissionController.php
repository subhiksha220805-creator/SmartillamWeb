<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.messages.index', [
            'submissions' => ContactSubmission::query()->latest()->paginate(15),
        ]);
    }

    public function destroy(Request $request, ContactSubmission $contactSubmission): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $contactSubmission->delete();

        return redirect()->route('admin.messages.index')->with('status', 'Message deleted successfully.');
    }
}
