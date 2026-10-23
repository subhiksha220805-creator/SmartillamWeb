@extends('layouts.app')

@section('title', $cmsContent['contact.page_title'] ?? 'Contact Smart Illam | Smart Home Consultation')
@section('body-class', 'contact-page')

@section('content')
    <section class="contact-hero" aria-labelledby="contact-hero-title">
        <div class="contact-hero__image" role="img" aria-label="{{ $cmsContent['contact.hero_image_description'] ?? 'Warm, modern living room with smart home controls' }}" style="background-image: url('{{ \Illuminate\Support\Str::startsWith($cmsContent['contact.hero_image'] ?? 'images/contact/contact-hero.png', ['http://', 'https://', 'data:']) ? $cmsContent['contact.hero_image'] : asset($cmsContent['contact.hero_image'] ?? 'images/contact/contact-hero.png') }}')"></div>
        <div class="contact-hero__shade"></div>
        <div class="contact-hero__content">
            <h1 id="contact-hero-title">{{ $cmsContent['contact.hero_title'] ?? 'Let’s Build Your Smart Home' }}</h1>
            <p>{{ $cmsContent['contact.hero_description'] ?? 'Have questions about smart home automation, security, or connected living? Our team is here to help you find the right solution for your home or business.' }}</p>
            <div class="contact-hero__actions">
                <a class="btn site-navbar__cta" href="#contact-form">{{ $cmsContent['contact.hero_primary_button'] ?? 'Book Consultation' }}</a>
                <button class="contact-hero__secondary" type="button" data-brochure-open>{{ $cmsContent['contact.hero_secondary_button'] ?? 'Get Brochure' }}</button>
            </div>
        </div>
    </section>

    <div class="brochure-modal" data-brochure-modal hidden>
        <div class="brochure-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="brochure-modal-title" tabindex="-1">
            <button class="brochure-modal__close" type="button" aria-label="Close brochure form" data-brochure-close>×</button>
            <div class="brochure-modal__intro">
                <h2 id="brochure-modal-title">{{ $cmsContent['contact.brochure_modal_title'] ?? 'Get Our Brochure' }}</h2>
                <p>{{ $cmsContent['contact.brochure_modal_description'] ?? 'Fill in your details to download our smart home automation brochure.' }}</p>
                <div class="brochure-modal__cards">
                    <a class="brochure-modal__card" href="{{ $cmsContent['contact.map_url'] ?? 'https://share.google/XTFKc6t0ACAF0xF2y' }}" target="_blank" rel="noopener noreferrer"><span aria-hidden="true">⌖</span><small>{{ $cmsContent['contact.brochure_visit_label'] ?? 'Visit Us' }}</small><p>{{ $cmsContent['contact.address'] ?? 'No:123, ABC Towers, Coimbatore' }}</p></a>
                    <a class="brochure-modal__card" href="mailto:{{ $cmsContent['contact.email'] ?? 'buildingcare09@gmail.com' }}"><span aria-hidden="true">✉</span><small>{{ $cmsContent['contact.brochure_email_card_label'] ?? 'Drop us an email.' }}</small><p>{{ $cmsContent['contact.email'] ?? 'buildingcare09@gmail.com' }}</p></a>
                    <a class="brochure-modal__card" href="tel:{{ preg_replace('/[^0-9+]/', '', $cmsContent['contact.phone'] ?? '+91 9884882032') }}"><span aria-hidden="true">☎</span><small>{{ $cmsContent['contact.brochure_phone_card_label'] ?? 'Send us a message or call us for a quote.' }}</small><p>{{ $cmsContent['contact.phone'] ?? '+91 9884882032' }}</p></a>
                    <div class="brochure-modal__card brochure-modal__brand"><img src="{{ asset('images/smartillam-logo.png') }}" alt="Smart Illam"></div>
                </div>
            </div>
            <form class="brochure-modal__form" method="POST" action="{{ route('contact.submissions.store') }}">
                @csrf
                <input type="hidden" name="service" value="Brochure Request">
                <input type="hidden" name="contact_method" value="Email">
                <input type="hidden" name="requirements" value="Please send me the Smart Illam brochure.">
                <label>{{ $cmsContent['contact.brochure_first_name_label'] ?? 'First Name *' }}<input name="first_name" type="text" autocomplete="given-name" placeholder="{{ $cmsContent['contact.brochure_first_name_placeholder'] ?? 'Enter First Name' }}" maxlength="100" required></label>
                <label>{{ $cmsContent['contact.brochure_last_name_label'] ?? 'Last Name' }}<input name="last_name" type="text" autocomplete="family-name" placeholder="{{ $cmsContent['contact.brochure_last_name_placeholder'] ?? 'Enter Last Name' }}" maxlength="100"></label>
                <label>{{ $cmsContent['contact.brochure_email_label'] ?? 'Email *' }}<input name="email" type="email" autocomplete="email" placeholder="{{ $cmsContent['contact.brochure_email_placeholder'] ?? 'Enter Email' }}" maxlength="255" required></label>
                <label>{{ $cmsContent['contact.brochure_mobile_label'] ?? 'Mobile Number *' }}<span class="brochure-modal__phone"><span>{{ $cmsContent['contact.form_phone_prefix'] ?? '+91' }}</span><input name="phone" type="tel" inputmode="numeric" pattern="[0-9]{10}" autocomplete="tel-national" placeholder="{{ $cmsContent['contact.brochure_mobile_placeholder'] ?? 'Enter Number' }}" maxlength="10" minlength="10" required></span></label>
                <button class="brochure-modal__submit" type="submit">{{ $cmsContent['contact.brochure_submit_label'] ?? 'Download Brochure' }}</button>
            </form>
        </div>
    </div>

    <section class="contact-form-section" id="contact-form" aria-labelledby="contact-form-title">
        <div class="contact-form-section__content">
            <h2 id="contact-form-title">{{ $cmsContent['contact.form_title'] ?? 'Send us a message' }}</h2>
            <p class="contact-form-section__intro">{{ $cmsContent['contact.form_description'] ?? 'Have a question, need assistance, or looking for the right smart home solution? Fill out the form and our team will get back to you shortly.' }}</p>

            @if ($errors->any())
                <div class="contact-form-error" role="alert">{{ $errors->first() }}</div>
            @endif
            <form class="contact-form" method="POST" action="{{ route('contact.submissions.store') }}">
                @csrf
                <label>{{ $cmsContent['contact.form_first_name_label'] ?? 'First Name *' }}<input name="first_name" type="text" autocomplete="given-name" value="{{ old('first_name') }}" placeholder="{{ $cmsContent['contact.form_first_name_placeholder'] ?? 'Enter your first name' }}" maxlength="100" required></label>
                <label>{{ $cmsContent['contact.form_last_name_label'] ?? 'Last Name' }}<input name="last_name" type="text" autocomplete="family-name" value="{{ old('last_name') }}" placeholder="{{ $cmsContent['contact.form_last_name_placeholder'] ?? 'Enter your last name' }}" maxlength="100"></label>
                <label>{{ $cmsContent['contact.form_email_label'] ?? 'Email *' }}<input name="email" type="email" autocomplete="email" value="{{ old('email') }}" placeholder="{{ $cmsContent['contact.form_email_placeholder'] ?? 'Enter your email address' }}" maxlength="255" required></label>
                <label>{{ $cmsContent['contact.form_mobile_label'] ?? 'Mobile Number *' }}<span class="contact-form__phone"><span>{{ $cmsContent['contact.form_phone_prefix'] ?? '+91' }}</span><input name="phone" type="tel" inputmode="numeric" pattern="[0-9]{10}" autocomplete="tel-national" value="{{ old('phone') }}" placeholder="{{ $cmsContent['contact.form_mobile_placeholder'] ?? 'Enter your mobile number' }}" maxlength="10" minlength="10" required></span></label>
                <label>{{ $cmsContent['contact.form_service_label'] ?? 'I’m Interested In *' }}<select name="service" required><option value="" disabled @selected(old('service') === null)>{{ $cmsContent['contact.form_service_placeholder'] ?? 'Select a service' }}</option>@foreach (preg_split('/\r\n|\r|\n/', $cmsContent['contact.form_services'] ?? "Smart Home Automation\nSmart Touch Switches\nRetrofit Switches\nSmart Security Systems\nSmart Gate Automation\nOther", -1, PREG_SPLIT_NO_EMPTY) as $service)<option @selected(old('service') === $service)>{{ $service }}</option>@endforeach</select></label>
                <label>{{ $cmsContent['contact.form_method_label'] ?? 'Preferred Contact Method' }}<select name="contact_method"><option value="" disabled @selected(old('contact_method') === null)>{{ $cmsContent['contact.form_method_placeholder'] ?? 'Select a method' }}</option>@foreach (preg_split('/\r\n|\r|\n/', $cmsContent['contact.form_methods'] ?? "Email\nPhone\nWhatsApp", -1, PREG_SPLIT_NO_EMPTY) as $method)<option @selected(old('contact_method') === $method)>{{ $method }}</option>@endforeach</select></label>
                <label class="contact-form__message">{{ $cmsContent['contact.form_requirement_label'] ?? 'Tell us about your requirement' }}<textarea name="requirements" rows="3" maxlength="5000" placeholder="{{ $cmsContent['contact.form_requirement_placeholder'] ?? 'Briefly describe your project, requirements, or how we can help you.' }}">{{ old('requirements') }}</textarea></label>
                <button class="contact-form__submit" type="submit">{{ $cmsContent['contact.form_submit_label'] ?? 'Send Message' }}</button>
            </form>
            @if (session('contact_submission_status'))
                <div class="contact-form__toast" role="status" aria-live="polite">
                    <span class="contact-form__toast-icon" aria-hidden="true">✓</span>
                    <span>{{ session('contact_submission_status') }}</span>
                </div>
            @endif
        </div>
    </section>

    <section class="contact-details" aria-label="{{ $cmsContent['contact.details_label'] ?? 'Contact details' }}">
        <div class="contact-details__grid">
            <a class="contact-detail-card" href="{{ $cmsContent['contact.map_url'] ?? 'https://share.google/XTFKc6t0ACAF0xF2y' }}" target="_blank" rel="noopener noreferrer">
                <span class="contact-detail-card__icon" aria-hidden="true">⌖</span><h2>{{ $cmsContent['contact.address_title'] ?? 'Visit Us' }}</h2>
                <p>{{ $cmsContent['contact.address'] ?? 'D.No.2/950, Plot No.11 B, Periyar Nagar Main Road, Madipakkam, Chennai - 91.' }}</p>
            </a>
            <a class="contact-detail-card" href="mailto:{{ $cmsContent['contact.email'] ?? 'buildingcare09@gmail.com' }}">
                <span class="contact-detail-card__icon" aria-hidden="true">✉</span><h2>{{ $cmsContent['contact.email_title'] ?? 'Drop us an email.' }}</h2><p>{{ $cmsContent['contact.email'] ?? 'buildingcare09@gmail.com' }}</p>
            </a>
            <a class="contact-detail-card" href="tel:{{ preg_replace('/[^0-9+]/', '', $cmsContent['contact.phone'] ?? '+91 9884882032') }}">
                <span class="contact-detail-card__icon" aria-hidden="true">☎</span><h2>{{ $cmsContent['contact.phone_title'] ?? 'Call Us' }}</h2><p>{{ $cmsContent['contact.phone'] ?? '+91 9884882032' }}</p>
            </a>
        </div>
    </section>

    <section class="contact-map" aria-label="{{ $cmsContent['contact.map_section_label'] ?? 'Map to Smart Illam' }}">
        <a class="contact-map__link" href="{{ $cmsContent['contact.map_url'] ?? 'https://share.google/XTFKc6t0ACAF0xF2y' }}" target="_blank" rel="noopener noreferrer">{{ $cmsContent['contact.map_link_text'] ?? 'Open location in Google Maps' }} <span aria-hidden="true">↗</span></a>
        <iframe title="{{ $cmsContent['contact.map_frame_title'] ?? 'Map showing Smart Illam' }}" src="{{ $cmsContent['contact.map_embed_url'] ?? 'https://maps.google.com/maps?q=D.No.2%2F950%2C%20Plot%20No.11%20B%2C%20Periyar%20Nagar%20Main%20Road%2C%20Madipakkam%2C%20Chennai&t=&z=14&ie=UTF8&iwloc=&output=embed' }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </section>

    @include('partials.site-footer')
@endsection
