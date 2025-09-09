// toaster js

document.addEventListener('DOMContentLoaded', () => {
  const postJobBtn = document.getElementById('modalPostJobBtn');
  const snackbar = document.getElementById('snackbar');

  if (postJobBtn && snackbar) {
    postJobBtn.addEventListener('click', () => {
      snackbar.classList.add('show');

      // Hide after 4 seconds
      setTimeout(() => {
        snackbar.classList.remove('show');
      }, 4000);
    });
  }

  const closeBtn = document.getElementById('snackbar-close');
  if (closeBtn && snackbar) {
    closeBtn.addEventListener('click', () => {
      snackbar.classList.remove('show');
    });
  }
});
