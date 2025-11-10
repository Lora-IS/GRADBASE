document.addEventListener("DOMContentLoaded", function () {
  // إغلاق نافذة اللغة إذا سبق اختيارها
 const savedLang = localStorage.getItem("selectedLang");
if (savedLang === "ar" || savedLang === "en") {
  const modal = document.getElementById("languageModal");
  if (modal) {
    modal.classList.remove("d-block");
    modal.classList.add("d-none");
  }

  const langInput = document.getElementById("lang-input");
  if (langInput) {
    langInput.value = savedLang;
  }

  //document.body.dir = "ltr";

}
  // توليد الأفكار
  function generate() {
    const category = document.getElementById("category").value;
    const lang = document.getElementById("lang-input").value;

    if (!category || !lang) {
      alert("Please select the domain and language first.");
      return;
    }

    const btn = document.getElementById("generate-btn");
    btn.classList.add("loading");
    btn.innerText = "Generating...";

    fetch("http://127.0.0.1:5000/generate", {
      method: "POST",
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ category: category, language: lang })
    })
    .then(response => response.json())
    .then(data => {
      btn.classList.remove("loading");
      btn.innerText = "Generate Ideas";

      const resultBox = document.getElementById("result");
      if (data.ideas) {
        resultBox.innerText = data.ideas;
        resultBox.classList.add("visible");
      } else {
        resultBox.innerText = "An error occurred while generating ideas.";
      }
    });
  }

  // المحادثة مع المساعد
  function chat() {
    const input = document.getElementById("userMessage");
    const chatBox = document.getElementById("chatBox");
    const message = input.value.trim();

    if (!message) return;

    input.value = "";

    const userMsg = document.createElement("div");
    userMsg.className = "user-message";
    userMsg.innerText = message;
    chatBox.appendChild(userMsg);

    const botLoading = document.createElement("div");
    botLoading.className = "bot-message loading";
    botLoading.innerText = "Replying now...";
    chatBox.appendChild(botLoading);

    fetch("http://127.0.0.1:5000/chat", {
      method: "POST",
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
      chatBox.removeChild(botLoading);

      const botReply = document.createElement("div");
      botReply.className = "bot-message";
      botReply.innerText = data.reply || "حدث خطأ أثناء المحادثة.";
      chatBox.appendChild(botReply);

      chatBox.scrollTop = chatBox.scrollHeight;
    });
  }

  // عرض الأقسام
  function showSection(id) {
    document.querySelectorAll('section').forEach(sec => sec.style.display = 'none');
    const target = document.getElementById(id);
    if (target) {
      target.style.display = 'block';
      target.scrollIntoView({ behavior: 'smooth' });
    }
  }

  // ربط الروابط بالأقسام
  const suggestLink = document.querySelector('a[href="#suggest-section"]');
  const developLink = document.querySelector('a[href="#develop-section"]');

  if (suggestLink) {
    suggestLink.addEventListener('click', function(e) {
      e.preventDefault();
      showSection('suggest-section');
    });
  }

  if (developLink) {
    developLink.addEventListener('click', function(e) {
      e.preventDefault();
      showSection('develop-section');
    });
  }

  // ربط الدوال بالنوافذ العامة
  window.generate = generate;
  window.chat = chat;
  window.showSection = showSection;

  fetch("http://127.0.0.1:5000/categories")
  .then(response => response.json())
  .then(categories => {
    const select = document.getElementById("category");
    categories.forEach(cat => {
      const option = document.createElement("option");
      option.value = cat;
      option.textContent = cat;
      select.appendChild(option);
    });
  });
  
});

// قائمة اللغة
function toggleLangMenu() {
  const menu = document.getElementById("lang-menu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function selectLang(lang) {
  const langInput = document.getElementById("lang-input");
  if (langInput) {
    langInput.value = lang;
  }

  localStorage.setItem("selectedLang", lang);

  const modal = document.getElementById("languageModal");
  if (modal) {
    modal.classList.remove("d-block");
    modal.classList.add("d-none");
  }
}

