fetch('layout.php')
  .then(res => res.text())
  .then(html => {
    const temp = document.createElement('div');
    temp.innerHTML = html;

    const header = temp.querySelector('#header-wrap');
    const footer = temp.querySelector('#footer');
    const footerBottom = temp.querySelector('#footer-bottom');

    if (header) document.getElementById('header-placeholder').appendChild(header);
    if (footer) document.getElementById('footer-placeholder').appendChild(footer);
    if (footerBottom) document.getElementById('footer-placeholder').appendChild(footerBottom);

    const currentPage = window.location.pathname.split("/").pop();
    const menuLinks = document.querySelectorAll(".menu-list a");

    menuLinks.forEach(link => {
      const href = link.getAttribute("href").split("/").pop();
      if (href === currentPage) {
        link.classList.add("active");
      }
    });
  })
  .catch(err => console.error('❌ Fetch error:', err));

  // زر البحث
  document.querySelector('.search-button').addEventListener('click', function(e) {
    e.preventDefault(); // يمنع الانتقال للرابط #

    const queryInput = document.querySelector('#search-input');
    const query = queryInput ? queryInput.value.trim() : '';

    if (query) {
      window.location.href = `pages/projects.php?query=${encodeURIComponent(query)}`;
    } else {
      alert('Please enter a search term.');
    }
  });

  // الضغط على Enter داخل حقل البحث
  document.querySelector('#search-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.querySelector('.search-button').click();
    }
  });
