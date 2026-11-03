@php
    $footerLanguages = [
        'en' => 'English', 'ar' => 'العربية — Arabic', 'bn' => 'বাংলা — Bengali', 'bg' => 'Български — Bulgarian',
        'ca' => 'Català', 'zh-CN' => '中文（简体）', 'hr' => 'Hrvatski', 'cs' => 'Čeština', 'da' => 'Dansk',
        'nl' => 'Nederlands', 'et' => 'Eesti', 'tl' => 'Filipino', 'fi' => 'Suomi', 'fr' => 'Français',
        'de' => 'Deutsch', 'el' => 'Ελληνικά', 'gu' => 'ગુજરાતી', 'he' => 'עברית', 'hi' => 'हिन्दी',
        'hu' => 'Magyar', 'id' => 'Bahasa Indonesia', 'it' => 'Italiano', 'ja' => '日本語', 'kn' => 'ಕನ್ನಡ',
        'ko' => '한국어', 'lv' => 'Latviešu', 'lt' => 'Lietuvių', 'ms' => 'Bahasa Melayu', 'ml' => 'മലയാളം',
        'mr' => 'मराठी', 'no' => 'Norsk', 'fa' => 'فارسی', 'pl' => 'Polski', 'pt' => 'Português',
        'pa' => 'ਪੰਜਾਬੀ', 'ro' => 'Română', 'ru' => 'Русский', 'sr' => 'Српски', 'sk' => 'Slovenčina',
        'sl' => 'Slovenščina', 'es' => 'Español', 'sw' => 'Kiswahili', 'sv' => 'Svenska', 'ta' => 'தமிழ்',
        'te' => 'తెలుగు', 'th' => 'ไทย', 'tr' => 'Türkçe', 'uk' => 'Українська', 'ur' => 'اردو — Urdu', 'vi' => 'Tiếng Việt',
    ];
    $footerCurrencies = [
        'USD' => 'United States Dollar', 'AED' => 'Emirati Dirham', 'GBP' => 'British Pound', 'EUR' => 'Euro',
        'AUD' => 'Australian Dollar', 'CAD' => 'Canadian Dollar', 'ZAR' => 'South African Rand', 'INR' => 'Indian Rupee',
        'PKR' => 'Pakistani Rupee', 'SGD' => 'Singapore Dollar', 'PHP' => 'Philippine Peso', 'BHD' => 'Bahraini Dinar',
        'BRL' => 'Brazilian Real', 'CNY' => 'Chinese Yuan', 'DKK' => 'Danish Krone', 'HKD' => 'Hong Kong Dollar',
        'IDR' => 'Indonesian Rupiah', 'JPY' => 'Japanese Yen', 'KWD' => 'Kuwaiti Dinar', 'MYR' => 'Malaysian Ringgit',
        'MXN' => 'Mexican Peso', 'NOK' => 'Norwegian Krone', 'NZD' => 'New Zealand Dollar', 'OMR' => 'Omani Rial',
        'QAR' => 'Qatari Riyal', 'SAR' => 'Saudi Riyal', 'SEK' => 'Swedish Krona', 'CHF' => 'Swiss Franc',
        'THB' => 'Thai Baht', 'TRY' => 'Turkish Lira',
    ];
@endphp

