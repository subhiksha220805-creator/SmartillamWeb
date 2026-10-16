@extends('layouts.app')

@section('title', $cmsContent['about.page_title'] ?? 'About Smart Illam | Intelligent Living')
@section('body-class', 'about-page')

@section('content')
    <section class="about-hero" id="home" aria-labelledby="about-hero-title">
        <img class="about-hero__image" src="{{ \Illuminate\Support\Str::startsWith($cmsContent['about.hero_image'] ?? 'images/about/about-hero.png', ['http://', 'https://', 'data:']) ? $cmsContent['about.hero_image'] : asset($cmsContent['about.hero_image'] ?? 'images/about/about-hero.png') }}" alt="{{ $cmsContent['about.hero_image_alt'] ?? 'Premium living room with integrated Smart Illam home controls' }}" fetchpriority="high">
        <div class="about-hero__shade" aria-hidden="true"></div>
        <div class="container about-hero__content">
            <p class="section-eyebrow">{{ $cmsContent['about.hero_eyebrow'] ?? 'About Smart Illam' }}</p>
            <h1 id="about-hero-title">{{ $cmsContent['about.hero_title'] ?? 'Designing Homes That Think.' }}</h1>
            <p>{{ $cmsContent['about.hero_description'] ?? 'We believe technology should disappear into your home, enhancing your life without complicating it. Our mission is to blend invisible intelligence with premium luxury.' }}</p>
            <div class="about-hero__actions">
                <a class="btn site-navbar__cta" href="{{ route('solutions') }}">{{ $cmsContent['about.hero_solutions_button'] ?? 'Explore Solutions' }}</a>
                <a class="btn about-hero__secondary" href="{{ route('contact') }}#contact-form">Book Consultation</a>
            </div>
        </div>
    </section>

    <section class="about-intro" aria-labelledby="about-intro-title">
        <div class="about-intro-copy">
            <h2 id="about-intro-title">{{ $cmsContent['about.intro_title'] ?? 'Smart Illam' }}</h2>
            <p class="about-tagline">{{ $cmsContent['about.tagline'] ?? 'Redefining Modern Living' }}</p>
            <p>{{ $cmsContent['about.intro_text'] ?? 'Smart Illam is a leading provider of intelligent home automation and smart building solutions. We specialize in creating connected environments that combine innovation, security, luxury, and energy efficiency. From consultation to installation and ongoing support, we deliver end-to-end automation solutions tailored to the unique needs of homeowners, businesses, and developers. Every project is designed with precision, ensuring technology integrates naturally into everyday living.' }}</p>
        </div>
        <div class="about-image-frame"><img src="{{ \Illuminate\Support\Str::startsWith($cmsContent['about.intro_image'] ?? 'images/about/about-interior.png', ['http://', 'https://', 'data:']) ? $cmsContent['about.intro_image'] : asset($cmsContent['about.intro_image'] ?? 'images/about/about-interior.png') }}" alt="{{ $cmsContent['about.intro_image_alt'] ?? 'Elegant home interior with warm architectural lighting and an integrated touch control panel' }}" loading="lazy"></div>
    </section>

    <section class="about-purpose" aria-label="Our vision and mission">
        <article class="purpose-row">
            <img src="{{ \Illuminate\Support\Str::startsWith($cmsContent['about.vision_image'] ?? 'images/about/vision-interior.png', ['http://', 'https://', 'data:']) ? $cmsContent['about.vision_image'] : asset($cmsContent['about.vision_image'] ?? 'images/about/vision-interior.png') }}" alt="{{ $cmsContent['about.vision_image_alt'] ?? 'Luxury living room with layered lighting and a city view' }}" loading="lazy">
                <div class="purpose-copy"><h2>{{ $cmsContent['about.vision_title'] ?? 'Our Vision' }}</h2><p>{{ $cmsContent['about.vision_text'] ?? 'To become the most trusted smart home automation company by creating intelligent spaces that improve quality of life through innovation.' }}</p></div>
        </article>
        <article class="purpose-row purpose-row-reverse">
            <div class="purpose-copy"><h2>{{ $cmsContent['about.mission_title'] ?? 'Our Mission' }}</h2><p>{{ $cmsContent['about.mission_text'] ?? 'To deliver reliable, secure, and future-ready automation solutions that provide comfort, convenience, and peace of mind for every customer.' }}</p></div>
            <img src="{{ \Illuminate\Support\Str::startsWith($cmsContent['about.mission_image'] ?? 'images/about/mission-interior.png', ['http://', 'https://', 'data:']) ? $cmsContent['about.mission_image'] : asset($cmsContent['about.mission_image'] ?? 'images/about/mission-interior.png') }}" alt="{{ $cmsContent['about.mission_image_alt'] ?? 'Contemporary living room with automated lighting and smart home controls' }}" loading="lazy">
        </article>
    </section>

    <section class="values-section" aria-labelledby="values-title">
        <div class="values-card">
            <div><h2 id="values-title">{{ $cmsContent['about.values_title'] ?? 'Our Core Values' }}</h2></div>
            <ul>
                @foreach (preg_split('/\r\n|\r|\n/', $cmsContent['about.values'] ?? "Innovation\nQuality\nIntegrity\nCustomer Satisfaction\nContinuous Improvement\nReliable Support", -1, PREG_SPLIT_NO_EMPTY) as $value)
                    <li>{{ $value }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('partials.site-footer')
@endsection
