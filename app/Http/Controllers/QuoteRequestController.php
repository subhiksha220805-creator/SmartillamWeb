<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'system' => ['required', 'string', 'max:150'],
        ]);

        QuoteRequest::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your quote request has been sent successfully.',
            ], 201);
        }

        return redirect()->to(route('services').'#services-quote')->with('quote_request_status', 'Your quote request has been sent successfully.');
    }
}
