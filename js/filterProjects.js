const tabs = document.querySelectorAll('.tab');
const projects = document.querySelectorAll('.project');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    const category = tab.getAttribute('data-category');

    projects.forEach(project => {
      if (category === 'all' || project.dataset.category === category) {
        project.style.display = 'block';
      } else {
        project.style.display = 'none';
      }
    });
  });
});


 function goToDetails(projectKey) {
  window.location.href = `project-details.php?project=${projectKey}`;
}



