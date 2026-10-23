@extends('layouts.app')

@section('title', $article['title'].' | Smart Illam Journal')
@section('body-class', 'blog-article-page')

@section('content')
    <article>
        <header class="article-hero" style="--article-hero-image: url('{{ \Illuminate\Support\Str::startsWith($article['image'], ['http://', 'https://', 'data:']) ? $article['image'] : asset($article['image']) }}')">
            <div class="article-hero__shade"></div>
            <div class="article-hero__content">
                <p class="article-hero__eyebrow">{{ $article['category'] }}</p>
                <h1>@if (isset($article['hero_title'])){{ $article['hero_title'] }} <span>{{ $article['hero_accent'] }}</span>@else{{ $article['title'] }}@endif</h1>
                <div class="article-hero__meta"><span><span aria-hidden="true">◷</span> {{ $article['read_time'] }}</span><time datetime="{{ $article['datetime'] }}"><span aria-hidden="true">▣</span> {{ $article['date'] }}</time></div>
            </div>
        </header>

        <div class="article-body">
            <p class="article-intro">{{ $article['intro'] }}</p>

            <section class="article-copy-section">
                <p class="blog-category">{{ $cmsContent['blog.article_section_eyebrow'] ?? 'The Intelligent Home' }}</p>
                <h2>{{ $article['section_title'] }}</h2>
                <p>{{ $article['section_text'] }}</p>
            </section>

            <section class="article-copy-section">
                <h2>{{ $article['how_title'] }}</h2>
                <p>{{ $article['how_text'] }}</p>
            </section>

            <section class="article-benefits" aria-labelledby="article-benefits-title">
                <div>
                    <h2 id="article-benefits-title">{{ $cmsContent['blog.article_benefits_title'] ?? 'Benefits of Smart Living' }}</h2>
                    <ul>
                        @foreach ($article['benefits'] as $benefit)
                            <li><span aria-hidden="true">✓</span>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="article-image-frame">
                    <img src="{{ \Illuminate\Support\Str::startsWith($cmsContent['blog.article_supporting_image'] ?? 'images/blog/article-smart-living.jpg', ['http://', 'https://', 'data:']) ? $cmsContent['blog.article_supporting_image'] : asset($cmsContent['blog.article_supporting_image'] ?? 'images/blog/article-smart-living.jpg') }}" alt="{{ $cmsContent['blog.article_supporting_image_alt'] ?? 'Contemporary connected living room with a smart home control panel' }}" loading="lazy">
                </div>
            </section>

            <section class="article-copy-section article-why">
                <h2>{{ $cmsContent['blog.article_why_title'] ?? 'Why Choose Smart Illam?' }}</h2>
                <p>{{ $article['why_text'] }}</p>
                <p>{{ $cmsContent['blog.article_why_description'] ?? 'From consultation and customized design to installation and dedicated after-sales support, we help make connected living comfortable, secure, and simple to use.' }}</p>
            </section>
        </div>
    </article>

    <section class="article-cta" style="--article-cta-image: url('{{ \Illuminate\Support\Str::startsWith($cmsContent['blog.article_cta_image'] ?? 'images/blog/article-cta.jpg', ['http://', 'https://', 'data:']) ? $cmsContent['blog.article_cta_image'] : asset($cmsContent['blog.article_cta_image'] ?? 'images/blog/article-cta.jpg') }}')">
        <div class="article-cta__content">
            <h2>{{ $cmsContent['blog.article_cta_title'] ?? 'Ready to Experience Intelligent Living?' }}</h2>
            <p>{{ $cmsContent['blog.article_cta_description'] ?? 'Whether you’re building a new home or upgrading your existing space, Smart Illam is here to help you embrace the future of connected living.' }}</p>
            <div>
                <a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">{{ $cmsContent['blog.article_cta_primary_button'] ?? 'Book Consultation' }}</a>
                <a class="article-cta__secondary" href="{{ route('contact') }}">{{ $cmsContent['blog.article_cta_secondary_button'] ?? 'Request a Site Visit' }}</a>
            </div>
        </div>
    </section>

    @include('partials.site-footer')
@endsection
