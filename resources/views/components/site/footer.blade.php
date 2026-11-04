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
                <div class="footer-socials" aria-label="Social media links">
                    <a class="is-instagram" href="https://www.instagram.com/invites/contact/?utm_content=aztaaiq&amp;exln=rw1ms9k6nfwz" target="_blank" rel="noopener noreferrer" aria-label="Follow Waheed Murad Tourism on Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
                    <a class="is-facebook" href="https://www.facebook.com/share/1Evp98Pa5Y/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" aria-label="Follow Waheed Murad Tourism on Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.5 8.5H17V5.2c-.43-.06-1.9-.2-3.61-.2-3.57 0-6.01 2.18-6.01 6.18v3.45H3.5v3.7h3.88V24h4.76v-5.67h3.72l.59-3.7h-4.31v-3.08c0-1.07.29-1.8 1.83-1.8Z" fill="currentColor" stroke="none"/></svg></a>
                    <a class="is-threads" href="https://www.threads.com/@waheedmuradtourism?invite=0" target="_blank" rel="noopener noreferrer" aria-label="Follow Waheed Murad Tourism on Threads"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.1 3.2c-4.7 0-7.7 3.1-7.7 8.5 0 5.8 3.2 9.1 8 9.1 4.2 0 7.2-2.4 7.2-6.1 0-3-1.8-5.1-5.4-5.1-3.2 0-5.1 1.7-5.1 4.2 0 2.1 1.5 3.4 3.6 3.4 1.8 0 3-1 3-2.6 0-1.8-1.6-2.8-3.7-2.8"/><path d="M8.1 7.5c.9-1.3 2.3-2 4.1-2 3.1 0 5 2 5.2 5.6"/></svg></a>
                    <a class="is-snapchat" href="https://snapchat.com/t/2CigttHi" target="_blank" rel="noopener noreferrer" aria-label="Follow Waheed Murad Tourism on Snapchat"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.2c-2.9 0-4.7 2-4.7 4.7v3c0 .6-.3 1.1-1 1.4l-1 .5c-.5.2-.5.9 0 1.1l1.7.6c.3.1.4.3.2.6l-.4.7c-.2.3 0 .7.4.7l1.5-.1c.3 0 .5.2.5.5l.1 1.4c0 .3.3.5.6.4l1.5-.6c.5-.2 1-.2 1.5 0l1.5.6c.3.1.6-.1.6-.4l.1-1.4c0-.3.2-.5.5-.5l1.5.1c.4 0 .6-.4.4-.7l-.4-.7c-.2-.3-.1-.5.2-.6l1.7-.6c.5-.2.5-.9 0-1.1l-1-.5c-.7-.3-1-.8-1-1.4v-3c0-2.7-1.8-4.7-4.7-4.7Z"/></svg></a>
                </div>
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
