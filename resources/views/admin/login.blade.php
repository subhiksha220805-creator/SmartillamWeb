<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin sign in | Smart Illam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-page">
    <main class="admin-login-shell">
        <section class="admin-login-art">
            <img class="admin-login-art-image" src="{{ asset('images/home/home-smart-living-room.svg') }}" alt="Smart home living room">
            <a class="admin-login-brand" href="{{ route('home') }}"><img src="{{ asset('images/smartillam-logo.png') }}" alt="Smart Illam"></a>
            <div class="admin-login-art-caption"><span class="admin-status-dot"></span><p>Thoughtful technology.<br><strong>Effortless living.</strong></p></div>
        </section>
        <section class="admin-login-panel">
            <a class="admin-back-link" href="{{ route('home') }}">← Back to website</a>
            <div class="admin-login-form-wrap">
                <p class="admin-eyebrow">SMART ILLAM · CONTROL ROOM</p>
                <h1>Welcome<br>back<span>.</span></h1>
                <p class="admin-login-intro">Sign in to manage products, articles, and website pages.</p>
                @if ($errors->any())<div class="admin-alert" role="alert">{{ $errors->first() }}</div>@endif
                <form class="admin-login-form" method="POST" action="{{ route('admin.login.store') }}">
                    @csrf
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" placeholder="you@example.com" required autofocus>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Enter your password" required>
                    <label class="admin-remember"><input type="checkbox" name="remember" value="1"><span>Keep me signed in</span></label>
                    <button class="admin-submit" type="submit">Sign in to dashboard <span aria-hidden="true">↗</span></button>
                </form>
                <p class="admin-login-footer">Access reserved for authorized administrators.</p>
            </div>
        </section>
    </main>
</body>
</html>
