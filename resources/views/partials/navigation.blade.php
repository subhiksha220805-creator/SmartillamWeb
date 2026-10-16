<header class="site-header">
    <nav class="navbar navbar-expand-lg site-navbar" aria-label="Main navigation">
        <div class="container-fluid site-navbar__inner">
            <a class="navbar-brand site-navbar__brand" href="{{ url('/') }}" aria-label="Smartillam home">
                <img src="{{ \Illuminate\Support\Str::startsWith($cmsContent['brand.logo'] ?? 'images/smartillam-logo.png', ['http://', 'https://', 'data:']) ? $cmsContent['brand.logo'] : asset($cmsContent['brand.logo'] ?? 'images/smartillam-logo.png') }}" alt="{{ $cmsContent['brand.name'] ?? 'Smart Illam' }} — {{ $cmsContent['brand.tagline'] ?? 'Touch It Feel It' }}">
            </a>
            <button class="navbar-toggler site-navbar__toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse site-navbar__collapse" id="mainNavigation">
                <ul class="navbar-nav site-navbar__links">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ $cmsContent['home.nav_home'] ?? 'Home' }}</a></li>
                    <li class="nav-item"><a class="nav-link{{ request()->routeIs('solutions') ? ' active' : '' }}" href="{{ route('solutions') }}" @if (request()->routeIs('solutions')) aria-current="page" @endif>{{ $cmsContent['home.nav_solutions'] ?? 'Solutions' }}</a></li>
                    <li class="nav-item"><a class="nav-link{{ request()->routeIs('services') ? ' active' : '' }}" href="{{ route('services') }}" @if (request()->routeIs('services')) aria-current="page" @endif>{{ $cmsContent['home.nav_services'] ?? 'Services' }}</a></li>
                    <li class="nav-item dropdown site-navbar__dropdown">
                        <button class="nav-link site-navbar__product dropdown-toggle{{ request()->routeIs('products.*') ? ' active' : '' }}" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" @if (request()->routeIs('products.*')) aria-current="page" @endif>{{ $cmsContent['home.nav_products'] ?? 'Products' }}</button>
                        <div class="dropdown-menu site-products-menu">
                            <a class="site-products-menu__feature" data-product-feature href="{{ route('products.smart-touch-switches') }}" aria-label="Browse Smart Home Automation products">
                                <img data-product-feature-image src="{{ asset('images/smart-home-automation-feature.png') }}" alt="Smart home automation in a modern living room" loading="lazy">
                            </a>
                            <div class="site-products-menu__categories">
                                <p class="site-products-menu__eyebrow">Products</p>
                                <div class="nav nav-pills flex-column" id="product-categories" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link active" id="home-automation-tab" data-bs-toggle="pill" data-bs-target="#home-automation" data-feature-image="{{ asset('images/smart-home-automation-feature.png') }}" data-feature-alt="Smart home automation in a modern living room" data-feature-url="{{ route('products.smart-touch-switches') }}" data-feature-label="Browse Smart Home Automation products" type="button" role="tab" aria-controls="home-automation" aria-selected="true">Smart Home Automation</button>
                                    <button class="nav-link" id="gate-automation-tab" data-bs-toggle="pill" data-bs-target="#gate-automation" data-feature-image="{{ asset('images/smart-gate-automation-feature.png') }}" data-feature-alt="Automated gate at a contemporary home entrance" data-feature-url="{{ route('products.swing-gate-automation') }}" data-feature-label="Browse Smart Gate Automation products" type="button" role="tab" aria-controls="gate-automation" aria-selected="false">Smart Gate Automation</button>
                                </div>
                            </div>
                            <div class="site-products-menu__items tab-content" id="product-category-content">
                                <div class="tab-pane fade show active" id="home-automation" role="tabpanel" aria-labelledby="home-automation-tab" tabindex="0">
                                    <a href="{{ route('products.smart-touch-switches') }}">{{ $cmsContent['products.smart-touch-switches.name'] ?? 'Smart Touch Switches' }}</a>
                                    <a href="{{ route('products.smart-curtain-control') }}">{{ $cmsContent['products.smart-curtain-control.name'] ?? 'Smart Curtain Control' }}</a>
                                    <a href="{{ route('products.smart-door-locks') }}">{{ $cmsContent['products.smart-door-locks.name'] ?? 'Smart Door Locks' }}</a>
                                    <a href="{{ route('products.smart-security-systems') }}">{{ $cmsContent['products.smart-security-systems.name'] ?? 'Smart Security Systems' }}</a>
                                    <a href="{{ route('products.cctv-surveillance-system') }}">{{ $cmsContent['products.cctv-surveillance-system.name'] ?? 'CCTV Surveillance System' }}</a>
                                    <a href="{{ route('products.voice-integrations') }}">{{ $cmsContent['products.voice-integrations.name'] ?? 'Voice Integrations' }}</a>
                                    <a href="{{ route('products.retrofit-switches') }}">{{ $cmsContent['products.retrofit-switches.name'] ?? 'Retrofit Switches' }}</a>
                                    <a href="{{ route('products.water-level-controllers') }}">{{ $cmsContent['products.water-level-controllers.name'] ?? 'Water Level Controllers' }}</a>
                                </div>
                                <div class="tab-pane fade" id="gate-automation" role="tabpanel" aria-labelledby="gate-automation-tab" tabindex="0">
                                    <a href="{{ route('products.sliding-gate-automation') }}">{{ $cmsContent['products.sliding-gate-automation.name'] ?? 'Sliding Gate Automation' }}</a>
                                    <a href="{{ route('products.swing-gate-automation') }}">{{ $cmsContent['products.swing-gate-automation.name'] ?? 'Swing Gate Automation' }}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link{{ request()->routeIs('blog') ? ' active' : '' }}" href="{{ route('blog') }}" @if (request()->routeIs('blog')) aria-current="page" @endif>{{ $cmsContent['home.nav_blog'] ?? 'Blog' }}</a></li>
                    <li class="nav-item"><a class="nav-link{{ request()->routeIs('about') ? ' active' : '' }}" href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>{{ $cmsContent['home.nav_about'] ?? 'About' }}</a></li>
                    <li class="nav-item"><a class="nav-link{{ request()->routeIs('contact') ? ' active' : '' }}" href="{{ route('contact') }}" @if (request()->routeIs('contact')) aria-current="page" @endif>{{ $cmsContent['home.nav_contact'] ?? 'Contact' }}</a></li>
                </ul>
                <a class="btn site-navbar__cta" href="{{ route('contact') }}#contact-form">Book Consultation</a>
                <a class="admin-entry-button" href="{{ route('admin.login') }}">Admin</a>
            </div>
        </div>
    </nav>
</header>