<footer class="site-footer" id="contact">
    <div class="footer-ribbon" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
    <div class="header-container footer-top">
        <div class="footer-grid">
            <div class="footer-brand-column">
                <a class="footer-brand" href="{{ route('home') }}" aria-label="Waheed Murad Tourism home"><img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism"><span><strong>Waheed Murad</strong><small>Tourism</small></span></a>
                <p class="footer-subscribe-copy">Get Dubai ideas, seasonal offers and travel inspiration in your inbox.</p>
                <a class="footer-subscribe-button" href="{{ route('home') }}#booking">Get travel updates <span aria-hidden="true">→</span></a>
                <div class="footer-socials" aria-label="Social media links"><a href="#contact" aria-label="Instagram">ig</a><a href="#contact" aria-label="Facebook">f</a><a href="#contact" aria-label="Trip advisor">ta</a><a href="#contact" aria-label="LinkedIn">in</a></div>
            </div>
            <div class="footer-col"><h4>Contact Us</h4><ul class="footer-contact-list"><li><span aria-hidden="true">☎</span><a href="tel:+9718002722426">+971 800 272 2426<br>+971 800 ARABIAN</a></li><li><span aria-hidden="true">◉</span><a href="https://wa.me/97142748803" target="_blank" rel="noopener noreferrer">+971 4 274 8803</a></li><li><span aria-hidden="true">✉</span><a href="mailto:aaonline@arabian-adventures.com">aaonline@arabian-adventures.com</a></li><li><span aria-hidden="true">➤</span><a href="#contact">Contact Us</a></li><li><span aria-hidden="true">⌖</span><a href="{{ route('where-to-find-us') }}">Where to find us</a></li></ul></div>
            <div class="footer-col"><h4>Our Adventures</h4><ul class="footer-links"><li><a href="{{ route('desert-safaris') }}">Desert Safaris</a></li><li><a href="{{ route('city-tours') }}">City Tours</a></li><li><a href="{{ route('cruise-boat-tours') }}">Cruise &amp; Boat Tours</a></li><li><a href="{{ route('waterparks-theme-parks') }}">Waterparks &amp; Theme Parks</a></li><li><a href="{{ route('sports-events') }}">Sports</a></li><li><a href="{{ url('/') }}#moments">Blogs</a></li></ul></div>
            <div class="footer-col"><h4>About Us</h4><ul class="footer-links"><li><a href="{{ route('why-us') }}">Why Choose Us</a></li><li><a href="{{ route('where-to-find-us') }}">Where To Find Us</a></li><li><a href="{{ route('travel-agent-partners') }}">Travel Agent Partners</a></li><li><a href="{{ route('meetings-incentives-events') }}">Meetings, Incentives &amp; Events</a></li><li><a href="{{ route('signature-events') }}">Signature Events</a></li></ul></div>
            <div class="footer-col"><h4>Terms &amp; Conditions</h4><ul class="footer-links"><li><a href="{{ route('guidelines') }}">Guidelines</a></li><li><a href="{{ route('cancellation-refund-policy') }}">Cancellation &amp; Refund Policy</a></li><li><a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a></li></ul></div>
        </div>
    </div>
    <div class="header-container footer-bottom">
        <div class="footer-meta-selects" aria-label="Website preferences">
            <details class="footer-preference" data-language-preference>
                <summary><span data-language-current>English</span><i aria-hidden="true"></i></summary>
                <div class="footer-preference-menu footer-language-menu">
                    <p>Change language</p>
                    <div class="footer-preference-options">
                        @foreach ($footerLanguages as $languageCode => $languageLabel)
                            <button type="button" data-language-option data-language="{{ $languageCode }}">{{ $languageLabel }}</button>
                        @endforeach
                    </div>
                </div>
            </details>
            <details class="footer-preference" data-currency-preference>
                <summary><span data-currency-current>PKR</span><i aria-hidden="true"></i></summary>
                <div class="footer-preference-menu footer-currency-menu">
                    <p>Change currency</p>
                    <div class="footer-preference-options">
                        @foreach ($footerCurrencies as $currencyCode => $currencyLabel)
                            <button type="button" data-currency-option data-currency="{{ $currencyCode }}"><b>{{ $currencyCode }}</b><span>{{ $currencyLabel }}</span></button>
                        @endforeach
                    </div>
                    <small>Display conversion is indicative. Your final price is confirmed at checkout.</small>
                </div>
            </details>
        </div>
        <span>&copy; {{ date('Y') }} Waheed Murad Tourism. All rights reserved.</span>
        <span>Dubai, United Arab Emirates</span>
    </div>
    <div id="wmt-google-translate" class="wmt-google-translate" aria-hidden="true"></div>
</footer>
