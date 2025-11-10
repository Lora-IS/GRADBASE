function toggleAccessibilityPanel() {
    const panel = document.getElementById('accessibility-panel');
    panel.style.display = panel.style.display === 'flex' ? 'none' : 'flex';
}

let speechInstance;

function startSpeech() {
  const text = document.body.innerText;
  speechInstance = new SpeechSynthesisUtterance(text);
  speechSynthesis.speak(speechInstance);
}

function stopSpeech() {
  if (speechSynthesis.speaking) {
    speechSynthesis.cancel();
  }
}

// Update the dark mode button text
function updateDarkModeButton() {
  const darkModeButton = document.querySelector('.accessibility-panel button[onclick*="toggleDarkMode"]');
  if (darkModeButton && window.darkModeManager) {
    const isDarkMode = window.darkModeManager.isEnabled();
    if (isDarkMode) {
      if (document.documentElement.lang === 'ar') {
        darkModeButton.textContent = 'تعطيل الوضع الداكن';
      } else {
        darkModeButton.textContent = 'Disable Dark Mode';
      }
    } else {
      if (document.documentElement.lang === 'ar') {
        darkModeButton.textContent = 'تفعيل الوضع الداكن';
      } else {
        darkModeButton.textContent = 'Enable Dark Mode';
      }
    }
  }
}

// عند تحميل الصفحة
window.addEventListener('DOMContentLoaded', () => {
  // Update button text on page load based on current dark mode state
  updateDarkModeButton();
  
  // Listen for dark mode changes
  window.addEventListener('darkModeChanged', updateDarkModeButton);
});

function changeFontSize(delta) {
  const body = document.body;
  const currentSize = parseFloat(window.getComputedStyle(body).fontSize);
  body.style.fontSize = (currentSize + delta) + 'px';
}

function setLanguage(lang) {
  if (lang === 'ar') {
    document.documentElement.lang = 'ar';
    document.body.dir = 'rtl';
  } else {
    document.documentElement.lang = 'en';
    document.body.dir = 'ltr';
  }
  // Update dark mode button text when language changes
  setTimeout(updateDarkModeButton, 100);
}