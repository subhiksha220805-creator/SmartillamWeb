<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php
            $siteName = $cmsContent['brand.name'] ?? config('cms.defaults.brand.name', 'Smart Illam');
            $pageTitle = str_replace('Smart Illam', $siteName, trim($__env->yieldContent('title', $siteName)));
            $siteLogo = $cmsContent['brand.favicon'] ?? config('cms.defaults.brand.favicon', 'images/smartillam-logo.png');
            $siteLogoUrl = \Illuminate\Support\Str::startsWith($siteLogo, ['http://', 'https://', 'data:']) ? $siteLogo : asset($siteLogo);
        @endphp
        <title>{{ $pageTitle }}</title>
        <link rel="icon" href="{{ $siteLogoUrl }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ \Illuminate\Support\Facades\Vite::asset('resources/css/app.css') }}">
        @vite('resources/js/app.js')
    </head>
    <body id="page-top" class="@yield('body-class')">
        @include('partials.navigation')
        <main>@yield('content')</main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
