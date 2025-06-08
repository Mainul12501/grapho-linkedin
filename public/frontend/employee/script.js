// Mobile number with flag
const countryCodeSelector = document.getElementById('countryCode');
const flagImg = document.getElementById('flagIcon');
if (countryCodeSelector && flagImg) {
  countryCodeSelector.addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const flagCode = selectedOption.getAttribute('data-flag');
    flagImg.src = `https://flagcdn.com/w40/${flagCode}.png`;
  });
}

// Show full job description
function showJobDetails(jobId) {
  const jobDetails = {
    1: {
      companyLogo: 'images/contentImages/jobCardLogo.png',
      companyName: 'United Commercial Bank PLC',
      location: 'Gulshan, Dhaka',
      title: 'Senior Officer, Corporate Banking',
      jobType: ['Full Time', 'On-Site', 'Day Shift'],
      applyButtonText: 'Easy Apply',
      saveButtonIcon: 'images/contentImages/saveIcon.png',
      description: 'Be part of the world’s most successful, purpose-led business...',
      requirements: [
        'Analyse internal data...',
        'Work with media teams...',
        'Create communication strategies...'
      ]
    },
    // Add more job entries here if needed
  };

  const job = jobDetails[jobId];
  if (!job) return;

  document.querySelectorAll('.job-card').forEach(card => card.classList.remove('active'));
  const activeCard = document.getElementById('job-' + jobId);
  if (activeCard) activeCard.classList.add('active');

  if (window.innerWidth <= 768) {
    showJobModal(jobId);
  } else {
    const jobDetailsDiv = document.querySelector('.job-details');
    if (!jobDetailsDiv) return;
    jobDetailsDiv.style.display = 'block';
    jobDetailsDiv.innerHTML = `
      <div class="company-info">
        <img src="${job.companyLogo}" alt="${job.companyName} Logo" class="company-logo">
        <div class="company-details">
          <h3>${job.companyName}</h3>
          <p>${job.location}</p>
        </div>
      </div>
      <h4 class="job-title">${job.title}</h4>
      <div class="job-type">${job.jobType.map(type => `<span class="badge">${type}</span>`).join(' ')}</div>
      <button class="apply-btn">${job.applyButtonText}</button>
      <button class="save-btn"><img src="${job.saveButtonIcon}" alt="Save Icon" class="save-icon"> Save</button>
      <h5>About ${job.companyName}</h5>
      <p>${job.description}</p>
      <h5>Job Requirements</h5>
      <ul class="job-requirements">${job.requirements.map(req => `<li>${req}</li>`).join('')}</ul>
    `;
    jobDetailsDiv.querySelector('.apply-btn').addEventListener('click', showEasyApplyModal);
  }
}

function showJobModal(jobId) {
  const job = {
    companyLogo: 'images/contentImages/jobDetailsLogoforJs.png',
    companyName: 'United Commercial Bank PLC',
    location: 'Gulshan, Dhaka',
    title: 'Senior Officer, Corporate Banking',
    jobType: ['Full Time', 'On-Site', 'Day Shift'],
    applyButtonText: 'Easy Apply',
    saveButtonIcon: 'images/contentImages/saveIcon.png',
    description: 'Be part of the world’s most successful, purpose-led business...',
    requirements: [
      'Analyse internal data...',
      'Work with media teams...',
      'Create communication strategies...'
    ]
  };

  const modalDiv = document.createElement('div');
  modalDiv.classList.add('job-modal');
  modalDiv.innerHTML = `
    <div class="modal-content">
      <div class="modal-header">
        <img src="${job.companyLogo}" alt="${job.companyName} Logo" class="company-logo">
        <div class="modal-title">
          <h3>${job.companyName}</h3>
          <p>${job.location}</p>
        </div>
        <button class="close-btn" onclick="closeModal()">X</button>
      </div>
      <div class="modal-body">
        <h4 class="job-title">${job.title}</h4>
        <div class="job-type">${job.jobType.map(type => `<span class="badge">${type}</span>`).join(' ')}</div>
        <button class="apply-btn">${job.applyButtonText}</button>
        <button class="save-btn"><img src="${job.saveButtonIcon}" alt="Save Icon" class="save-icon"> Save</button>
        <h5>About ${job.companyName}</h5>
        <p>${job.description}</p>
        <h5>Job Requirements</h5>
        <ul class="job-requirements">${job.requirements.map(req => `<li>${req}</li>`).join('')}</ul>
      </div>
    </div>
  `;
  document.body.appendChild(modalDiv);
  modalDiv.querySelector('.apply-btn').addEventListener('click', showEasyApplyModal);
}

function closeModal() {
  const modal = document.querySelector('.job-modal');
  if (modal) modal.remove();
}

function showEasyApplyModal() {
  const modal = document.getElementById('easyApplyModal');
  if (modal) modal.style.display = 'flex';
}

function closeEasyApplyModal() {
  const modal = document.getElementById('easyApplyModal');
  if (modal) modal.style.display = 'none';
}

function shareProfile() {
  closeEasyApplyModal();
  const notification = document.getElementById('notification');
  if (notification) {
    notification.style.display = 'block';
    setTimeout(() => notification.style.display = 'none', 5000);
  }
}

function toggleDropdown() {
  const dropdown = document.getElementById("userDropdown");
  if (dropdown) {
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  }
}

window.addEventListener('click', function (event) {
  if (!event.target.closest('.userProfile')) {
    const dropdown = document.getElementById("userDropdown");
    if (dropdown) dropdown.style.display = "none";
  }
});

document.addEventListener('click', function (e) {
  if (!e.target.closest('.appliedJobs .action')) {
    document.querySelectorAll('.appliedJobs .action-dropdown').forEach(menu => menu.style.display = 'none');
  }
});

function toggleActionMenu(trigger) {
  document.querySelectorAll('.appliedJobs .action-dropdown').forEach(menu => {
    if (menu !== trigger.nextElementSibling) menu.style.display = 'none';
  });
  const dropdown = trigger.nextElementSibling;
  if (dropdown) {
    dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
  }
}

// Before and after login toggle
window.addEventListener('DOMContentLoaded', function () {
  const continueBtn = document.querySelector('.beforeContinue button');
  const beforeDiv = document.querySelector('.beforeContinue');
  const afterDiv = document.querySelector('.afterContinue');

  if (continueBtn && beforeDiv && afterDiv) {
    afterDiv.style.display = 'none';

    continueBtn.addEventListener('click', function (e) {
      e.preventDefault();
      beforeDiv.style.display = 'none';
      afterDiv.style.display = 'block';
    });
  }
});

// Initialize job section
// showJobDetails(1);


  function updateRole(role) {
    document.getElementById("selectedRole").innerText = role;
  }
