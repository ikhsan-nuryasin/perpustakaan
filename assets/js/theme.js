// Theme toggle functionality
function toggleTheme() {
  const body = document.body;
  const currentTheme = body.getAttribute('data-theme');
  const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
  body.setAttribute('data-theme', newTheme);
  
  // Update icon
  const toggleBtn = document.querySelector('.theme-toggle i');
  toggleBtn.classList.toggle('fa-moon');
  toggleBtn.classList.toggle('fa-sun');
  
  // Save to localStorage
  localStorage.setItem('theme', newTheme);
}

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', () => {
  const savedTheme = localStorage.getItem('theme') || 'light';
  document.body.setAttribute('data-theme', savedTheme);
  const toggleBtn = document.querySelector('.theme-toggle i');
  if (savedTheme === 'dark') {
    toggleBtn.classList.remove('fa-moon');
    toggleBtn.classList.add('fa-sun');
  }
});

// Mobile sidebar toggle
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
}
