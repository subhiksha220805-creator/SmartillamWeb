<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()?->is_admin) {
            return redirect()->route('admin.content.edit');
        }

        return view('admin.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials + ['is_admin' => true], $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'These administrator details do not match our records.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.content.edit'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
