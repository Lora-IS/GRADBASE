// Language Preference Management
(function() {
    'use strict';

    // Get current language from URL or default to 'en'
    function getCurrentLanguage() {
        const path = window.location.pathname;
        if (path.includes('-ar.php') || path.includes('-ar.html')) {
            return 'ar';
        }
        return 'en';
    }

    // Set language preference
    function setLanguagePreference(lang) {
        if (!['ar', 'en'].includes(lang)) return false;

        // Set in localStorage
        localStorage.setItem('selectedLang', lang);
        
        // Set cookie with proper path and expiration (30 days)
        const expiryDate = new Date();
        expiryDate.setTime(expiryDate.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = `selectedLang=${lang}; expires=${expiryDate.toUTCString()}; path=/; SameSite=Lax`;

        // Set session via AJAX
        fetch('/E-library/pages/set-language.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `lang=${lang}`
        }).then(response => response.json())
          .then(data => {
              console.log('Language preference set:', data);
          })
          .catch(error => {
              console.error('Error setting language preference:', error);
          });

        return true;
    }

    // Get saved language preference
    function getSavedLanguage() {
        // Check localStorage first
        let saved = localStorage.getItem('selectedLang');
        if (saved && ['ar', 'en'].includes(saved)) {
            return saved;
        }

        // Check cookie
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            const [name, value] = cookie.trim().split('=');
            if (name === 'selectedLang' && ['ar', 'en'].includes(value)) {
                return value;
            }
        }

        return null;
    }

    // Initialize language preference system
    function initLanguagePreference() {
        const currentLang = getCurrentLanguage();
        const savedLang = getSavedLanguage();

        // Set current language as preference if not already set
        if (!savedLang) {
            setLanguagePreference(currentLang);
        }

        // Add click handlers to language switch links
        const langLinks = document.querySelectorAll('a[href*="-ar.php"], a[href*=".php"]:not([href*="-ar.php"])');
        langLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const targetLang = href.includes('-ar.php') ? 'ar' : 'en';
                setLanguagePreference(targetLang);
            });
        });

        // Add click handlers to language switch buttons with onclick
        document.addEventListener('click', function(e) {
            const target = e.target;
            if (target.matches('.language-switch a, .lang-btn')) {
                const href = target.getAttribute('href');
                if (href) {
                    const targetLang = href.includes('-ar.php') || href.includes('-ar.html') ? 'ar' : 'en';
                    setLanguagePreference(targetLang);
                }
            }
        });
    }

    // Auto-redirect based on saved preference (optional)
    function autoRedirectBasedOnPreference() {
        const currentLang = getCurrentLanguage();
        const savedLang = getSavedLanguage();
        
        if (savedLang && savedLang !== currentLang) {
            const currentPath = window.location.pathname;
            const currentParams = window.location.search;
            
            let targetPath;
            if (savedLang === 'ar' && !currentPath.includes('-ar.')) {
                // Switch to Arabic version
                targetPath = currentPath.replace(/\.php$/, '-ar.php').replace(/\.html$/, '-ar.html');
            } else if (savedLang === 'en' && currentPath.includes('-ar.')) {
                // Switch to English version
                targetPath = currentPath.replace(/-ar\.php$/, '.php').replace(/-ar\.html$/, '.html');
            }
            
            if (targetPath && targetPath !== currentPath) {
                // Only redirect if the target file would exist (basic check)
                window.location.href = targetPath + currentParams;
                return true;
            }
        }
        return false;
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLanguagePreference);
    } else {
        initLanguagePreference();
    }

    // Expose functions globally for manual use
    window.LanguagePreference = {
        set: setLanguagePreference,
        get: getSavedLanguage,
        current: getCurrentLanguage,
        autoRedirect: autoRedirectBasedOnPreference
    };

})();
