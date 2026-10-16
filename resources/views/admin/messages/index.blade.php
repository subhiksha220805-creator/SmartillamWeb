<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact messages | Smart Illam Admin</title>
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
                <div><p class="admin-eyebrow">CONTACT INBOX</p><h1>Messages from your website</h1><p>Read and manage enquiries sent through the contact form.</p></div>
                <span class="admin-live-pill">{{ $submissions->total() }} {{ \Illuminate\Support\Str::plural('MESSAGE', $submissions->total()) }}</span>
            </div>
            @if (session('status'))<div class="admin-success" role="status">✓ {{ session('status') }}</div>@endif

            <div class="admin-message-list">
                @forelse ($submissions as $submission)
                    <article class="admin-message-card">
                        <div class="admin-message-card__header">
                            <div>
                                <p class="admin-message-number">Message #{{ $submissions->firstItem() + $loop->index }} · {{ $submission->created_at->timezone('Asia/Kolkata')->format('M j, Y · g:i a') }}</p>
                                <h2>{{ trim($submission->first_name.' '.($submission->last_name ?? '')) }}</h2>
                            </div>
                            <form method="POST" action="{{ route('admin.messages.destroy', $submission) }}" onsubmit="return confirm('Delete this message permanently?')">
                                @csrf
                                @method('DELETE')
                                <button class="admin-message-delete" type="submit">Delete</button>
                            </form>
                        </div>
                        <div class="admin-message-contact">
                            <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a>
                            <a href="tel:{{ $submission->phone }}">{{ $submission->phone }}</a>
                        </div>
                        <dl class="admin-message-meta">
                            <div><dt>Interested in</dt><dd>{{ $submission->service }}</dd></div>
                            <div><dt>Preferred contact</dt><dd>{{ $submission->contact_method ?: 'Not specified' }}</dd></div>
                        </dl>
                        <div class="admin-message-requirement">
                            <h3>Requirement</h3>
                            <p>{{ $submission->requirements ?: 'No additional details provided.' }}</p>
                        </div>
                    </article>
                @empty
                    <section class="admin-message-empty">
                        <span aria-hidden="true">✉</span>
                        <h2>No contact messages yet</h2>
                        <p>New enquiries submitted through the website will appear here.</p>
                    </section>
                @endforelse
            </div>

            @if ($submissions->hasPages())
                <nav class="admin-message-pagination" aria-label="Contact message pages">
                    @if ($submissions->previousPageUrl())<a href="{{ $submissions->previousPageUrl() }}">← Newer</a>@else<span></span>@endif
                    <span>Page {{ $submissions->currentPage() }} of {{ $submissions->lastPage() }}</span>
                    @if ($submissions->nextPageUrl())<a href="{{ $submissions->nextPageUrl() }}">Older →</a>@else<span></span>@endif
                </nav>
            @endif
        </section>
    </main>
</body>
</html>
