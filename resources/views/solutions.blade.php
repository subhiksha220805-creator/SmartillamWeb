@extends('layouts.app')

@section('title', 'Smart Home Solutions | Smart Illam')
@section('body-class', 'solutions-page')

@section('content')
    @php
        $solutionImage = fn (string $key, string $default): string => \Illuminate\Support\Str::startsWith($cmsContent["solutions.{$key}"] ?? $default, ['http://', 'https://', 'data:'])
            ? $cmsContent["solutions.{$key}"]
            : asset($cmsContent["solutions.{$key}"] ?? $default);
        $solutionFeatureList = fn (string $key, string $default): array => preg_split('/\r\n|\r|\n/', $cmsContent["solutions.{$key}"] ?? $default, -1, PREG_SPLIT_NO_EMPTY);
        $defaultPillarNames = ['Lighting', 'Climate', 'Security', 'CCTV', 'Smart Locks', 'Curtains', 'Voice Control', 'Home Theatre', 'Audio', 'Video Door', 'Energy', 'Mobile App'];
        $defaultPillarIcons = ['lighting.png', 'climate.png', 'security.png', 'cctv.png', 'smart-locks.png', 'curtains.png', 'voice-control.png', 'home-theatre.png', 'audio.png', 'video-door.png', 'energy.png', 'mobile-app.png'];
        $solutionPillarItems = json_decode($cmsContent['solutions.pillars'] ?? '', true);
        if (! is_array($solutionPillarItems) || ! array_is_list($solutionPillarItems)) {
            $legacyPillars = $solutionFeatureList('pillars', implode("\n", $defaultPillarNames));
            $solutionPillarItems = array_map(
                fn (string $name, int $index): array => ['name' => $name, 'image' => isset($defaultPillarIcons[$index]) ? 'images/solutions/pillars/'.$defaultPillarIcons[$index] : ''],
                $legacyPillars,
                array_keys($legacyPillars),
            );
        }
        $solutionScenes = $solutionFeatureList('scenes', "07:00 AM|Morning Routine|Shades rise gradually, coffee starts brewing, and gentle music fills the master suite.\n09:00 AM|Away Mode|Lights and climate controls switch off, the alarm sets, and presence simulation begins.\n07:30 PM|Dinner Party|Warm ambient lighting and a comfortable temperature set the mood for entertaining.\n08:00 PM|Movie Night|Lights dim, blinds close, and your home cinema system powers up.\n11:00 PM|Good Night|Doors lock, perimeter security arms, and path lighting activates.\nTravel|Vacation Mode|Monitoring, leak detection, and smart lighting help keep your home protected.");
    @endphp
    <section class="solutions-hero" id="home" aria-labelledby="solutions-hero-title">
        <img class="solutions-hero-image" src="{{ $solutionImage('hero_image', 'images/solutions/solutions-hero.png') }}" alt="{{ $cmsContent['solutions.hero_image_alt'] ?? 'Contemporary smart living room with integrated home controls' }}" fetchpriority="high">
        <div class="solutions-hero-shade" aria-hidden="true"></div>
        <div class="solutions-hero-content">
            <p class="solutions-eyebrow">{{ $cmsContent['solutions.hero_eyebrow'] ?? 'Smart Solutions' }}</p>
            <h1 id="solutions-hero-title">{{ $cmsContent['solutions.hero_title'] ?? 'Intelligent Spaces Designed Around Your Lifestyle' }}</h1>
            <p>{{ $cmsContent['solutions.hero_description'] ?? 'Transform your home into a smarter, safer, and more energy-efficient living space with seamless automation powered by Wi-Fi, Zigbee, and Matter protocols.' }}</p>
            <div class="solutions-hero-actions">
                <a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">{{ $cmsContent['solutions.hero_primary_button'] ?? 'Book Consultation' }}</a>
                <a class="btn solutions-secondary-button" href="{{ route('services') }}">{{ $cmsContent['solutions.hero_secondary_button'] ?? 'Explore Services' }}</a>
            </div>
        </div>
    </section>

    <section class="solutions-intro" aria-labelledby="solutions-intro-title">
        <h2 id="solutions-intro-title">{!! nl2br(e($cmsContent['solutions.intro_title'] ?? "Smart Living Starts with\nIntelligent Solutions")) !!}</h2>
        <p class="solutions-tagline">{{ $cmsContent['solutions.intro_tagline'] ?? 'Your Trusted Building Solution Provider' }}</p>
        <p class="solutions-intro-copy">{{ $cmsContent['solutions.intro_description'] ?? 'Technology should simplify life, not complicate it. Every Smart Illam solution is carefully designed to integrate naturally into your lifestyle, giving you complete control over your home while improving security, energy efficiency, and everyday comfort.' }}</p>
    </section>

    <section class="protocols-section" id="protocols" aria-labelledby="protocols-title">
        <p class="solutions-eyebrow">{{ $cmsContent['solutions.protocols_eyebrow'] ?? 'Seamless connectivity. Intelligent living.' }}</p>
        <h2 id="protocols-title">{{ $cmsContent['solutions.protocols_title'] ?? 'Built on Industry-Leading Smart Home Protocols' }}</h2>
        <p>{{ $cmsContent['solutions.protocols_description'] ?? 'Experience a home where every device communicates effortlessly, creating a truly connected ecosystem designed for comfort, security, and convenience. Powered by the world’s leading smart home communication standards, our automation platform delivers unmatched reliability, lightning-fast response, and future-ready compatibility.' }}</p>
        <div class="protocol-badges" aria-label="Supported smart home protocols"><span>Matter</span><span>Zigbee</span><span>Wi-Fi</span></div>
    </section>

    <section class="solution-details" id="solutions-details" aria-label="Smart home solutions">
        <article class="solution-detail">
            <div class="solution-copy">
                <div class="solution-title-wrap"><span class="solution-watermark" aria-hidden="true">{{ $cmsContent['solutions.lighting_title'] ?? 'Smart Lighting Control' }}</span><h2>{{ $cmsContent['solutions.lighting_title'] ?? 'Smart Lighting Control' }}</h2></div>
                <p>{{ $cmsContent['solutions.lighting_description'] ?? 'Control every light in your home using your smartphone, voice assistant, or elegant touch switches. Create personalized lighting scenes for different moods and schedules.' }}</p>
                <ul class="solution-feature-list">@foreach ($solutionFeatureList('lighting_features', "Mobile App Control\nVoice Control\nSmart Touch Switches\nRemote Control\nDimming Control") as $feature)<li>{{ $feature }}</li>@endforeach</ul>
            </div>
            <div class="solution-image"><img src="{{ $solutionImage('lighting_image', 'images/solutions/smart-home-room.png') }}" alt="{{ $cmsContent['solutions.lighting_image_alt'] ?? 'Smart lighting and touch controls in a modern home' }}" loading="lazy"></div>
        </article>
        <article class="solution-detail solution-detail--reverse">
            <div class="solution-copy">
                <div class="solution-title-wrap"><span class="solution-watermark" aria-hidden="true">{{ $cmsContent['solutions.security_title'] ?? 'Smart Security' }}</span><h2>{{ $cmsContent['solutions.security_title'] ?? 'Smart Security' }}</h2></div>
                <p>{{ $cmsContent['solutions.security_description'] ?? 'Protect your family with intelligent security integrated into a single mobile application.' }}</p>
                <ul class="solution-feature-list">@foreach ($solutionFeatureList('security_features', "Smart Door Lock\nCCTV Integration\nMotion Detection\nDoor Sensors\nWindow Sensors\nIntrusion Alerts") as $feature)<li>{{ $feature }}</li>@endforeach</ul>
            </div>
            <div class="solution-image"><img src="{{ $solutionImage('security_image', 'images/solutions/smart-home-room-alt.png') }}" alt="{{ $cmsContent['solutions.security_image_alt'] ?? 'Integrated home security controls in a modern living room' }}" loading="lazy"></div>
        </article>
        <article class="solution-detail">
            <div class="solution-copy">
                <div class="solution-title-wrap"><span class="solution-watermark" aria-hidden="true">{{ $cmsContent['solutions.curtains_title'] ?? 'Smart Curtain Automation' }}</span><h2>{{ $cmsContent['solutions.curtains_title'] ?? 'Smart Curtain Automation' }}</h2></div>
                <p>{{ $cmsContent['solutions.curtains_description'] ?? 'Open and close curtains automatically based on time, sunrise, weather, or a single touch.' }}</p>
                <ul class="solution-feature-list">@foreach ($solutionFeatureList('curtains_features', "Mobile App Control\nVoice Control\nRemote Control\nSchedule Opening\nTiming Control\nSilent Operation") as $feature)<li>{{ $feature }}</li>@endforeach</ul>
            </div>
            <div class="solution-image"><img src="{{ $solutionImage('curtains_image', 'images/solutions/solution-interior.jpg') }}" alt="{{ $cmsContent['solutions.curtains_image_alt'] ?? 'Bright contemporary living room with wide windows and automated curtains' }}" loading="lazy"></div>
        </article>
        <article class="solution-detail solution-detail--reverse">
            <div class="solution-copy">
                <div class="solution-title-wrap"><span class="solution-watermark" aria-hidden="true">{{ $cmsContent['solutions.gate_title'] ?? 'Gate Automation' }}</span><h2>{{ $cmsContent['solutions.gate_title'] ?? 'Gate Automation with VDP' }}</h2></div>
                <p>{{ $cmsContent['solutions.gate_description'] ?? 'Experience a new level of convenience and security with gate automation integrated with a Video Door Phone (VDP). See who’s at your entrance, communicate with visitors, and open your gate remotely—from your indoor monitor or smartphone.' }}</p>
                <ul class="solution-feature-list">@foreach ($solutionFeatureList('gate_features', "Mobile App Control\nTouch Switch Control\nRemote Control\nScheduled Opening\nSilent Operation\nHD Video Monitoring\nTwo-way Audio") as $feature)<li>{{ $feature }}</li>@endforeach</ul>
            </div>
            <div class="solution-image"><img src="{{ $solutionImage('gate_image', 'images/solutions/smart-home-room.png') }}" alt="{{ $cmsContent['solutions.gate_image_alt'] ?? 'Indoor smart home control panel for connected gate access' }}" loading="lazy"></div>
        </article>
    </section>

    <section class="app-control-section" aria-labelledby="app-control-title">
        <div class="solutions-section-heading"><h2 id="app-control-title">{{ $cmsContent['solutions.app_title'] ?? 'Your Entire Smart Home. One Powerful App.' }}</h2><p>{{ $cmsContent['solutions.app_description'] ?? 'Manage lighting, climate, security, curtains, gates, and every connected device from a single intuitive mobile application.' }}</p></div>
        <img src="{{ $solutionImage('app_image', 'images/solutions/app-connected-devices.png') }}" alt="Smart home app connected to lighting, climate, curtains, security, and other devices" loading="lazy">
    </section>

    <section class="ecosystem-section" aria-labelledby="ecosystem-title">
        <div class="solutions-section-heading"><h2 id="ecosystem-title">{{ $cmsContent['solutions.ecosystem_title'] ?? 'One Ecosystem. Every Device.' }}</h2><p>{{ $cmsContent['solutions.ecosystem_description'] ?? 'Whether you’re at home, at work, or on the move, manage your entire smart home effortlessly. Access lighting, climate, security, curtains, gates, and more from your desktop, tablet, or smartphone—all synchronized in real time.' }}</p></div>
        <img src="{{ $solutionImage('ecosystem_image', 'images/solutions/device-ecosystem.png') }}" alt="Smart home automation interfaces displayed on a desktop, tablet, smartphone, and smartwatch" loading="lazy">
    </section>

    <section class="automation-pillars-section" aria-labelledby="automation-pillars-title">
        <div class="solutions-section-heading"><h2 id="automation-pillars-title">{{ $cmsContent['solutions.pillars_title'] ?? 'Core Automation Pillars' }}</h2><p>{{ $cmsContent['solutions.pillars_description'] ?? 'Twelve essential technologies integrated into every Smart Illam project for maximum efficiency and comfort.' }}</p></div>
        <div class="automation-pillars-grid">
            @foreach ($solutionPillarItems as $pillar)
                @php
                    $pillarName = is_array($pillar) ? ($pillar['name'] ?? '') : '';
                    $pillarImage = is_array($pillar) ? ($pillar['image'] ?? '') : '';
                    $pillarImageUrl = $pillarImage === '' ? '' : (\Illuminate\Support\Str::startsWith($pillarImage, ['http://', 'https://', 'data:']) ? $pillarImage : asset($pillarImage));
                @endphp
                @if ($pillarName !== '')
                <div class="automation-pillar">
                    @if ($pillarImageUrl !== '')
                        <img class="automation-pillar__icon" src="{{ $pillarImageUrl }}" alt="" aria-hidden="true" loading="lazy">
                    @else
                        <span aria-hidden="true">✧</span>
                    @endif
                    <h3>{{ $pillarName }}</h3>
                </div>
                @endif
            @endforeach
        </div>
    </section>

    <section class="scene-creation-section" aria-labelledby="scene-creation-title">
        <div class="solutions-section-heading"><h2 id="scene-creation-title">{{ $cmsContent['solutions.scenes_title'] ?? 'Smart Scene Creation' }}</h2></div>
        <div class="scene-cards">
            @foreach ($solutionScenes as $scene)
                @php
                    [$sceneTime, $sceneTitle, $sceneDescription] = array_pad(explode('|', $scene, 3), 3, '');
                @endphp
                <article><span>{{ $sceneTime }}</span><h3>{{ $sceneTitle }}</h3><p>{{ $sceneDescription }}</p></article>
            @endforeach
        </div>
    </section>

    <section class="lifestyle-section" aria-labelledby="lifestyle-title">
        <div class="solutions-section-heading"><h2 id="lifestyle-title">{{ $cmsContent['solutions.lifestyle_title'] ?? 'Built for Every Lifestyle' }}</h2></div>
        <div class="lifestyle-cards">
            <article><div class="lifestyle-image-frame"><img src="{{ $solutionImage('apartments_image', 'images/solutions/lifestyle-apartments.png') }}" alt="Luxury apartment with a bright connected living space" loading="lazy"></div><h3>{{ $cmsContent['solutions.apartments_title'] ?? 'Luxury Apartments' }}</h3></article>
            <article><div class="lifestyle-image-frame"><img src="{{ $solutionImage('industries_image', 'images/solutions/lifestyle-industries.png') }}" alt="Industrial facility with an automated entry gate" loading="lazy"></div><h3>{{ $cmsContent['solutions.industries_title'] ?? 'Industries' }}</h3></article>
            <article><div class="lifestyle-image-frame"><img src="{{ $solutionImage('commercial_image', 'images/solutions/lifestyle-commercial.png') }}" alt="Modern commercial building with integrated access controls" loading="lazy"></div><h3>{{ $cmsContent['solutions.commercial_title'] ?? 'Commercial Buildings' }}</h3></article>
        </div>
    </section>

    <section class="solutions-cta-section" style="--solutions-cta-image: url('{{ $solutionImage('cta_image', 'images/solutions/solution-interior.jpg') }}')" aria-labelledby="solutions-cta-title">
        <div><h2 id="solutions-cta-title">{{ $cmsContent['solutions.cta_title'] ?? 'Let’s Design the Perfect Smart Home for You.' }}</h2><p>{{ $cmsContent['solutions.cta_description'] ?? 'Consult with our expert engineers to discover how we can elevate your lifestyle through intelligent technology.' }}</p></div>
        <div class="solutions-cta-actions"><a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">{{ $cmsContent['solutions.cta_primary_button'] ?? 'Book Consultation' }}</a><a class="btn solutions-cta-secondary" href="tel:+919876543210">{{ $cmsContent['solutions.cta_secondary_button'] ?? 'Talk to an Expert' }}</a></div>
    </section>

    @include('partials.site-footer')
@endsection
