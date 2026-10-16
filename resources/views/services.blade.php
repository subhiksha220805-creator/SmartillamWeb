@extends('layouts.app')

@section('title', $cmsContent['services.page_title'] ?? 'Smart Home Services | Smart Illam')
@section('body-class', 'services-page')

@section('content')
    @php
        $serviceImage = fn (string $key, string $default): string => \Illuminate\Support\Str::startsWith($cmsContent["services.{$key}"] ?? $default, ['http://', 'https://', 'data:'])
            ? $cmsContent["services.{$key}"]
            : asset($cmsContent["services.{$key}"] ?? $default);
        $serviceLines = fn (string $key, string $default): array => preg_split('/\r\n|\r|\n/', $cmsContent["services.{$key}"] ?? $default, -1, PREG_SPLIT_NO_EMPTY);
        $specialtyTitles = $serviceLines('specialty_titles', "Lighting Automation\nDoor Lock Automation\nSecurity & Surveillance\nWater Level Control\nMotorized Curtains\nGate Automation\nMaintenance & Support");
        $specialtyDescriptions = $serviceLines('specialty_descriptions', "Adaptive lighting scenes for every mood and moment.\nExperience the ultimate convergence of convenience and robust security.\nAdvanced protection systems for complete peace of mind.\nThe Smart Water Level Controller automatically manages your water.\nSilent, automated window treatments for privacy and light.\nSmart gate automation for complete security and convenience.\nContinuous care and maintenance for peak system performance.");
        $specialtyAlts = $serviceLines('specialty_alts', "Warm layered lighting in a modern living room\nSmart keypad door lock at a modern home\nSecure, well-lit entrance to a contemporary home\nAutomatic water level controller beside a garden\nMotorized curtains in a calm, sunlit bedroom\nAutomated sliding gate at a contemporary residence\nSmart home specialist helping a customer with a control panel");
        $serviceSpecialties = [
            ['icon' => '☼', 'image' => 'service-lighting.jpg', 'alt' => 'Warm layered lighting in a modern living room', 'route' => 'products.smart-touch-switches'],
            ['icon' => '▣', 'image' => 'service-door-lock.png', 'alt' => 'Smart keypad door lock at a modern home', 'route' => 'products.smart-door-locks'],
            ['icon' => '⬟', 'image' => 'service-security.jpg', 'alt' => 'Secure, well-lit entrance to a contemporary home', 'route' => 'products.smart-security-systems'],
            ['icon' => '♧', 'image' => 'service-water-controller.png', 'alt' => 'Automatic water level controller beside a garden', 'route' => 'products.water-level-controllers'],
            ['icon' => '▧', 'image' => 'service-curtains.jpg', 'alt' => 'Motorized curtains in a calm, sunlit bedroom', 'route' => 'products.smart-curtain-control'],
            ['icon' => '⌂', 'image' => 'service-gate.png', 'alt' => 'Automated sliding gate at a contemporary residence', 'route' => 'products.sliding-gate-automation'],
            ['icon' => '◉', 'image' => 'service-support.jpg', 'alt' => 'Smart home specialist helping a customer with a control panel', 'route' => 'contact'],
        ];
        foreach ($serviceSpecialties as $index => &$specialty) {
            $specialty['title'] = $specialtyTitles[$index] ?? '';
            $specialty['description'] = $specialtyDescriptions[$index] ?? '';
            $specialty['alt'] = $specialtyAlts[$index] ?? '';
            $specialty['image_url'] = $serviceImage('specialty_image_'.($index + 1), 'images/services/'.$specialty['image']);
        }
        unset($specialty);
        $serviceValues = json_decode($cmsContent['services.values'] ?? '', true);
        if (! is_array($serviceValues)) {
            $cmsDefaults = config('cms.defaults', []);
            $serviceValues = json_decode($cmsDefaults['services.values'] ?? '', true) ?? [];
            foreach ($serviceLines('values', '') as $valueIndex => $legacyValue) {
                [$legacyName, $legacyDescription] = array_pad(explode('|', $legacyValue, 2), 2, '');
                $serviceValues[$valueIndex]['name'] = $legacyName;
                $serviceValues[$valueIndex]['description'] = $legacyDescription;
            }
        }
        $serviceQuoteOptions = $serviceLines('quote_system_options', "Smart Illam Installation\nNew Installation\nExisting Smart Home System\nUpgrade or Maintenance");
        $serviceFaqItems = $serviceLines('faq_items', "How long does a typical installation take?|Project timelines depend on the size of your property and the systems selected. We share a clear schedule after the site assessment and solution proposal.\nCan you automate an existing home?|Yes. We assess your wiring and existing devices, then recommend compatible solutions that can be installed with minimal disruption.\nIs training provided for the systems?|Yes. After installation and testing, our team walks you through the controls and helps your household feel comfortable using the system.\nDo the systems work without internet?|Core controls can continue to work locally depending on the selected system. Remote access and some connected services require an internet connection.\nAre your solutions compatible with Apple HomeKit?|Compatibility depends on the chosen devices and integration platform. We confirm the supported assistants and protocols during solution planning.\nWhat happens if the power goes out?|Devices resume their configured behavior when power returns. Backup power can be planned for selected network or security equipment where needed.");
    @endphp
    <section class="services-hero" style="--services-hero-image: url('{{ $serviceImage('hero_image', 'images/services/services-hero.png') }}')" aria-labelledby="services-hero-title">
        <div class="services-hero__shade" aria-hidden="true"></div>
        <div class="container services-hero__content">
            <p class="section-eyebrow">{{ $cmsContent['services.hero_eyebrow'] ?? 'Smart Solutions' }}</p>
            <h1 id="services-hero-title">{!! nl2br(e($cmsContent['services.hero_title'] ?? "Complete Smart Home Services\nFrom Design to Lifetime Support")) !!}</h1>
            <p>{{ $cmsContent['services.hero_description'] ?? 'We create bespoke automation ecosystems that blend seamlessly into your home or office, providing effortless control and unparalleled luxury.' }}</p>
            <div class="services-hero__actions">
                <a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">Book Consultation</a>
                <a class="services-outline-button" href="#specialties">{{ $cmsContent['services.hero_secondary_button'] ?? 'Explore Services' }}</a>
            </div>
        </div>
    </section>

    <section class="services-approach section-pad" aria-labelledby="services-approach-title">
        <div class="container services-approach__grid">
            <div class="services-approach__copy">
                <p class="section-eyebrow">{{ $cmsContent['services.approach_eyebrow'] ?? 'The Approach' }}</p>
                <h2 id="services-approach-title">{{ $cmsContent['services.approach_title'] ?? 'Every Detail, Expertly Managed.' }}</h2>
                <p>{{ $cmsContent['services.approach_description'] ?? 'Our service is defined by meticulous planning and an unwavering commitment to quality. We don’t just install hardware; we curate an experience that integrates seamlessly with your daily life.' }}</p>
                <ul class="services-check-list">
                    @foreach ($serviceLines('approach_points', "Bespoke Architectural Integration\nCertified Installation Standards\n24/7 Concierge Support Systems") as $point)<li>{{ $point }}</li>@endforeach
                </ul>
            </div>
            <img class="services-approach__image" src="{{ $serviceImage('approach_image', 'images/services/services-approach.png') }}" alt="{{ $cmsContent['services.approach_image_alt'] ?? 'A smart home control panel installed in a bright contemporary kitchen' }}" loading="lazy">
        </div>
    </section>

    <section class="services-specialties section-pad" id="specialties" aria-labelledby="services-specialties-title">
        <div class="container">
            <div class="services-section-heading">
                <p class="section-eyebrow">{{ $cmsContent['services.specialties_eyebrow'] ?? 'Our Specialties' }}</p>
                <h2 id="services-specialties-title">{{ $cmsContent['services.specialties_title'] ?? 'Core Automation Ecosystems' }}</h2>
            </div>
            <div class="services-specialty-grid">
                @foreach ($serviceSpecialties as $specialty)
                    <article class="services-specialty-card" style="--specialty-image: url('{{ $specialty['image_url'] }}')">
                        <a href="{{ $specialty['route'] === 'contact' ? route('contact') : route($specialty['route']) }}" aria-label="Learn more about {{ $specialty['title'] }}">
                            <img src="{{ $specialty['image_url'] }}" alt="{{ $specialty['alt'] }}" loading="lazy">
                            <span class="services-specialty-card__shade" aria-hidden="true"></span>
                            <span class="services-specialty-card__copy">
                                <span class="services-specialty-card__icon" aria-hidden="true">{{ $specialty['icon'] }}</span>
                                <span class="services-specialty-card__title">{{ $specialty['title'] }}</span>
                                <span class="services-specialty-card__description">{{ $specialty['description'] }}</span>
                                <span class="services-specialty-card__link">{{ $cmsContent['services.specialty_link_label'] ?? 'Learn more' }} <span aria-hidden="true">→</span></span>
                            </span>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="services-journey section-pad" aria-labelledby="services-journey-title">
        <div class="container">
            <div class="services-section-heading">
                <p class="section-eyebrow">{{ $cmsContent['services.journey_eyebrow'] ?? 'The Journey' }}</p>
                <h2 id="services-journey-title">{{ $cmsContent['services.journey_title'] ?? 'A Legacy of Precise Execution' }}</h2>
            </div>
            <ol class="services-journey__steps">
                @foreach ($serviceLines('journey_steps', "Consultation & Requirement Analysis\nSolution Proposal & Quotation\nOrder Confirmation\nProfessional Installation\nTesting & Quality Assurance\nTraining & Ongoing Support") as $step)
                    <li><span>{{ $loop->iteration }}</span><p>{{ $step }}</p></li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="services-values section-pad" aria-label="Why choose Smart Illam">
        <div class="container services-values__grid">
            @foreach ($serviceValues as $serviceValue)
                <article>
                    <span aria-hidden="true">
                        @if (!empty($serviceValue['image']))
                            <img src="{{ \Illuminate\Support\Str::startsWith($serviceValue['image'], ['http://', 'https://', 'data:']) ? $serviceValue['image'] : asset($serviceValue['image']) }}" alt="">
                        @else
                            ✧
                        @endif
                    </span>
                    <h2>{{ $serviceValue['name'] ?? '' }}</h2>
                    <p>{{ $serviceValue['description'] ?? '' }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="services-quote section-pad" id="services-quote" style="--services-quote-image: url('{{ $serviceImage('quote_image', 'images/services/services-quote.png') }}')" aria-labelledby="services-quote-title">
        <div class="container">
            @if (session('quote_request_status'))
                <div class="services-quote__toast" role="status" aria-live="polite">✓ {{ session('quote_request_status') }}</div>
            @endif
            @if ($errors->any())
                <div class="services-quote__error" role="alert">{{ $errors->first() }}</div>
            @endif
                <div class="services-quote__panel">
                    <h2 id="services-quote-title">{{ $cmsContent['services.quote_title'] ?? 'Request Quote' }}</h2>
                    <p class="services-quote__notice" data-quote-notice role="status" aria-live="polite" hidden></p>
                    <form class="services-quote-form" method="POST" action="{{ route('quote-requests.store') }}" data-service-quote>
                    @csrf
                    <label>{{ $cmsContent['services.quote_name_label'] ?? 'Full Name' }}<input name="name" type="text" autocomplete="name" value="{{ old('name') }}" maxlength="150" required></label>
                    <label>{{ $cmsContent['services.quote_phone_label'] ?? 'Contact Number' }}<input name="phone" type="tel" inputmode="numeric" pattern="[0-9]{10,15}" autocomplete="tel" value="{{ old('phone') }}" maxlength="15" minlength="10" required></label>
                    <label>{{ $cmsContent['services.quote_system_label'] ?? 'Existing System' }}<select name="system" required>@foreach ($serviceQuoteOptions as $option)<option value="{{ $option }}" @selected(old('system', $serviceQuoteOptions[0] ?? '') === $option)>{{ $option }}</option>@endforeach</select></label>
                    <button class="btn" type="submit">{{ $cmsContent['services.quote_submit_label'] ?? 'Request Quotation' }}</button>
                </form>
            </div>
        </div>
    </section>

    <section class="services-faq section-pad" aria-labelledby="services-faq-title">
        <div class="container services-faq__inner">
            <div class="services-section-heading">
                <p class="section-eyebrow">{{ $cmsContent['services.faq_eyebrow'] ?? 'Common Queries' }}</p>
                <h2 id="services-faq-title">{{ $cmsContent['services.faq_title'] ?? 'Everything You Need to Know' }}</h2>
            </div>
            <div class="services-faq__list">
                @foreach ($serviceFaqItems as $faqItem)
                    @php
                        [$faqQuestion, $faqAnswer] = array_pad(explode('|', $faqItem, 2), 2, '');
                    @endphp
                    <details><summary>{{ $faqQuestion }}</summary><p>{{ $faqAnswer }}</p></details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="services-final-cta" style="--services-final-cta-image: url('{{ $serviceImage('final_cta_image', 'images/services/services-cta.png') }}')" aria-labelledby="services-final-cta-title">
        <div class="container services-final-cta__content">
            <h2 id="services-final-cta-title">{!! nl2br(e($cmsContent['services.final_cta_title'] ?? "Let’s Create a Home That\nWorks Smarter.")) !!}</h2>
            <div class="services-final-cta__actions">
                <a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">Book Consultation</a>
                <a class="services-outline-button" href="{{ route('contact') }}">{{ $cmsContent['services.final_cta_secondary_button'] ?? 'Request a Site Visit' }}</a>
            </div>
        </div>
    </section>

    @include('partials.site-footer')
@endsection
