/**
 * Professional Dark Mode Implementation
 * Provides comprehensive dark mode functionality with smooth transitions,
 * persistent settings, and proper accessibility support.
 */

class DarkModeManager {
  constructor() {
    this.darkModeClass = 'dark-mode';
    this.storageKey = 'darkModePreference';
    this.systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    this.currentMode = this.getStoredPreference();
    
    // Initialize dark mode
    this.init();
  }

  /**
   * Initialize dark mode functionality
   */
  init() {
    // Detect page-specific dark mode classes available on this page
    this.detectPageSpecificDarkClasses();

    // Decide initial mode: stored preference, else system preference
    const initialMode = (this.currentMode === null || this.currentMode === undefined)
      ? this.systemPrefersDark
      : this.currentMode;

    // Apply initial dark mode state
    this.applyDarkMode(!!initialMode);
    
    // Set up event listeners
    this.setupEventListeners();
    
    // Listen for system preference changes
    this.setupSystemPreferenceListener();
  }

  /**
   * Get stored dark mode preference from localStorage
   * @returns {boolean|null} - True if dark mode preferred, false if light mode preferred, null if not set
   */
  getStoredPreference() {
    const stored = localStorage.getItem(this.storageKey);
    return stored ? JSON.parse(stored) : null;
  }

  /**
   * Store dark mode preference in localStorage
   * @param {boolean} preference - True for dark mode, false for light mode
   */
  storePreference(preference) {
    localStorage.setItem(this.storageKey, JSON.stringify(preference));
  }

  /**
   * Apply dark mode to the document
   * @param {boolean} enable - True to enable dark mode, false to disable
   */
  applyDarkMode(enable) {
    // Smooth transition if user does not prefer reduced motion
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReduced) {
      document.documentElement.classList.add('theme-transition');
      document.body.classList.add('theme-transition');
      // Remove the transition helper after animation
      window.clearTimeout(this._transitionTimer);
      this._transitionTimer = window.setTimeout(() => {
        document.documentElement.classList.remove('theme-transition');
        document.body.classList.remove('theme-transition');
      }, 300);
    }

    if (enable) {
      document.documentElement.classList.add(this.darkModeClass);
      document.body.classList.add(this.darkModeClass);
      // Sync Bootstrap theme variable for better component theming
      document.documentElement.setAttribute('data-bs-theme', 'dark');

      // Apply any page-specific dark mode classes (e.g., login-dark-mode, projects-dark-mode)
      if (this.pageDarkClasses && this.pageDarkClasses.length) {
        this.pageDarkClasses.forEach(cls => {
          try { document.body.classList.add(cls); } catch (_) {}
        });
      }
    } else {
      document.documentElement.classList.remove(this.darkModeClass);
      document.body.classList.remove(this.darkModeClass);
      // Revert Bootstrap theme
      document.documentElement.setAttribute('data-bs-theme', 'light');

      // Remove page-specific dark classes when in light mode
      if (this.pageDarkClasses && this.pageDarkClasses.length) {
        this.pageDarkClasses.forEach(cls => {
          try { document.body.classList.remove(cls); } catch (_) {}
        });
      }
    }
    
    // Update accessibility panel button text
    this.updateAccessibilityButton(enable);
    
    // Dispatch custom event for other scripts to listen to
    window.dispatchEvent(new CustomEvent('darkModeChanged', {
      detail: { enabled: enable }
    }));
  }

  /**
   * Detect page-specific dark mode classes present on the page or implied by CSS assets
   * Example classes: login-dark-mode, projects-dark-mode, profile-dark-mode, assistant-dark-mode, admin-dark-mode
   */
  detectPageSpecificDarkClasses() {
    try {
      // Classes already present on body that end with '-dark-mode'
      const existing = Array.from(document.body.classList).filter(c => /-dark-mode$/i.test(c));

      // Infer from linked CSS assets named '*-dark-mode.css'
      const links = Array.from(document.querySelectorAll('link[rel="stylesheet"][href*="-dark-mode.css"]'));
      const inferred = links.map(link => {
        const href = link.getAttribute('href') || '';
        const fileName = (href.split('?')[0] || '').split('/').pop() || '';
        return fileName.replace(/\.css$/i, '');
      }).filter(Boolean);

      // Merge and dedupe
      const set = new Set([...existing, ...inferred]);
      this.pageDarkClasses = Array.from(set);
    } catch (_) {
      this.pageDarkClasses = [];
    }
  }

  /**
   * Update the accessibility panel button text based on current mode and language
   * @param {boolean} isDarkMode - Current dark mode state
   */
  updateAccessibilityButton(isDarkMode) {
    // Find the dark mode toggle button reliably by its onclick handler
    const darkModeButton = document.querySelector('.accessibility-panel button[onclick*="toggleDarkMode"]');
    if (!darkModeButton) return;
    
    const isArabic = document.documentElement.lang === 'ar';
    
    if (isDarkMode) {
      darkModeButton.textContent = isArabic ? 'تعطيل الوضع الداكن' : 'Disable Dark Mode';
    } else {
      darkModeButton.textContent = isArabic ? 'تفعيل الوضع الداكن' : 'Enable Dark Mode';
    }
  }

  /**
   * Toggle dark mode on/off
   */
  toggle() {
    this.currentMode = !document.body.classList.contains(this.darkModeClass);
    this.applyDarkMode(this.currentMode);
    this.storePreference(this.currentMode);
  }

  /**
   * Enable dark mode
   */
  enable() {
    this.currentMode = true;
    this.applyDarkMode(true);
    this.storePreference(true);
  }

  /**
   * Disable dark mode
   */
  disable() {
    this.currentMode = false;
    this.applyDarkMode(false);
    this.storePreference(false);
  }

  /**
   * Set up event listeners for dark mode controls
   */
  setupEventListeners() {
    // Listen for manual toggle requests
    window.addEventListener('toggleDarkMode', () => {
      this.toggle();
    });
    
    // Listen for enable requests
    window.addEventListener('enableDarkMode', () => {
      this.enable();
    });
    
    // Listen for disable requests
    window.addEventListener('disableDarkMode', () => {
      this.disable();
    });
  }

  /**
   * Set up listener for system preference changes
   */
  setupSystemPreferenceListener() {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      // Only apply system preference if user hasn't explicitly set a preference
      if (this.getStoredPreference() === null) {
        this.applyDarkMode(e.matches);
      }
    });
  }

  /**
   * Get current dark mode status
   * @returns {boolean} - True if dark mode is currently enabled
   */
  isEnabled() {
    return document.body.classList.contains(this.darkModeClass);
  }
}

// Initialize dark mode manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  // Create global dark mode manager instance
  window.darkModeManager = new DarkModeManager();
  
  // Expose toggle function globally for backward compatibility
  window.toggleDarkMode = () => {
    window.darkModeManager.toggle();
  };
  
  // Log initialization
  console.log('Dark Mode Manager initialized. Current mode:', window.darkModeManager.isEnabled() ? 'Dark' : 'Light');
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
  module.exports = DarkModeManager;
}