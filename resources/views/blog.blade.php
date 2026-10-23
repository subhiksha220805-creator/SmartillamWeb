@extends('layouts.app')

@section('title', $cmsContent['blog.page_title'] ?? 'Smart Home Journal | Smart Illam')
@section('body-class', 'blog-page')

@section('content')
    <section class="blog-hero" id="home" aria-labelledby="blog-hero-title">
        <img class="blog-hero__image" src="{{ \Illuminate\Support\Str::startsWith($cmsContent['blog.hero_image'] ?? 'images/blog/blog-hero.png', ['http://', 'https://', 'data:']) ? $cmsContent['blog.hero_image'] : asset($cmsContent['blog.hero_image'] ?? 'images/blog/blog-hero.png') }}" alt="{{ $cmsContent['blog.hero_image_alt'] ?? 'Warm, connected living room overlooking a city at dusk' }}" fetchpriority="high">
        <div class="blog-hero__shade" aria-hidden="true"></div>
        <div class="container blog-hero__content">
            <p class="section-eyebrow">{{ $cmsContent['blog.hero_eyebrow'] ?? 'Smart Illam Journal' }}</p>
            <h1 id="blog-hero-title">{{ $cmsContent['blog.hero_title'] ?? 'Ideas That Inspire Intelligent Living' }}</h1>
            <p>{{ $cmsContent['blog.hero_description'] ?? 'Discover expert insights, practical guides, and the latest innovations in smart home technology. From intelligent automation and advanced security to energy-efficient living, our articles help you make informed decisions for a smarter lifestyle.' }}</p>
            <div class="blog-hero__actions">
                <a class="btn site-navbar__cta" href="#latest-articles">{{ $cmsContent['blog.hero_articles_button'] ?? 'Explore Articles' }}</a>
                <a class="btn blog-hero__secondary" href="{{ route('contact') }}#contact-form">{{ $cmsContent['blog.hero_consultation_button'] ?? 'Book Consultation' }}</a>
            </div>
        </div>
    </section>

    <section class="blog-topic-section" aria-label="{{ $cmsContent['blog.topics_section_label'] ?? 'Browse article topics' }}">
        <div class="container">
            <div class="blog-topic-list" role="group" aria-label="{{ $cmsContent['blog.topics_group_label'] ?? 'Filter articles by topic' }}">
                @foreach ([
                    'all' => $cmsContent['blog.topic_all'] ?? 'All Topics',
                    'smart-home-basics' => $cmsContent['blog.topic_basics'] ?? 'Smart Home Basics',
                    'home-security' => $cmsContent['blog.topic_security'] ?? 'Home Security',
                    'smart-lighting' => $cmsContent['blog.topic_lighting'] ?? 'Smart Lighting',
                    'energy-efficiency' => $cmsContent['blog.topic_energy'] ?? 'Energy Efficiency',
                    'voice-assistants' => $cmsContent['blog.topic_voice'] ?? 'Voice Assistants',
                    'smart-devices' => $cmsContent['blog.topic_devices'] ?? 'Smart Devices',
                    'lifestyle-living' => $cmsContent['blog.topic_lifestyle'] ?? 'Lifestyle & Living',
                ] as $topic => $label)
                    <button class="blog-topic{{ $topic === 'all' ? ' active' : '' }}" type="button" data-blog-topic="{{ $topic }}" aria-pressed="{{ $topic === 'all' ? 'true' : 'false' }}">{{ $label }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="blog-featured-section" aria-label="{{ $cmsContent['blog.featured_section_label'] ?? 'Featured article' }}">
        <div class="container">
            <article class="blog-featured-card" data-article-topic="smart-home-basics">
                @php($featuredArticle = $blogArticles['what-is-a-smart-home'])
                <img src="{{ \Illuminate\Support\Str::startsWith($cmsContent['blog.featured_image'] ?? 'images/blog/featured-smart-living.png', ['http://', 'https://', 'data:']) ? $cmsContent['blog.featured_image'] : asset($cmsContent['blog.featured_image'] ?? 'images/blog/featured-smart-living.png') }}" alt="{{ $cmsContent['blog.featured_image_alt'] ?? 'Smart Illam wall panel for controlling lighting, climate, scenes, and energy' }}" loading="lazy">
                <div class="blog-featured-copy">
                    <p class="blog-category">{{ $featuredArticle['category'] }}</p>
                    <h2>{{ $cmsContent['blog.featured_title'] ?? $featuredArticle['title'] }}</h2>
                    <p>{{ $cmsContent['blog.featured_description'] ?? $featuredArticle['description'] }}</p>
                    <div class="blog-meta"><time datetime="{{ $featuredArticle['datetime'] }}">{{ $featuredArticle['date'] }}</time><span>{{ $featuredArticle['read_time'] }}</span></div>
                    <a class="blog-read-button" href="{{ route('blog.show', ['slug' => 'what-is-a-smart-home']) }}">{{ $cmsContent['blog.featured_read_button'] ?? 'Read Full Article' }} <span aria-hidden="true">→</span></a>
                </div>
            </article>
        </div>
    </section>

    <section class="latest-articles-section" id="latest-articles" aria-labelledby="latest-articles-title">
        <div class="container">
            <div class="latest-articles-heading">
                <div><p class="blog-category">{{ $cmsContent['blog.latest_eyebrow'] ?? 'Insights, Innovations & Expert Advice' }}</p><h2 id="latest-articles-title">{{ $cmsContent['blog.latest_title'] ?? 'Latest Articles' }}</h2></div>
                <p>{{ $cmsContent['blog.latest_description'] ?? 'Stay informed with the latest trends, buying guides, expert recommendations, and practical tips designed to help you create a smarter, safer, and more connected home.' }}</p>
            </div>
            <div class="blog-article-grid">
                @foreach ([
                    'smart-lighting-transforms-your-home' => 'smart-lighting',
                    'top-smart-home-trends-2026' => 'smart-home-basics',
                    'essential-smart-security-for-every-home' => 'home-security',
                    'choosing-the-right-smart-home-system' => 'smart-home-basics',
                    'voice-controlled-living-made-simple' => 'voice-assistants',
                    'smart-homes-a-valuable-investment' => 'energy-efficiency',
                ] as $slug => $topic)
                    @php($article = $blogArticles[$slug])
                    <article class="blog-article-card" data-article-topic="{{ $topic }}">
                        <img src="{{ \Illuminate\Support\Str::startsWith($article['image'], ['http://', 'https://', 'data:']) ? $article['image'] : asset($article['image']) }}" alt="{{ $article['alt'] }}" loading="lazy">
                        <div class="blog-article-copy">
                            <div class="blog-article-meta"><span class="blog-category">{{ $article['category'] }}</span><span>{{ $article['read_time'] }}</span></div>
                            <h3>{{ $article['title'] }}</h3>
                            <p>{{ $article['description'] }}</p>
                            <div class="blog-article-footer"><time datetime="{{ $article['datetime'] }}">{{ $article['date'] }}</time><a href="{{ route('blog.show', ['slug' => $slug]) }}">{{ $cmsContent['blog.article_read_button'] ?? 'Read Full Article' }} <span aria-hidden="true">→</span></a></div>
                        </div>
                    </article>
                @endforeach
            </div>
            <p class="blog-empty-state" hidden>{{ $cmsContent['blog.empty_state'] ?? 'No articles found in this topic yet.' }}</p>
        </div>
    </section>

    <section class="blog-newsletter-section" id="newsletter" style="--blog-newsletter-image: url('{{ \Illuminate\Support\Str::startsWith($cmsContent['blog.newsletter_image'] ?? 'images/blog/newsletter-background.png', ['http://', 'https://', 'data:']) ? $cmsContent['blog.newsletter_image'] : asset($cmsContent['blog.newsletter_image'] ?? 'images/blog/newsletter-background.png') }}')" aria-labelledby="blog-newsletter-title">
        <div class="container">
            <div class="blog-newsletter-panel">
                <p class="blog-category">{{ $cmsContent['blog.newsletter_eyebrow'] ?? 'Weekly Intelligence' }}</p>
                <h2 id="blog-newsletter-title">{{ $cmsContent['blog.newsletter_title'] ?? 'Never Miss a Smart Innovation' }}</h2>
                <p>{{ $cmsContent['blog.newsletter_description'] ?? 'Stay connected with the latest automation trends, technology updates, expert insights, and practical smart living tips—delivered directly to your inbox. Whether you’re planning your first smart home or upgrading an existing one, we’ll keep you informed every step of the way.' }}</p>
                <form class="blog-newsletter-form" data-newsletter-form>
                    <label class="visually-hidden" for="blog-newsletter-email">{{ $cmsContent['blog.newsletter_email_label'] ?? 'Email address' }}</label>
                    <input id="blog-newsletter-email" name="email" type="email" placeholder="{{ $cmsContent['blog.newsletter_email_placeholder'] ?? 'Email Address' }}" autocomplete="email" required>
                    <button type="submit">{{ $cmsContent['blog.newsletter_submit_label'] ?? 'Subscribe' }}</button>
                </form>
            </div>
        </div>
    </section>

    @include('partials.site-footer')
@endsection
