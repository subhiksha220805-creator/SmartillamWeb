@extends('layouts.app')

@section('title', ($cmsContent['products.'.$slug.'.name'] ?? $product['name']).' | Smart Illam')
@section('body-class', 'product-catalog-page product-catalog-page--'.$slug)

@section('content')
    @php
        $productDefaults = config('cms.defaults', []);
        $productCms = fn (string $field, string $fallback = ''): string => $cmsContent["products.{$slug}.{$field}"] ?? $productDefaults["products.{$slug}.{$field}"] ?? $fallback;
        $productCmsImage = fn (string $field, string $fallback): string => \Illuminate\Support\Str::startsWith($productCms($field, $fallback), ['http://', 'https://', 'data:']) ? $productCms($field, $fallback) : asset($productCms($field, $fallback));
        $genericHeroTitle = 'Technology That Disappears Into Your Home.';
        $genericHeroDescription = 'Elevate your living experience with hardware designed to complement luxury interiors, where intelligence is felt rather than seen.';
        $genericHeroImage = 'images/product-hero.png';
        $cmsHeroTitle = $cmsContent['products.'.$slug.'.hero_title'] ?? null;
        $cmsHeroDescription = $cmsContent['products.'.$slug.'.hero_description'] ?? null;
        $cmsHeroImage = $cmsContent['products.'.$slug.'.hero_image'] ?? null;
        $productHeroTitle = $slug === 'sliding-gate-automation' && $cmsHeroTitle === $genericHeroTitle
            ? ($product['hero_title'] ?? $genericHeroTitle)
            : ($cmsHeroTitle ?? $product['hero_title'] ?? $genericHeroTitle);
        $productHeroDescription = $slug === 'sliding-gate-automation' && $cmsHeroDescription === $genericHeroDescription
            ? ($product['hero_description'] ?? $genericHeroDescription)
            : ($cmsHeroDescription ?? $product['hero_description'] ?? $genericHeroDescription);
        $productHeroImage = $slug === 'sliding-gate-automation' && $cmsHeroImage === $genericHeroImage
            ? ($product['hero_image'] ?? $genericHeroImage)
            : ($cmsHeroImage ?? $product['hero_image'] ?? $genericHeroImage);
        $productMobileHeroImage = $productCms('hero_mobile_image');
        $productImageUrl = fn (string $image): string => \Illuminate\Support\Str::startsWith($image, ['http://', 'https://', 'data:']) ? $image : asset($image);
        $productCmsLines = fn (string $field, string $fallback = ''): array => preg_split('/\r\n|\r|\n/', $productCms($field, $fallback), -1, PREG_SPLIT_NO_EMPTY);
        $touchIntroBenefits = preg_split('/\r\n|\r|\n/', $productCms('intro_benefits'), -1, PREG_SPLIT_NO_EMPTY);
        $touchModuleCounts = array_map('intval', preg_split('/\r\n|\r|\n/', $productCms('module_counts', "2\n4\n6\n8\n12"), -1, PREG_SPLIT_NO_EMPTY));
        $touchModuleFeatures = preg_split('/\r\n|\r|\n/', $productCms('module_features'), -1, PREG_SPLIT_NO_EMPTY);
        $touchTechnicalLabels = preg_split('/\r\n|\r|\n/', $productCms('technical_labels'), -1, PREG_SPLIT_NO_EMPTY);
        $touchTechnicalValues = preg_split('/\r\n|\r|\n/', $productCms('technical_values'), -1, PREG_SPLIT_NO_EMPTY);
        $touchFeatureNames = preg_split('/\r\n|\r|\n/', $productCms('feature_names'), -1, PREG_SPLIT_NO_EMPTY);
        $touchFeatureImages = [
            'images/touch-switch/feature-touch.png', 'images/touch-switch/feature-wifi.png',
            'images/touch-switch/feature-remote.png', 'images/touch-switch/feature-voice.png',
            'images/touch-switch/feature-mobile.png', 'images/touch-switch/feature-share.png',
            'images/touch-switch/feature-scenes.png', 'images/touch-switch/feature-timing.png',
            'images/touch-switch/feature-power.png',
        ];
        $touchBenefitIcons = [
            'images/icons/touch-switches/premium-finish.png',
            'images/icons/touch-switches/capacitive-touch.png',
            'images/icons/touch-switches/app-control.png',
            'images/icons/touch-switches/voice-assistant.png',
            'images/icons/touch-switches/energy-efficient.png',
            'images/icons/touch-switches/scene-automation.png',
        ];
    @endphp
    <section class="catalog-hero" style="--catalog-hero-image: url('{{ $productImageUrl($productHeroImage) }}');{{ $productMobileHeroImage !== '' ? ' --catalog-hero-mobile-image: url(' . $productImageUrl($productMobileHeroImage) . ');' : '' }}@if ($slug === 'sliding-gate-automation') height: 100vh; height: 100svh; min-height: 100vh; min-height: 100svh; margin-bottom: 0; background-size: cover; @endif" aria-labelledby="catalog-heading">
        <div class="catalog-hero__content">
            <p class="section-eyebrow">{{ $productCms('hero_eyebrow', 'Premium Ecosystem') }}</p>
            <h1 id="catalog-heading">{{ $productHeroTitle }}</h1>
            <p>{{ $productHeroDescription }}</p>
            <div class="catalog-hero__actions">
                <a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">{{ $productCms('hero_primary_button', 'Book Consultation') }}</a>
                <a class="btn catalog-hero__secondary" href="#solutions">{{ $productCms('hero_secondary_button', 'Explore Services') }}</a>
            </div>
        </div>
    </section>

    @if ($slug === 'smart-touch-switches')
        <section class="touch-intro section-space">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Why Smart Touch Switches') }}</p>
                        <h1 class="touch-intro__title">{!! nl2br(e($productCms('intro_title', "Elegant Control.\nDesigned for Modern Living."))) !!}</h1>
                        <p class="touch-intro__copy">{!! nl2br(e($productCms('intro_description', 'Experience the perfect combination of premium aesthetics and intelligent automation. Smart Illam Smart Touch Switches provide seamless control over lighting, fans, sockets, and connected devices through touch, smartphone, or voice commands—bringing comfort, elegance, and convenience to every room.'))) !!}</p>
                        <div class="touch-benefits">
                            @foreach ($touchIntroBenefits as $benefit)
                                <div><span aria-hidden="true"><img src="{{ asset($touchBenefitIcons[$loop->index] ?? $touchBenefitIcons[0]) }}" alt=""></span> {{ $benefit }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="touch-intro__visual">
                            <img src="{{ $productCmsImage('intro_image', 'images/touch-switch/touch-switch-wall.png') }}" alt="Smart touch switch installed on a modern wall">
                            <div class="touch-intro__note"><p class="section-eyebrow">{{ $productCms('touch_note_title', 'Tactile control') }}</p><p>{{ $productCms('touch_note_description', 'Thoughtful materials create a premium touchpoint that feels at home in every room.') }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="module-section section-space" aria-labelledby="module-heading">
            <div class="container">
                <div class="section-heading">
                    <p class="section-eyebrow">{{ $productCms('module_eyebrow', 'Find your fit') }}</p>
                    <h2 id="module-heading">{{ $productCms('module_heading', 'Explore Available Module Variants') }}</h2>
                    <ul class="nav nav-pills module-tabs" id="module-tabs" role="tablist">
                        @foreach ($touchModuleCounts as $moduleCount)
                            <li class="nav-item" role="presentation"><button class="nav-link {{ $loop->first ? 'active' : '' }}" id="module-{{ $moduleCount }}m-tab" data-bs-toggle="pill" data-bs-target="#module-{{ $moduleCount }}m" type="button" role="tab" aria-controls="module-{{ $moduleCount }}m" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $moduleCount }}M</button></li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content module-content" id="module-content">
                    @foreach ($touchModuleCounts as $moduleCount)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="module-{{ $moduleCount }}m" role="tabpanel" aria-labelledby="module-{{ $moduleCount }}m-tab" tabindex="0">
                            <div class="module-card">
                                <img class="module-card__image" src="{{ $productCmsImage('module_image', 'images/touch-switch/module-panel.jpg') }}" alt="{{ $moduleCount }} module smart touch switch panel">
                                <div class="module-card__details">
                                    <h3>{{ $productCms('module_title_prefix', 'The') }} {{ $moduleCount }}M {{ $loop->first ? $productCms('module_essential_suffix', 'Essential') : $productCms('module_control_suffix', 'Control Panel') }}</h3>
                                    <p>{{ $productCms('module_description', 'Perfect for bedside control and single-room lighting setups. A compact powerhouse of design.') }}</p>
                                    <ul class="module-feature-list">
                                        @foreach ($touchModuleFeatures as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="technical-card">
                    <div>
                        <p class="technical-card__eyebrow">{{ $productCms('technical_heading', 'Technical Specifications') }}</p>
                        <dl class="technical-list">
                            @foreach ($touchTechnicalLabels as $index => $label)
                                <div><dt>{{ $label }}</dt><dd>{{ $touchTechnicalValues[$index] ?? '' }}</dd></div>
                            @endforeach
                        </dl>
                    </div>
                    <img src="{{ $productCmsImage('technical_image', 'images/touch-switch/module-spec.jpg') }}" alt="Close-up of smart touch switch controls">
                </div>
            </div>
        </section>

        <section class="features-section section-space" aria-labelledby="features-heading">
            <div class="container">
                <div class="section-heading"><p class="section-eyebrow">{{ $productCms('features_eyebrow', 'Made for everyday living') }}</p><h2 id="features-heading">{{ $productCms('features_heading', 'Features') }}</h2></div>
                <div class="feature-grid">
                    @foreach ($touchFeatureNames as $index => $feature)
                        <article class="feature-tile"><img src="{{ $productCmsImage('feature_image_'.($index + 1), $touchFeatureImages[$index] ?? 'images/touch-switch/feature-touch.png') }}" alt="" aria-hidden="true"><h3>{{ $productCms('feature_name_'.($index + 1), $feature) }}</h3></article>
                    @endforeach
                </div>
            </div>
        </section>
    @elseif ($slug === 'smart-door-locks')
        <section class="door-intro section-space" aria-labelledby="door-heading">
            <div class="container door-intro__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/smart-door-locks/fingerprint-entry.png') }}" alt="Finger unlocking a smart door lock">
                    </div>
                    <div class="col-lg-6">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Smart Door Locks') }}</p>
                        <h1 class="door-intro__title" id="door-heading">{{ $productCms('intro_title', 'Secure Every Entrance. Effortlessly.') }}</h1>
                        <p class="door-intro__copy">{!! nl2br(e($productCms('intro_description', 'Experience the ultimate convergence of robust security and effortless convenience. Our smart locks are designed to blend seamlessly with high-end architectural aesthetics while providing military-grade encryption and multiple intuitive access methods.'))) !!}</p>
                        <ul class="door-benefits" aria-label="Smart door lock access methods">
                            @foreach ($productCmsLines('intro_benefits') as $index => $benefit)
                                <li><span aria-hidden="true">{{ ['▧', '▯', '▤', '⠿', '⚿'][$index] ?? '✦' }}</span>{{ $benefit }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="door-models section-space" aria-labelledby="door-models-heading">
            <div class="container door-models__container">
                <div class="section-heading">
                    <h2 id="door-models-heading">{{ $productCms('models_heading', 'Choose Your Model') }}</h2>
                    <div class="door-models__tabs" role="group" aria-label="Choose a smart lock model">
                        @foreach ($productCmsLines('model_names') as $model)
                            @php
                                $modelImageUrl = match (mb_strtoupper(trim($model))) {
                                    'ULTRA' => asset('images/smart-door-locks/ultra-lock.webp'),
                                    'NOVA' => asset('images/smart-door-locks/nova.webp'),
                                    'DL10V1' => asset('images/smart-door-locks/dl10v1.jpg'),
                                    'DL04V2' => asset('images/smart-door-locks/dl04v2.jpg'),
                                    'DL05V3' => asset('images/smart-door-locks/dl05v3.webp'),
                                    'DL01' => asset('images/smart-door-locks/dl01.webp'),
                                    'DFS04' => asset('images/smart-door-locks/dfs04.jpg'),
                                    default => $productCmsImage('model_image', 'images/smart-door-locks/model-lock.png'),
                                };
                            @endphp
                            <button class="{{ $loop->first ? 'active' : '' }}" type="button" data-door-model="{{ $model }}" data-model-image="{{ $modelImageUrl }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $model }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="door-model-carousel" data-door-model-carousel>
                    <button class="door-model-carousel__control door-model-carousel__control--previous" type="button" data-door-model-step="-1" aria-label="Previous lock model">
                        <img src="{{ asset('images/smart-door-locks/model-arrow.svg') }}" alt="" aria-hidden="true">
                    </button>
                    <div class="door-model-card">
                        <img src="{{ asset('images/smart-door-locks/ultra-lock.webp') }}" alt="Smart door lock with keypad and handle" data-selected-door-model-image>
                        <div class="door-model-card__specs">
                            <p class="technical-card__eyebrow">{{ $productCms('spec_heading', 'Specifications') }}</p>
                            <p class="door-model-card__selected">Selected model: <strong data-selected-door-model>ULTRA</strong></p>
                            <dl class="door-spec-list">
                                @foreach ($productCmsLines('spec_labels') as $index => $label)
                                    <div><dt>{{ $label }}</dt><dd>{{ $productCmsLines('spec_values')[$index] ?? '' }}</dd></div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                    <button class="door-model-carousel__control door-model-carousel__control--next" type="button" data-door-model-step="1" aria-label="Next lock model">
                        <img src="{{ asset('images/smart-door-locks/model-arrow.svg') }}" alt="" aria-hidden="true">
                    </button>
                </div>
            </div>
        </section>

        <section class="door-methods section-space" aria-labelledby="door-methods-heading">
            <div class="container">
                <div class="section-heading"><h2 id="door-methods-heading">{{ $productCms('methods_heading', 'Unlocking Methods') }}</h2></div>
                <div class="door-methods__grid">
                    @foreach ($productCmsLines('methods') as $method)
                        <article class="door-method-card">
                            @if (! empty($cmsContent['products.'.$slug.'.method_image_'.($loop->index + 1)]))
                                <img class="door-method-card__image door-method-card__image--custom" src="{{ $productCmsImage('method_image_'.($loop->index + 1), 'images/smart-door-locks/unlock-methods.png') }}" alt="{{ $productCms('method_name_'.($loop->index + 1), $method) }}">
                            @else
                                <span class="door-method-card__image" role="img" aria-label="{{ $productCms('method_name_'.($loop->index + 1), $method) }}" style="--door-method-sheet: url('{{ $productCmsImage('methods_image', 'images/smart-door-locks/unlock-methods.png') }}'); --door-method-x: {{ [0, 33.333, 66.667, 100][$loop->index % 4] }}%; --door-method-y: {{ $loop->index < 4 ? 0 : 100 }}%"></span>
                            @endif
                            <h3>{{ $productCms('method_name_'.($loop->index + 1), $method) }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @elseif ($slug === 'smart-security-systems')
        <section class="door-intro section-space" aria-labelledby="security-heading">
            <div class="container door-intro__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Smart Security System') }}</p>
                        <h1 class="door-intro__title" id="security-heading">{{ $productCms('intro_title', 'Smarter Entry. Better Security.') }}</h1>
                        @php
                            $securityIntroText = $productCms('intro_description', 'Our Smart Video Door Phone is designed to provide convenience and peace of mind by combining high-definition video monitoring, two-way communication, and mobile connectivity into one elegant security solution.' . "\n\n" . 'Whether you’re at home, at work, or traveling, you can monitor your entrance, answer visitors, and manage access directly from your mobile device.');
                            $securityIntroParas = preg_split('/\r\n\s*\r\n|\n\s*\n/', $securityIntroText);
                            if (count($securityIntroParas) === 1 && str_contains($securityIntroText, "\n")) {
                                $securityIntroParas = preg_split('/\r\n|\r|\n/', $securityIntroText);
                            }
                            $securityIntroParas = array_values(array_filter(array_map('trim', $securityIntroParas)));
                        @endphp
                        <div class="door-intro__copy">
                            @foreach ($securityIntroParas as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/smart-security-systems/fingerprint-entry.png') }}" alt="Fingerprint access control for a secure home entrance">
                    </div>
                </div>
            </div>
        </section>

        <section class="door-models security-specifications section-space" aria-labelledby="security-specifications-heading">
            <div class="container door-models__container">
                <div class="section-heading"><h2 id="security-specifications-heading">{{ $productCms('spec_heading', 'Explore Module Variants') }}</h2></div>
                <div class="door-model-card">
                    <img src="{{ $productCmsImage('spec_image', 'images/smart-security-systems/video-door-phone.png') }}" alt="Smart video door phone monitor and entrance camera">
                    <div class="door-model-card__specs">
                        <p class="technical-card__eyebrow">{{ $productCms('spec_label', 'Specification') }}</p>
                        <ul class="module-feature-list">
                            @foreach ($productCmsLines('spec_items') as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="security-features section-space" aria-labelledby="security-features-heading">
            <div class="container">
                <div class="section-heading">
                    <h2 id="security-features-heading">{{ $productCms('features_heading', 'Features') }}</h2>
                    <p>{{ $productCms('features_description', 'Designed for Modern Smart Homes') }}</p>
                </div>
                <div class="security-features__grid">
                    @foreach ($productCmsLines('feature_names') as $index => $feature)
                        <article class="security-feature-card">
                            <img class="security-feature-card__image" src="{{ $productCmsImage('feature_image_'.($index + 1), 'images/smart-security-systems/features/'.['video-monitoring.png', 'two-way-audio.png', 'app-notifications.png', 'remote-access.png', 'visitor-history.png', 'smart-integration.png'][$index]) }}" alt="{{ $feature }}">
                            <h3>{{ $productCms('feature_name_'.($index + 1), $feature) }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @elseif ($slug === 'voice-integrations')
        <section class="door-intro section-space voice-intro" aria-labelledby="voice-heading">
            <div class="container door-intro__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Voice Integrations') }}</p>
                        <h1 class="door-intro__title" id="voice-heading">{{ $productCms('intro_title', 'Intelligent Voice Control for Everyday Living') }}</h1>
                        @php
                            $voiceIntroText = $productCms('intro_description', "Voice Integration brings convenience, comfort, and efficiency to your smart home by allowing you to control connected devices using natural voice commands. Whether you’re at home or multitasking, simply speak to your preferred voice assistant to operate lighting, curtains, switches, and other compatible smart devices.\n\nDesigned for effortless interaction, our smart home ecosystem integrates with leading voice assistants, ensuring a seamless and intuitive user experience.");
                            $voiceIntroParas = preg_split('/\r\n\s*\r\n|\n\s*\n/', $voiceIntroText);
                            if (count($voiceIntroParas) === 1 && str_contains($voiceIntroText, "\n")) {
                                $voiceIntroParas = preg_split('/\r\n|\r|\n/', $voiceIntroText);
                            }
                            $voiceIntroParas = array_values(array_filter(array_map('trim', $voiceIntroParas)));
                        @endphp
                        <div class="door-intro__copy">
                            @foreach ($voiceIntroParas as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/voice-integrations/voice-control.png') }}" alt="A person controlling a smart speaker with a voice command">
                    </div>
                </div>
            </div>
        </section>

        <section class="voice-platform section-space" aria-labelledby="google-assistant-heading">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-md-4">
                        <img class="voice-platform__image" src="{{ $productCmsImage('google_image', 'images/voice-integrations/google-assistant.png') }}" alt="Google Assistant smart speaker">
                    </div>
                    <div class="col-md-8">
                        <h2 class="visually-hidden" id="google-assistant-heading">{{ $productCms('google_heading', 'Google Assistant') }}</h2>
                        <p class="voice-platform__copy">{{ $productCms('google_description', 'Control your smart home using simple voice commands through Google Assistant. Manage lighting, switches, curtains, and smart devices using compatible Google smart speakers and mobile devices.') }}</p>
                        <p class="voice-platform__eyebrow">{{ $productCms('platform_feature_label', 'Features') }}</p>
                        <ul class="voice-platform__features">
                            @foreach ($productCmsLines('google_features') as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="voice-platform voice-platform--muted section-space" aria-labelledby="amazon-alexa-heading">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-md-8 order-2 order-md-1">
                        <h2 class="visually-hidden" id="amazon-alexa-heading">{{ $productCms('alexa_heading', 'Amazon Alexa') }}</h2>
                        <p class="voice-platform__copy">{{ $productCms('alexa_description', 'Enjoy convenient voice control with Amazon Alexa. Operate your smart home devices, create personalized routines, and control multiple devices with a single command.') }}</p>
                        <p class="voice-platform__eyebrow">{{ $productCms('platform_feature_label', 'Features') }}</p>
                        <ul class="voice-platform__features">
                            @foreach ($productCmsLines('alexa_features') as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-4 order-1 order-md-2">
                        <img class="voice-platform__image" src="{{ $productCmsImage('alexa_image', 'images/voice-integrations/amazon-alexa.png') }}" alt="Amazon Alexa smart speaker">
                    </div>
                </div>
            </div>
        </section>

        <section class="voice-platform section-space" aria-labelledby="apple-homepod-heading">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-md-4">
                        <img class="voice-platform__image" src="{{ $productCmsImage('apple_image', 'images/voice-integrations/apple-homepod.png') }}" alt="Apple HomePod smart speakers">
                    </div>
                    <div class="col-md-8">
                        <h2 class="visually-hidden" id="apple-homepod-heading">{{ $productCms('apple_heading', 'Apple HomePod') }}</h2>
                        <p class="voice-platform__copy">{{ $productCms('apple_description', 'Experience intelligent home control within the Apple ecosystem using Apple HomePod. Control compatible smart home devices through Siri with secure and seamless integration.') }}</p>
                        <p class="voice-platform__eyebrow">{{ $productCms('platform_feature_label', 'Features') }}</p>
                        <ul class="voice-platform__features">
                            @foreach ($productCmsLines('apple_features') as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @elseif ($slug === 'cctv-surveillance-system')
        <section class="door-intro section-space" aria-labelledby="cctv-heading">
            <div class="container door-intro__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'CCTV Surveillance') }}</p>
                        <h1 class="door-intro__title" id="cctv-heading">{{ $productCms('intro_title', 'Intelligent Surveillance for Modern Homes & Businesses') }}</h1>
                        <p class="door-intro__copy">{!! nl2br(e($productCms('intro_description', 'A reliable surveillance system is the foundation of every secure property. Our Smart CCTV Surveillance Solutions combine advanced imaging technology, AI-powered monitoring, and seamless mobile connectivity to provide 24/7 protection for residential, commercial, and industrial environments.' . "\n" . 'Whether you’re monitoring your home, office, retail store, warehouse, or apartment, our CCTV systems provide complete visibility, smarter alerts, and effortless remote management.'))) !!}</p>
                    </div>
                    <div class="col-lg-6">
                        <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/cctv-surveillance-system/security-camera.png') }}" alt="Indoor CCTV camera in a modern room">
                    </div>
                </div>
            </div>
        </section>

        <section class="door-models cctv-models section-space" aria-labelledby="cctv-models-heading">
            <div class="container door-models__container">
                <div class="section-heading">
                    <h2 id="cctv-models-heading">{{ $productCms('models_heading', 'Choose Your Model') }}</h2>
                    <div class="door-models__tabs" role="group" aria-label="Choose a CCTV camera kit">
                        @foreach ($productCmsLines('model_names') as $model)
                            <button class="{{ $loop->first ? 'active' : '' }}" type="button" data-cctv-model="{{ $model }}" data-model-image="{{ match (mb_strtoupper(trim($model))) {
                                'WIFI CAMERA' => asset('images/cctv-surveillance-system/wifi-camera.webp'),
                                'IP CAMERA', 'IP CAMERA KIT' => asset('images/cctv-surveillance-system/ip-camera.jpg'),
                                default => $productCmsImage('model_image', 'images/cctv-surveillance-system/dome-camera.png'),
                            } }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $model }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="door-model-card cctv-model-card">
                    <img src="{{ $productCmsImage('model_image', 'images/cctv-surveillance-system/dome-camera.png') }}" alt="White dome CCTV surveillance camera" data-selected-cctv-model-image>
                    <div class="door-model-card__specs">
                        <p class="door-model-card__selected">{{ $productCms('kit_label', 'Selected kit:') }} <strong data-selected-cctv-model>{{ $productCmsLines('model_names')[0] ?? 'ANALOG CAMERA KIT' }}</strong></p>
                        <h3>{{ $productCms('components_heading', 'Included Components') }}</h3>
                        <ul class="module-feature-list">
                            @foreach ($productCmsLines('components') as $component)
                                <li>{{ $component }}</li>
                            @endforeach
                        </ul>
                        <h3 class="cctv-model-card__subheading">{{ $productCms('key_features_heading', 'Key Features') }}</h3>
                        <ul class="module-feature-list">
                            @foreach ($productCmsLines('key_features') as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="cctv-features section-space" aria-labelledby="cctv-features-heading">
            <div class="container">
                <div class="section-heading"><h2 id="cctv-features-heading">{{ $productCms('features_heading', 'Features') }}</h2></div>
                <div class="cctv-features__grid">
                    @foreach ($productCmsLines('feature_names') as $feature)
                        <article class="cctv-feature-card"><span aria-hidden="true">✦</span><h3>{{ $feature }}</h3></article>
                    @endforeach
                </div>
            </div>
        </section>
    @elseif ($slug === 'smart-curtain-control')
        <section class="curtain-intro section-space" aria-labelledby="curtain-heading">
            <div class="container curtain-intro__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Smart Curtain System') }}</p>
                        <h1 class="curtain-intro__title" id="curtain-heading">{{ $productCms('intro_title', 'Effortless Control. Intelligent Curtain Automation.') }}</h1>
                        <p class="curtain-intro__copy">{{ $productCms('intro_description', 'Transform your living spaces with Smart Illam Smart Curtain Control. Open and close curtains effortlessly using a remote, smartphone, scheduled automation, or voice commands. Designed for modern homes and offices, our intelligent curtain systems combine luxury, convenience, and seamless smart home integration.') }}</p>
                        <ul class="curtain-benefits" aria-label="Smart curtain control features">
                            @foreach ($productCmsLines('intro_benefits') as $index => $benefit)
                                <li><span aria-hidden="true">{{ ['✦', '▯', '♩', 'ϟ', '▦'][$index] ?? '✦' }}</span>{{ $benefit }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img class="curtain-intro__image" src="{{ $productCmsImage('intro_image', 'images/smart-curtain-control/living-room.png') }}" alt="Sunlit modern living room with automated curtains">
                    </div>
                </div>
            </div>
        </section>
        <section class="curtain-detail" aria-labelledby="curtain-detail-heading">
            <div class="container curtain-detail__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <img class="curtain-detail__image" src="{{ $productCmsImage('detail_image', 'images/smart-curtain-control/curtain-automation.png') }}" alt="Automated curtains in a contemporary living room">
                    </div>
                    <div class="col-lg-6">
                        <h2 id="curtain-detail-heading">{{ $productCms('detail_heading', 'Elegant Automation for Everyday Living') }}</h2>
                        <p>{{ $productCms('detail_description', 'Smart Curtain Automation Systems enable effortless control of motorized curtains and blinds through remote operation, scheduling, and voice commands. Integrated with your smart home ecosystem, they enhance privacy, improve energy efficiency, and provide exceptional convenience for both residential and commercial spaces.') }}</p>
                        <ul class="curtain-detail__features">
                            @foreach ($productCmsLines('detail_features') as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="curtain-motor section-space" aria-labelledby="curtain-motor-heading">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-7">
                        <h2 id="curtain-motor-heading">{{ $productCms('motor_heading', 'Evolix Curtain Motor') }}</h2>
                        <ul class="curtain-motor__features">
                            @foreach ($productCmsLines('motor_features') as $motorFeature)
                                @php([$featureTitle, $featureDescription] = array_pad(explode('|', $motorFeature, 2), 2, ''))
                                <li><span><strong>{{ $featureTitle }}</strong><br>{{ $featureDescription }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <img class="curtain-motor__image" src="{{ $productCmsImage('motor_image', 'images/smart-curtain-control/curtain-motor.png') }}" alt="Evolix motor for automated curtain tracks">
                    </div>
                </div>
            </div>
        </section>
        <section class="curtain-specifications section-space" aria-labelledby="curtain-specifications-heading">
            <div class="container">
                <div class="technical-card curtain-specs-card">
                    <div>
                        <p class="technical-card__eyebrow" id="curtain-specifications-heading">{{ $productCms('spec_heading', 'Technical Specifications') }}</p>
                        <dl class="technical-list">
                            @foreach ($productCmsLines('spec_labels') as $index => $label)
                                <div><dt>{{ $label }}</dt><dd>{{ $productCmsLines('spec_values')[$index] ?? '' }}</dd></div>
                            @endforeach
                        </dl>
                    </div>
                    <img src="{{ $productCmsImage('spec_image', 'images/smart-curtain-control/motor-track.png') }}" alt="Motorized curtain track and carriage system">
                </div>
            </div>
        </section>
        <section class="curtain-motion section-space" aria-labelledby="curtain-motion-heading">
            <div class="container curtain-motion__container">
                <h2 id="curtain-motion-heading">{{ $productCms('motion_heading', 'Experience the Motion') }}</h2>
                <p>{{ $productCms('motion_description', 'Drag the slider to preview the smooth opening and closing action.') }}</p>
                <div class="curtain-motion__stage" data-curtain-motion style="--curtain-open: 65%">
                    <img src="{{ $productCmsImage('motion_image', 'images/smart-curtain-control/curtain-motion.jpg') }}" alt="Warm bedroom with motorized curtains">
                    <span class="curtain-motion__panel curtain-motion__panel--left" aria-hidden="true"></span>
                    <span class="curtain-motion__panel curtain-motion__panel--right" aria-hidden="true"></span>
                </div>
                <div class="curtain-motion__controls">
                    <span aria-hidden="true">▥</span>
                    <input class="curtain-motion__slider" type="range" min="0" max="100" value="65" aria-label="Curtain opening level">
                    <span aria-hidden="true">⌗</span>
                </div>
            </div>
        </section>
    @elseif ($slug === 'retrofit-switches')
        <section class="door-intro section-space retrofit-intro" aria-labelledby="retrofit-heading">
            <div class="container door-intro__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-5">
                        <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/retrofit-switches/switch-intro.png') }}" alt="A hand operating a wall switch">
                    </div>
                    <div class="col-lg-7">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Retrofit Switches') }}</p>
                        <h1 class="door-intro__title" id="retrofit-heading">{{ $productCms('intro_title', 'Upgrade Smarter. Not Harder.') }}</h1>
                        <p class="door-intro__copy">{!! nl2br(e($productCms('intro_description', 'The Smart Retrofit Module Switch is designed to add intelligent automation to existing electrical systems without requiring major renovations or rewiring. Installed behind your current switch panel, it transforms conventional switches into smart controls, enabling remote operation, voice commands, automation schedules, and seamless smart home integration.' . "\n" . 'Ideal for homeowners who want to modernize their living spaces while preserving their existing switch designs.'))) !!}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="retrofit-specifications section-space" aria-labelledby="retrofit-specifications-heading">
            <div class="container">
                <div class="technical-card retrofit-spec-card">
                    <div>
                        <p class="technical-card__eyebrow" id="retrofit-specifications-heading">{{ $productCms('spec_heading', 'Technical Specifications') }}</p>
                        <dl class="technical-list">
                            @foreach ($productCmsLines('spec_labels') as $index => $label)
                                <div><dt>{{ $label }}</dt><dd>{{ $productCmsLines('spec_values')[$index] ?? '' }}</dd></div>
                            @endforeach
                        </dl>
                    </div>
                    <img src="{{ $productCmsImage('spec_image', 'images/retrofit-switches/module.png') }}" alt="Smart retrofit switch module">
                </div>
            </div>
        </section>

        <section class="retrofit-features section-space" aria-labelledby="retrofit-features-heading">
            <div class="container">
                <div class="section-heading">
                    <h2 id="retrofit-features-heading">{{ $productCms('features_heading', 'Features') }}</h2>
                    <p>{{ $productCms('features_description', 'Designed for Modern Smart Homes') }}</p>
                </div>
                <div class="retrofit-features__grid">
                    @foreach ($productCmsLines('feature_names') as $index => $feature)
                        <article class="retrofit-feature-card">
                            <img src="{{ $productCmsImage('feature_image_'.($index + 1), ['images/retrofit-switches/feature-remote.png', 'images/retrofit-switches/feature-voice.png', 'images/retrofit-switches/feature-timing.png', 'images/retrofit-switches/feature-share.png', 'images/touch-switch/feature-scenes.png', 'images/retrofit-switches/feature-power.png', 'images/retrofit-switches/feature-sync.png', 'images/retrofit-switches/feature-interlock.png'][$index] ?? 'images/retrofit-switches/feature-remote.png') }}" alt="" aria-hidden="true">
                            <h3>{{ $productCms('feature_name_'.($index + 1), $feature) }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @elseif ($slug === 'water-level-controllers')
        <section class="door-intro section-space water-intro" aria-labelledby="water-heading">
            <div class="container door-intro__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Water Level Controllers') }}</p>
                        <h1 class="door-intro__title" id="water-heading">{{ $productCms('intro_title', 'Smarter Water Control. Zero Wastage.') }}</h1>
                        <p class="door-intro__copy">{!! nl2br(e($productCms('intro_description', 'The Smart Water Level Controller automatically manages your water pump based on tank levels, eliminating the need for constant monitoring. Designed for residential, commercial, and industrial applications, it helps conserve water, reduce electricity consumption, and extend the lifespan of your pump.' . "\n" . 'Whether you’re at home or away, enjoy uninterrupted water availability with intelligent automation.'))) !!}</p>
                    </div>
                    <div class="col-lg-6">
                        <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/water-level-controllers/water-system.jpg') }}" alt="Water pipes and level control equipment in a utility room">
                    </div>
                </div>
            </div>
        </section>

        <section class="water-detail section-space" aria-labelledby="water-valve-heading">
            <div class="container water-detail__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-md-5">
                        <img class="water-detail__image" src="{{ $productCmsImage('valve_image', 'images/water-level-controllers/water-valve-controller.png') }}" alt="Motorized water valve controller">
                    </div>
                    <div class="col-md-7">
                        <h2 id="water-valve-heading">{{ $productCms('valve_heading', 'Water Valve Controller') }}</h2>
                        <ul class="water-detail__list">
                            @foreach ($productCmsLines('valve_features') as $valveFeature)
                                @php([$featureTitle, $featureDescription] = array_pad(explode('|', $valveFeature, 2), 2, ''))
                                <li><strong>{{ $featureTitle }}</strong><p>{{ $featureDescription }}</p></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="water-indicator section-space" aria-labelledby="water-indicator-heading">
            <div class="container water-indicator__container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-md-7">
                        <h2 id="water-indicator-heading">{{ $productCms('indicator_heading', 'Water Level Indicator') }}</h2>
                        <p class="water-indicator__eyebrow">{{ $productCms('indicator_features_label', 'Features') }}</p>
                        <ul class="water-indicator__list">
                            @foreach ($productCmsLines('indicator_features') as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                        <p class="water-indicator__eyebrow">{{ $productCms('pumps_label', 'Suitable Pumps / Starter') }}</p>
                        <ul class="water-indicator__list">
                            @foreach ($productCmsLines('pumps') as $pump)
                                <li>{{ $pump }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <img class="water-indicator__image" src="{{ $productCmsImage('indicator_image', 'images/water-level-controllers/water-level-indicator.png') }}" alt="Automatic water level controller with tank sensors">
                    </div>
                </div>
            </div>
        </section>
    @elseif (in_array($slug, ['swing-gate-automation', 'sliding-gate-automation'], true))
        @if ($slug === 'swing-gate-automation')
            <section class="door-intro section-space swing-gate-intro" aria-labelledby="swing-gate-heading">
                <div class="container door-intro__container">
                    <div class="row align-items-center g-4 g-lg-5">
                        <div class="col-lg-6">
                            <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Swing Gate Automation') }}</p>
                            <h1 class="door-intro__title" id="swing-gate-heading">{{ $productCms('intro_title', 'Intelligent Automation with Superior Performance') }}</h1>
                            <p class="door-intro__copy">{!! nl2br(e($productCms('intro_description', 'Our Swing Gate Automation System is engineered to provide effortless gate operation with advanced automation technology. Suitable for both residential and commercial applications, it combines smooth performance, intelligent safety features, and seamless smart connectivity to create a secure and convenient entrance solution.' . "\n" . 'Whether you’re upgrading an existing gate or installing a new automated entrance, the system is designed to deliver long-lasting reliability with minimal maintenance.'))) !!}</p>
                        </div>
                        <div class="col-lg-6">
                            <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/gate-automation/swing-gate.png') }}" alt="Automated swing gates opening at a residential entrance">
                        </div>
                    </div>
                </div>
            </section>

            <section class="door-models swing-gate-models section-space" aria-labelledby="swing-gate-models-heading">
                <div class="container door-models__container">
                    <div class="section-heading">
                        <h2 id="swing-gate-models-heading">{{ $productCms('models_heading', 'Choose Your Model') }}</h2>
                        <div class="door-models__tabs" role="group" aria-label="Choose a swing gate motor type">
                            @foreach ($productCmsLines('model_names') as $model)
                                <button class="{{ $loop->first ? 'active' : '' }}" type="button" data-gate-model="{{ $model }}" data-model-image="{{ mb_strtoupper(trim($model)) === 'ROLLER MOTOR TYPE' ? asset('images/gate-automation/roller-motor-type-detail.png') : $productCmsImage('model_image', 'images/gate-automation/swing-motor.png') }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $model }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="door-model-card swing-gate-model-card">
                        <img src="{{ $productCmsImage('model_image', 'images/gate-automation/swing-motor.png') }}" alt="Pair of linear arm motors for swing gates" data-selected-gate-model-image>
                        <button class="door-model-carousel__control swing-gate-model-card__next" type="button" data-gate-model-step="1" aria-label="Next swing gate motor type">
                            <img src="{{ asset('images/smart-door-locks/model-arrow.svg') }}" alt="" aria-hidden="true">
                        </button>
                        <div class="swing-gate-model-card__details">
                            <p class="swing-gate-model-card__selected">{{ $productCms('model_label', 'Selected type:') }} <strong data-selected-gate-model>{{ $productCmsLines('model_names')[0] ?? 'Arm Type' }}</strong></p>
                            <h3>{{ $productCms('motor_heading', 'Swing Gate Motor') }}</h3>
                            <p>{{ $productCms('motor_description', 'Enhance convenience and elegance with our Swing Gate Automation System, offering superior performance and style.') }}</p>
                            <ul class="swing-gate-model-card__features">
                                @foreach ($productCmsLines('motor_features') as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($slug === 'sliding-gate-automation')
            <section class="door-intro section-space sliding-gate-benefits" aria-labelledby="sliding-benefits-heading">
                <div class="container door-intro__container">
                    <div class="row align-items-center g-4 g-lg-5">
                        <div class="col-lg-6">
                            <p class="section-eyebrow">{{ $productCms('intro_eyebrow', 'Why Choose Smart Gate Automation') }}</p>
                            <h1 class="door-intro__title" id="sliding-benefits-heading">{{ $productCms('intro_title', 'Secure, Convenient & Intelligent') }}</h1>
                            <p class="door-intro__copy">{!! nl2br(e($productCms('intro_description', 'Our Smart Gate Automation systems combine powerful motors, intelligent controllers, and advanced safety features to automate gates of all sizes. Whether you need automation for a residential sliding gate, a luxury villa entrance, an apartment complex, or an industrial facility, we provide solutions that ensure secure, reliable, and effortless operation.'))) !!}</p>
                            <ul class="door-benefits sliding-gate-benefits__list" aria-label="Smart gate automation benefits">
                                @foreach ($productCmsLines('intro_benefits') as $benefit)
                                    <li><span aria-hidden="true">✦</span>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <img class="door-intro__image" src="{{ $productCmsImage('intro_image', 'images/gate-automation/sliding-overview.png') }}" alt="Automated sliding gate in front of a modern home at sunset">
                        </div>
                    </div>
                </div>
            </section>

            <section class="water-detail sliding-gate-overview section-space" aria-labelledby="sliding-overview-heading">
                <div class="container water-detail__container">
                    <div class="row align-items-center g-4 g-lg-5">
                        <div class="col-md-5">
                        <img class="water-detail__image" src="{{ $productCmsImage('overview_image', 'images/gate-automation/sliding-gate.png') }}" alt="Modern black sliding driveway gate">
                        </div>
                        <div class="col-md-7">
                        <h2 id="sliding-overview-heading">{{ $productCms('overview_heading', 'Smart Automation for Sliding Gates') }}</h2>
                        @foreach ($productCmsLines('overview_description') as $paragraph)
                            <p class="sliding-gate-overview__copy">{{ $paragraph }}</p>
                        @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="sliding-gate-motor section-space" aria-labelledby="sliding-motor-heading">
                <div class="container water-detail__container">
                    <div class="row align-items-center g-4 g-lg-5">
                        <div class="col-md-7">
                        <h2 id="sliding-motor-heading">{{ $productCms('motor_heading', 'Sliding Gate Motor') }}</h2>
                            <ul class="sliding-gate-motor__list">
                            @foreach ($productCmsLines('motor_features') as $motorFeature)
                                @php([$featureTitle, $featureDescription] = array_pad(explode('|', $motorFeature, 2), 2, ''))
                                <li><strong>{{ $featureTitle }}</strong><p>{{ $featureDescription }}</p></li>
                            @endforeach
                            </ul>
                        </div>
                        <div class="col-md-5">
                        <img class="sliding-gate-motor__image" src="{{ $productCmsImage('motor_image', 'images/gate-automation/sliding-motor.png') }}" alt="Sliding gate motor unit">
                        </div>
                    </div>
                </div>
            </section>

            <section class="sliding-gate-specs section-space" aria-labelledby="sliding-specs-heading">
                <div class="container">
                    <div class="technical-card">
                        <div>
                            <p class="technical-card__eyebrow" id="sliding-specs-heading">{{ $productCms('spec_heading', 'Technical Specifications') }}</p>
                            <dl class="technical-list">
                                @foreach ($productCmsLines('spec_labels') as $index => $label)
                                    <div><dt>{{ $label }}</dt><dd>{{ $productCmsLines('spec_values')[$index] ?? '' }}</dd></div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="gate-features section-space" aria-labelledby="gate-features-heading">
            <div class="container">
                <div class="section-heading">
                    <h2 id="gate-features-heading">{{ $productCms('features_heading', 'Features') }}</h2>
                </div>
                <div class="gate-features__grid">
                    @foreach ($productCmsLines('feature_names') as $index => $feature)
                        <article class="gate-feature-card">
                            <img src="{{ $productCmsImage('feature_image_'.($index + 1), ['images/gate-automation/features/remote-control.png', 'images/gate-automation/features/manual-override-keys.png', 'images/gate-automation/features/wifi-connectivity.png', 'images/gate-automation/features/mobile-app-notification.png', 'images/gate-automation/features/remote-access.png', 'images/gate-automation/features/weather-proof.png', 'images/gate-automation/features/rfid-card.png', 'images/gate-automation/features/motion-detection.png', 'images/gate-automation/features/smart-integration.png'][$index] ?? 'images/gate-automation/features/remote-control.png') }}" alt="" aria-hidden="true">
                            <h3>{{ $productCms('feature_name_'.($index + 1), $feature) }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="gate-demo section-space" aria-labelledby="gate-demo-heading">
            <div class="container gate-demo__container">
                <h2 id="gate-demo-heading">{{ $productCms('demo_heading', 'Try a Virtual Demo') }}</h2>
                <p>{{ $productCms('demo_description', 'See how the mobile app makes opening and monitoring your gate simple from anywhere.') }}</p>
                <img src="{{ $productCmsImage('demo_image', 'images/gate-automation/virtual-demo.png') }}" alt="Smart home app beside an automated sliding gate">
            </div>
        </section>
    @endif

    <section class="solutions-section catalog-solutions section-space" id="solutions" aria-labelledby="solutions-heading">
        <div class="container-fluid solutions-container">
            <div class="section-heading">
                <p class="section-eyebrow">{{ $productCms('related_eyebrow', 'Ecosystem') }}</p>
                <h2 id="solutions-heading">{{ $productCms('related_heading', 'Explore Smart Home Solutions') }}</h2>
                <span class="catalog-heading-rule" aria-hidden="true"></span>
            </div>
            <div class="solution-grid" role="list" aria-label="Smart home products">
                @foreach ($products as $slug => $item)
                    <article class="solution-card" role="listitem">
                        <img src="{{ \Illuminate\Support\Str::startsWith($item['image'], ['http://', 'https://', 'data:']) ? $item['image'] : asset($item['image']) }}" alt="{{ $item['alt'] }}">
                        <div class="solution-card__body">
                            <span aria-hidden="true">⌁</span>
                            <h3>{{ $item['name'] }}</h3>
                            <a href="{{ route('products.'.$slug) }}" @if (request()->routeIs('products.'.$slug)) aria-current="page" @endif>
                                Learn more <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <p class="catalog-scroll-hint">{{ $productCms('related_hint', 'Swipe or scroll to explore all products') }}</p>
        </div>
    </section>

    <section class="consultation-section" id="consultation" style="--consultation-image: url('{{ $productCmsImage('consultation_image', 'images/touch-switch/consultation-banner.png') }}')" aria-labelledby="consultation-heading">
        <div class="container consultation-content">
            <h2 id="consultation-heading">{{ $productCms('consultation_heading', 'Make Your Home Respond To You') }}</h2>
            <div>
                <a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">{{ $productCms('consultation_primary_button', 'Book Consultation') }}</a>
                <a class="btn consultation-secondary" href="mailto:info@smartillam.in">{{ $productCms('consultation_secondary_button', 'Request a Site Visit') }}</a>
            </div>
        </div>
    </section>

    @include('partials.site-footer')
@endsection
