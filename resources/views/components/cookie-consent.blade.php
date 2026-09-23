{{-- Cookie Consent Banner --}}
<div 
    x-data="{ 
        show: false,
        init() {
            // Show banner when cookie is missing or malformed so user can re-consent.
            const consentCookie = document.cookie
                .split('; ')
                .find((item) => item.startsWith('cookies_accepted='));

            if (!consentCookie) {
                this.show = true;
                return;
            }

            const rawValue = consentCookie.split('=').slice(1).join('=');
            const value = decodeURIComponent(rawValue).trim().toLowerCase();
            const validValues = ['true', 'false', '1', '0', 'yes', 'no'];

            this.show = !validValues.includes(value);
        },
        acceptCookies() {
            // Set cookie for 1 year
            const expires = new Date();
            expires.setFullYear(expires.getFullYear() + 1);
            const secure = window.location.protocol === 'https:' ? '; Secure' : '';
            document.cookie = `cookies_accepted=true; expires=${expires.toUTCString()}; path=/; SameSite=Lax${secure}`;
            this.show = false;
        },
        rejectCookies() {
            // Set cookie for 30 days
            const expires = new Date();
            expires.setDate(expires.getDate() + 30);
            const secure = window.location.protocol === 'https:' ? '; Secure' : '';
            document.cookie = `cookies_accepted=false; expires=${expires.toUTCString()}; path=/; SameSite=Lax${secure}`;
            this.show = false;
        }
    }"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-0 left-0 right-0 z-[9999] p-4 md:p-6"
    role="dialog"
    aria-labelledby="cookie-consent-title"
    style="display: none;"
>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-5 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                {{-- Icon & Content --}}
                <div class="flex items-start gap-4 flex-1">
                    {{-- Cookie Icon --}}
                    <div class="shrink-0 w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>

                    {{-- Text Content --}}
                    <div class="flex-1">
                        <h3 id="cookie-consent-title" class="text-base md:text-lg font-semibold text-slate-900 dark:text-white mb-2">
                            🍪 We use cookies to improve your experience
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            We use cookies to analyze website traffic and improve your experience. By accepting, you agree to our use of cookies for analytics purposes. Your data is anonymized and never shared with third parties.
                            <a href="{{ route('contact') }}" class="text-primary-600 dark:text-primary-400 hover:underline font-medium">Learn more</a>
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 shrink-0">
                    <button 
                        @click="rejectCookies"
                        type="button"
                        class="px-5 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 dark:focus:ring-slate-500"
                    >
                        Decline
                    </button>
                    <button 
                        @click="acceptCookies"
                        type="button"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 shadow-lg shadow-primary-500/25"
                    >
                        Accept Cookies
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
