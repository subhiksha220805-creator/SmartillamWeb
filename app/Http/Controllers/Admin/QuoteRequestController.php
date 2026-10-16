<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest as QuoteRequestModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.quotes.index', [
            'quoteRequests' => QuoteRequestModel::query()->latest()->paginate(15),
        ]);
    }

    public function destroy(Request $request, QuoteRequestModel $quoteRequest): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $quoteRequest->delete();

        return redirect()->route('admin.quotes.index')->with('status', 'Quote request deleted successfully.');
    }
}
