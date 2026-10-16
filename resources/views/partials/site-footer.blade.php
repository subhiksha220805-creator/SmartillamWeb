<footer class="site-footer" id="contact">
    <div class="container">
        <div class="row g-4 footer-main">
            <div class="col-12 col-lg-4 footer-brand">
                <img src="{{ \Illuminate\Support\Str::startsWith($cmsContent['brand.logo'] ?? 'images/smartillam-logo.png', ['http://', 'https://', 'data:']) ? $cmsContent['brand.logo'] : asset($cmsContent['brand.logo'] ?? 'images/smartillam-logo.png') }}" alt="{{ $cmsContent['brand.name'] ?? 'Smart Illam' }} — {{ $cmsContent['brand.tagline'] ?? 'Touch It Feel It' }}">
            </div>
            <div class="col-6 col-lg-2">
                <h2>{{ $cmsContent['contact.footer_quick_links_title'] ?? 'Quick Links' }}</h2>
                <a href="{{ url('/') }}">{{ $cmsContent['contact.footer_home_link'] ?? 'Home' }}</a>
                <a href="{{ route('solutions') }}">{{ $cmsContent['contact.footer_solutions_link'] ?? 'Solutions' }}</a>
                <a href="{{ route('blog') }}">{{ $cmsContent['contact.footer_blog_link'] ?? 'Blog' }}</a>
                <a href="{{ route('services') }}">{{ $cmsContent['contact.footer_services_link'] ?? 'Services' }}</a>
                <a href="{{ url('/#contact') }}">{{ $cmsContent['contact.footer_contact_link'] ?? 'Contact Us' }}</a>
            </div>
            <div class="col-6 col-lg-2">
                <h2>{{ $cmsContent['contact.footer_address_title'] ?? 'Address' }}</h2>
                <p class="footer-icon-line"><img src="{{ asset('images/icons/footer-location.svg') }}" alt=""><span>{{ $cmsContent['contact.address'] ?? 'No 129, ABC Complex, Coimbatore' }}</span></p>
            </div>
            <div class="col-6 col-lg-2">
                <h2>{{ $cmsContent['contact.footer_contact_title'] ?? 'Contact Us' }}</h2>
                <a class="footer-icon-line" href="mailto:{{ $cmsContent['contact.email'] ?? 'info@smartillam.in' }}"><span aria-hidden="true">✉</span><span>{{ $cmsContent['contact.email'] ?? 'info@smartillam.in' }}</span></a>
                <a class="footer-icon-line" href="tel:{{ preg_replace('/[^0-9+]/', '', $cmsContent['contact.phone'] ?? '+91 9876543210') }}"><span aria-hidden="true">☎</span><span>{{ $cmsContent['contact.phone'] ?? '+91 9876543210' }}</span></a>
            </div>
            <div class="col-6 col-lg-2">
                <h2>{{ $cmsContent['contact.footer_social_title'] ?? 'Social Links' }}</h2>
                <a class="footer-icon-line" href="{{ $cmsContent['contact.social_linkedin'] ?? 'https://www.linkedin.com/' }}" aria-label="{{ $cmsContent['contact.footer_linkedin_label'] ?? 'LinkedIn' }}"><span class="social-icon social-icon--linkedin" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5.2 8.7H2.1V22h3.1V8.7ZM3.65 2a1.8 1.8 0 1 0 0 3.6 1.8 1.8 0 0 0 0-3.6ZM22 14.4c0-4-2.1-5.9-4.9-5.9a4.2 4.2 0 0 0-3.7 2V8.7h-3V22h3.1v-6.6c0-1.8.3-3.6 2.6-3.6s2.3 2.1 2.3 3.7V22h3.2l.4-7.6Z"/></svg></span><span>{{ $cmsContent['contact.footer_linkedin_label'] ?? 'LinkedIn' }}</span></a>
                <a class="footer-icon-line" href="{{ $cmsContent['contact.social_facebook'] ?? 'https://www.facebook.com/' }}" aria-label="{{ $cmsContent['contact.footer_facebook_label'] ?? 'Facebook' }}"><span class="social-icon social-icon--facebook" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M14.2 22v-9.1h3.1l.5-3.6h-3.6V7c0-1 .3-1.8 1.8-1.8H18V2a20 20 0 0 0-2.9-.2c-2.9 0-4.9 1.8-4.9 5V9.3H7v3.6h3.2V22h4Z"/></svg></span><span>{{ $cmsContent['contact.footer_facebook_label'] ?? 'Facebook' }}</span></a>
                <a class="footer-icon-line" href="{{ $cmsContent['contact.social_instagram'] ?? 'https://www.instagram.com/' }}" aria-label="{{ $cmsContent['contact.footer_instagram_label'] ?? 'Instagram' }}"><span class="social-icon social-icon--instagram" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle class="social-icon__dot" cx="17.5" cy="6.7" r="1.2"/></svg></span><span>{{ $cmsContent['contact.footer_instagram_label'] ?? 'Instagram' }}</span></a>
                <a class="footer-icon-line" href="{{ $cmsContent['contact.social_x'] ?? 'https://x.com/' }}" aria-label="{{ $cmsContent['contact.footer_x_label'] ?? 'Twitter' }}"><span class="social-icon social-icon--x" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M18.9 2h3.3L15 10.2 23.5 22h-6.7l-5.2-7.2L5.3 22H2l7.7-8.9L1.6 2h6.9l4.7 6.6L18.9 2Zm-1.2 17.9h1.8L7.5 4H5.6l12.1 15.9Z"/></svg></span><span>{{ $cmsContent['contact.footer_x_label'] ?? 'Twitter' }}</span></a>
            </div>
        </div>
        <div class="footer-copyright">© {{ date('Y') }} {{ $cmsContent['brand.name'] ?? 'Smart Illam' }} - {{ $cmsContent['contact.footer_copyright'] ?? 'All Rights Reserved.' }}</div>
    </div>
    <a class="back-to-top" href="#page-top" aria-label="Back to top"><img src="{{ asset('images/icons/back-to-top.png') }}" alt=""></a>
    <a class="whatsapp-link" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cmsContent['contact.whatsapp_phone'] ?? '919876543210') }}" target="_blank" rel="noreferrer" aria-label="{{ $cmsContent['contact.footer_whatsapp_label'] ?? 'Chat with Smart Illam on WhatsApp' }}"><img src="{{ asset('images/icons/whatsapp.png') }}" alt=""></a>
</footer>
