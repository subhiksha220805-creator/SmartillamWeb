@extends('layouts.app')

@section('title', 'Smart Illam | Intelligent Home Automation')
@section('body-class', 'home-page')

@section('content')
    @php
        $homeDefaults = array_filter(
            config('cms.defaults', []),
            static fn (string $key): bool => str_starts_with($key, 'home.'),
            ARRAY_FILTER_USE_KEY,
        );
        $homeContent = array_replace($homeDefaults, $cmsContent);
        $homeImage = $cmsContent['home.feature_image'] ?? 'images/home/home-smart-living-room.svg';
        $homeImageUrl = \Illuminate\Support\Str::startsWith($homeImage, ['http://', 'https://', 'data:']) ? $homeImage : asset($homeImage);
        $homeBenefits = preg_split('/\r\n|\r|\n/', $cmsContent['home.feature_benefits'] ?? '', -1, PREG_SPLIT_NO_EMPTY);
        $homeHeroTitle = preg_replace(
            '/Smart Living Insights\s*&\s*Home Automation Guides/i',
            "Smart Living Insights &\nHome Automation Guides",
            $cmsContent['home.hero_title'] ?? 'Smart Living Insights & Home Automation Guides',
        );
        $homePhilosophyTitle = $cmsContent['home.philosophy_title'] ?? 'Invisible Intelligence.';
        $homeImageUrlFor = static function (string $key, string $fallback) use ($homeContent): string {
            $image = $homeContent[$key] ?? $fallback;

            return \Illuminate\Support\Str::startsWith($image, ['http://', 'https://', 'data:']) ? $image : asset($image);
        };
        $homeWorkImageNames = ['consultation', 'proposal', 'confirmation', 'installation', 'testing', 'training'];
        $homeWorkSteps = [];
        for ($step = 1; $step <= 6; $step++) {
            $homeWorkSteps[] = [
                'title' => $homeContent["home.work_step_{$step}_title"] ?? '',
                'description' => $homeContent["home.work_step_{$step}_description"] ?? '',
                'image' => $homeImageUrlFor("home.work_step_{$step}_image", 'images/home/home-work-'.$homeWorkImageNames[$step - 1].'.svg'),
                'image_alt' => $homeContent["home.work_step_{$step}_image_alt"] ?? '',
            ];
        }
        $homeDeviceCards = [
            ['image' => 'home.device_image_1', 'fallback' => 'images/home/device-alexa-card.png', 'alt' => 'home.device_image_1_alt', 'fallback_alt' => 'Amazon Alexa Echo — voice-controlled smart assistant'],
            ['image' => 'home.device_image_2', 'fallback' => 'images/home/device-nest-card.png', 'alt' => 'home.device_image_2_alt', 'fallback_alt' => 'Google Nest Hub — control your smart home effortlessly'],
            ['image' => 'home.device_image_3', 'fallback' => 'images/home/device-homepod-card.png', 'alt' => 'home.device_image_3_alt', 'fallback_alt' => 'Apple HomePod — premium smart speaker with Siri integration'],
        ];
    @endphp
    <section class="home-panel" id="home" aria-labelledby="page-title">
        <div class="home-panel__heading">
            <p class="home-eyebrow">{{ $cmsContent['home.hero_eyebrow'] ?? 'Smart Illam' }}</p>
            <h1 id="page-title">{!! nl2br(e($homeHeroTitle)) !!}</h1>
            <p class="home-panel__intro">{{ $cmsContent['home.hero_description'] ?? 'Stay informed with expert insights, practical tips, industry trends, and the latest innovations in smart home automation.' }}</p>
        </div>

        <article class="home-feature-card" id="solutions">
            <div class="home-feature-card__image">
                <img src="{{ $homeImageUrl }}" alt="{{ $cmsContent['home.feature_image_alt'] ?? 'Modern smart home living room with a connected control panel' }}" fetchpriority="high">
            </div>
            <div class="home-feature-card__content">
                <p class="home-eyebrow">{{ $cmsContent['home.feature_eyebrow'] ?? 'Thoughtful technology' }}</p>
                <h2>{{ $cmsContent['home.feature_title'] ?? 'Technology That Simplifies Everyday Living' }}</h2>
                <p>{{ $cmsContent['home.feature_description'] ?? 'We don’t just install devices; we craft intelligent environments tailored to your lifestyle. Our mission is to blend technology into the background, providing you with effortless control and peace of mind.' }}</p>
                <ul class="home-benefit-list">
                    @foreach ($homeBenefits as $benefit)
                        <li><span aria-hidden="true">✓</span> {{ $benefit }}</li>
                    @endforeach
                </ul>
                <a class="home-text-link" href="{{ $homeContent['home.feature_link_url'] ?? '#contact' }}">{{ $cmsContent['home.feature_link'] ?? 'Discover what’s possible' }} <span aria-hidden="true">↗</span></a>
            </div>
        </article>
    </section>

    <section class="home-demo-section" aria-labelledby="virtual-demo-title">
        <div class="home-section-heading">
            <p class="home-eyebrow">{{ $cmsContent['home.demo_eyebrow'] ?? 'See your smart home in action' }}</p>
            <h2 id="virtual-demo-title">{{ $cmsContent['home.demo_title'] ?? 'Try a Virtual Demo' }}</h2>
            <p>{{ $cmsContent['home.demo_description'] ?? 'Explore how connected controls can make everyday living more comfortable and convenient.' }}</p>
        </div>
        <div class="home-demo-visuals">
            <img class="home-demo-visuals__phone" src="{{ $homeImageUrlFor('home.demo_mobile_image', 'images/home/home-virtual-demo-mobile.svg') }}" alt="{{ $homeContent['home.demo_mobile_image_alt'] ?? 'Smart Illam mobile app showing living room climate, lighting, blinds and appliance controls' }}" loading="lazy">
            <img class="home-demo-visuals__house" src="{{ $homeImageUrlFor('home.demo_house_image', 'images/home/home-virtual-demo-house.svg') }}" alt="{{ $homeContent['home.demo_house_image_alt'] ?? 'Modern illuminated smart home at night' }}" loading="lazy">
            <div class="home-demo-live" data-home-demo data-demo-image-base="{{ asset('images/home/virtual-demo') }}">
                <div class="home-demo-live__phone" aria-label="Interactive Smart Illam home control app">
                    <div class="home-demo-live__screen">
                        <div class="home-demo-live__notch" aria-hidden="true"></div>
                        <div class="home-demo-live__phone-top"><span>9:41</span><span aria-hidden="true">● ● ●</span></div>
                        <div class="home-demo-live__hero">
                            <p>Good evening, Ramesh</p>
                            <h3>Living Room</h3>
                            <div class="home-demo-live__metrics"><span><b>24°</b><small>TEMP</small></span><span><b>52%</b><small>HUM</small></span><span><b>94</b><small>AQI</small></span></div>
                        </div>
                        <div class="home-demo-live__content">
                            <p class="home-demo-live__summary"><span data-demo-count>2</span> of 4 lights on <b data-demo-mood>Cozy evening</b></p>
                            <div class="home-demo-live__lights">
                                <button class="home-demo-live__light" type="button" data-demo-room="living" aria-pressed="true"><span class="home-demo-live__icon" aria-hidden="true">☼</span><span><b>Living Room</b><small>On</small></span><span class="home-demo-live__switch" aria-hidden="true"><i></i></span></button>
                                <button class="home-demo-live__light" type="button" data-demo-room="kitchen" aria-pressed="true"><span class="home-demo-live__icon" aria-hidden="true">☼</span><span><b>Kitchen</b><small>On</small></span><span class="home-demo-live__switch" aria-hidden="true"><i></i></span></button>
                                <button class="home-demo-live__light" type="button" data-demo-room="bedroom" aria-pressed="false"><span class="home-demo-live__icon" aria-hidden="true">☼</span><span><b>Bedroom</b><small>Off</small></span><span class="home-demo-live__switch" aria-hidden="true"><i></i></span></button>
                                <button class="home-demo-live__light" type="button" data-demo-room="parking" aria-pressed="false"><span class="home-demo-live__icon" aria-hidden="true">☼</span><span><b>Car Parking</b><small>Off</small></span><span class="home-demo-live__switch" aria-hidden="true"><i></i></span></button>
                            </div>
                            <button class="home-demo-live__master" type="button" data-demo-master>Turn all lights on</button>
                        </div>
                    </div>
                </div>
                <div class="home-demo-live__scene">
                    <img src="{{ asset('images/home/virtual-demo/living-kitchen-lit.png') }}" alt="Smart home with the living room and kitchen lights on" data-demo-house>
                    <p class="visually-hidden" aria-live="polite" data-demo-status>Tap a room switch to control its lights.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="home-promise-section" aria-labelledby="promise-title">
        <div class="home-section-heading">
            <h2 id="promise-title">{{ $cmsContent['home.promise_title'] ?? 'Our Promise to Your Home' }}</h2>
            <p>{{ $cmsContent['home.promise_description'] ?? 'Creating intelligent living spaces with seamless automation, premium technology, and personalized solutions.' }}</p>
        </div>
        <div class="home-promise-grid">
            <article class="home-promise-card home-promise-card--voice">
                <img src="{{ $homeImageUrlFor('home.promise_voice_image', 'images/home/home-voice-ai-card.svg') }}" alt="{{ $homeContent['home.promise_voice_image_alt'] ?? 'Voice and AI working in sync, with smart recommendations for comfort, efficiency and security' }}" loading="lazy">
            </article>
            <div class="home-promise-stack">
                <article class="home-promise-card home-promise-card--reliability">
                    <img src="{{ $homeImageUrlFor('home.promise_reliability_image', 'images/home/home-reliability-card.svg') }}" alt="{{ $homeContent['home.promise_reliability_image_alt'] ?? 'Intuitive design, smart reliability and thoughtful technology' }}" loading="lazy">
                </article>
                <article class="home-promise-card home-promise-card--console">
                    <img src="{{ $homeImageUrlFor('home.promise_console_image', 'images/home/home-device-alexa.svg') }}" alt="{{ $homeContent['home.promise_console_image_alt'] ?? 'Smart home voice assistant speaker' }}" loading="lazy">
                </article>
            </div>
            <article class="home-promise-card home-promise-card--device">
                <img src="{{ $homeImageUrlFor('home.promise_device_image', 'images/home/home-orris-device.svg') }}" alt="{{ $homeContent['home.promise_device_image_alt'] ?? 'Orris smart home voice assistant device' }}" loading="lazy">
                <div><h3>{{ $homeContent['home.promise_device_heading'] ?? 'Elevating Everyday' }}</h3><p>{{ $homeContent['home.promise_device_line_one'] ?? 'Living Through' }}<br>{{ $homeContent['home.promise_device_line_two'] ?? 'Intelligent Design' }}</p></div>
            </article>
        </div>
    </section>

    <section class="home-philosophy-section" aria-labelledby="philosophy-title">
        <div class="home-philosophy-inner">
            <div class="home-philosophy-copy">
                <p class="home-eyebrow">{{ $cmsContent['home.philosophy_eyebrow'] ?? 'The Philosophy' }}</p>
                <h2 id="philosophy-title">{!! nl2br(e($homePhilosophyTitle)) !!}</h2>
                <p>{{ $cmsContent['home.philosophy_description'] ?? 'We believe the best technology is the one you don’t see. Smart Illam integrates seamlessly into your life, anticipating your needs before you even realize them. It’s not about gadgets; it’s about grace.' }}</p>
                <div class="home-philosophy-points">
                    @for ($stat = 1; $stat <= 4; $stat++)
                        <div><strong>{{ $homeContent["home.philosophy_stat_{$stat}_value"] ?? '' }}</strong><span>{{ $homeContent["home.philosophy_stat_{$stat}_label"] ?? '' }}</span></div>
                    @endfor
                </div>
            </div>
            <div class="home-philosophy-image"><img src="{{ $homeImageUrlFor('home.philosophy_image', 'images/home/home-philosophy-background.svg') }}" alt="{{ $cmsContent['home.philosophy_image_alt'] ?? 'Modern home interior with layered lighting and smart controls' }}" loading="lazy"></div>
        </div>
    </section>

    <section class="home-devices-section" id="products" aria-labelledby="devices-title">
        <div class="home-devices-inner">
            <div class="home-devices-heading">
                <h2 id="devices-title">{{ $cmsContent['home.devices_title'] ?? 'Smart Devices for Living' }}</h2>
                <p>{{ $cmsContent['home.devices_description'] ?? 'Smart gadgets designed for connected homes, bringing intelligence and convenience to living.' }}</p>
            </div>
            <div class="home-device-cards">
                @foreach ($homeDeviceCards as $deviceCard)
                    <article class="home-device-card"><img src="{{ $homeImageUrlFor($deviceCard['image'], $deviceCard['fallback']) }}" alt="{{ $homeContent[$deviceCard['alt']] ?? $deviceCard['fallback_alt'] }}" loading="lazy"></article>
                @endforeach
            </div>
            <a class="home-products-link" href="{{ route('products.index') }}">{{ $homeContent['home.devices_link'] ?? 'View All Products' }} <span aria-hidden="true">↗</span></a>
        </div>
    </section>

    <section class="home-work-section" id="services" aria-labelledby="work-title">
        <div class="home-work-inner">
            <div class="home-work-heading"><h2 id="work-title">{{ $cmsContent['home.work_title'] ?? 'How We Work' }}</h2><p>{{ $cmsContent['home.work_description'] ?? 'Every project begins with understanding your unique requirements.' }}</p></div>
            <div class="home-work-steps">
                @foreach ($homeWorkSteps as $index => $step)
                    <article class="home-work-step">
                        @if ($index % 2 === 0)
                            <p class="home-work-step__description">{{ $step['description'] }}</p>
                            <div class="home-work-step__visual"><img src="{{ $step['image'] }}" alt="{{ $step['image_alt'] }}" loading="lazy"></div>
                            <div class="home-work-step__title"><span>{{ sprintf('%02d', $index + 1) }}</span><h3>{!! nl2br(e($step['title'])) !!}</h3></div>
                        @else
                            <div class="home-work-step__title"><span>{{ sprintf('%02d', $index + 1) }}</span><h3>{!! nl2br(e($step['title'])) !!}</h3></div>
                            <div class="home-work-step__visual"><img src="{{ $step['image'] }}" alt="{{ $step['image_alt'] }}" loading="lazy"></div>
                            <p class="home-work-step__description">{{ $step['description'] }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="home-results-section" aria-labelledby="results-title">
        <div class="home-results-inner">
            <div class="home-results-heading">
                <div><p class="home-eyebrow">{{ $cmsContent['home.results_eyebrow'] ?? 'Built on Trust' }}</p><h2 id="results-title">{{ $cmsContent['home.results_title'] ?? 'Proven Results. Satisfied Clients.' }}</h2></div>
                <p>{{ $cmsContent['home.results_description'] ?? 'Discover how Smart Illam is helping homeowners create safer, smarter and more connected lifestyles.' }}</p>
            </div>
            <div class="home-results-grid">
                <article class="home-results-stat">
                    <p>{{ $homeContent['home.results_stat_intro'] ?? 'Making Homes Smarter, One Tap at a time for Comfort, Convenience and Seamless Living' }}</p>
                    <div><strong>{{ $homeContent['home.results_stat_value'] ?? '98%' }}</strong><span>{{ $homeContent['home.results_stat_label'] ?? 'Of users report convenience in daily life' }}</span></div>
                </article>
                <div class="home-results-feature">
                    <div class="home-results-banner"><span aria-hidden="true"></span>{{ $homeContent['home.results_banner'] ?? 'Secure, Seamless, Effortless' }}</div>
                    <img src="{{ $homeImageUrlFor('home.results_image', 'images/home/home-client-story.svg') }}" alt="{{ $homeContent['home.results_image_alt'] ?? 'Smart Illam client sharing his experience' }}" loading="lazy">
                </div>
                <blockquote class="home-testimonial">
                    <span class="home-testimonial__quote" aria-hidden="true">“</span>
                    <p>{{ $cmsContent['home.testimonial'] ?? 'Smart Illam completely transformed our home. Lighting, security, and entertainment are now just one tap away. The installation was smooth, and the support team was exceptional.' }}</p>
                    <footer><span><strong>{{ $homeContent['home.testimonial_name'] ?? 'Ramesh Kumar' }}</strong><small>{{ $homeContent['home.testimonial_location'] ?? 'Chennai' }}</small></span><span class="home-testimonial__arrows" aria-hidden="true"><i>←</i><i>→</i></span></footer>
                </blockquote>
            </div>
        </div>
    </section>

    @include('partials.site-footer')
@endsection
