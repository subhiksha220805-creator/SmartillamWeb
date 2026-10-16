<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quote requests | Smart Illam Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-page admin-editor-page admin-inbox-page">
    <header class="admin-topbar">
        <a class="admin-topbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/smartillam-logo.png') }}" alt="Smart Illam"></a>
        <div class="admin-topbar-actions">
            <a href="{{ route('home') }}" target="_blank" rel="noopener">Preview website ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit">Sign out</button></form>
        </div>
    </header>
    <main class="admin-editor-shell">
        <aside class="admin-sidebar">
            <span class="admin-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
            <p class="admin-sidebar-overline">WORKSPACE</p>
            <h2>Website</h2>
            <a class="admin-messages-sidebar-link" href="{{ route('admin.content.edit') }}">▣ &nbsp; Site content</a>
            <a class="admin-messages-sidebar-link" href="{{ route('admin.messages.index') }}">✉ &nbsp; Contact messages</a>
            <a class="admin-messages-sidebar-link" href="{{ route('admin.quotes.index') }}">✉ &nbsp; Quote requests</a>
            <p>Signed in as<br><strong>{{ auth()->user()->name }}</strong></p>
        </aside>
        <section class="admin-editor-main">
            <div class="admin-editor-heading">
                <div><p class="admin-eyebrow">QUOTE INBOX</p><h1>Quote requests</h1><p>View and manage quotation requests sent through the services page.</p></div>
                <span class="admin-live-pill">{{ $quoteRequests->total() }} {{ \Illuminate\Support\Str::plural('REQUEST', $quoteRequests->total()) }}</span>
            </div>
            @if (session('status'))<div class="admin-success" role="status">✓ {{ session('status') }}</div>@endif

            <div class="admin-message-list">
                @forelse ($quoteRequests as $quoteRequest)
                    <article class="admin-message-card">
                        <div class="admin-message-card__header">
                            <div>
                                <p class="admin-message-number">Request #{{ $quoteRequests->firstItem() + $loop->index }} · {{ $quoteRequest->created_at->timezone('Asia/Kolkata')->format('M j, Y · g:i a') }}</p>
                                <h2>{{ $quoteRequest->name }}</h2>
                            </div>
                            <form method="POST" action="{{ route('admin.quotes.destroy', $quoteRequest) }}" onsubmit="return confirm('Delete this quote request permanently?')">
                                @csrf
                                @method('DELETE')
                                <button class="admin-message-delete" type="submit">Delete</button>
                            </form>
                        </div>
                        <div class="admin-message-contact"><a href="tel:{{ $quoteRequest->phone }}">{{ $quoteRequest->phone }}</a></div>
                        <dl class="admin-message-meta"><div><dt>Existing system</dt><dd>{{ $quoteRequest->system }}</dd></div></dl>
                    </article>
                @empty
                    <section class="admin-message-empty">
                        <span aria-hidden="true">✉</span>
                        <h2>No quote requests yet</h2>
                        <p>Requests submitted through the services page will appear here.</p>
                    </section>
                @endforelse
            </div>

            @if ($quoteRequests->hasPages())
                <nav class="admin-message-pagination" aria-label="Quote request pages">
                    @if ($quoteRequests->previousPageUrl())<a href="{{ $quoteRequests->previousPageUrl() }}">← Newer</a>@else<span></span>@endif
                    <span>Page {{ $quoteRequests->currentPage() }} of {{ $quoteRequests->lastPage() }}</span>
                    @if ($quoteRequests->nextPageUrl())<a href="{{ $quoteRequests->nextPageUrl() }}">Older →</a>@else<span></span>@endif
                </nav>
            @endif
        </section>
    </main>
</body>
</html>
