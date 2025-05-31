// mobile number with flag
document.getElementById('countryCode').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const flagCode = selectedOption.getAttribute('data-flag');
    const flagImg = document.getElementById('flagIcon');
    flagImg.src = `https://flagcdn.com/w40/${flagCode}.png`;
});







// show full job desc
// Initially show the first job details
showJobDetails(1);

function showJobDetails(jobId) {
  // Remove active class from all job cards
  document.querySelectorAll('.job-card').forEach(card => card.classList.remove('active'));

  // Add active class to the clicked job card
  document.getElementById('job-' + jobId).classList.add('active');

  // Hide all job details and display the selected job's details
  if (window.innerWidth <= 768) {  // Check if on mobile or tablet
    showJobModal(jobId);  // Show the job details in modal for mobile/tablet
  } else {
    document.getElementById('job-details').style.display = 'block';  // For desktop
  }

  // Job details for each jobId
  const jobDetails = {
    1: {
      companyLogo: base_url+'images/contentImages/jobCardLogo.png',
      companyName: 'United Commercial Bank PLC',
      location: 'Gulshan, Dhaka',
      title: 'Senior Officer, Corporate Banking',
      jobType: ['Full Time', 'On-Site', 'Day Shift'],
      applyButtonText: 'Easy Apply',
      saveButtonIcon: base_url+'images/contentImages/saveIcon.png',
      description: 'Be part of the world’s most successful, purpose-led business...',
      requirements: [
        'Analyse internal data...',
        'Work with media teams...',
        'Create communication strategies...'
      ]
    },
    2: {
      companyLogo: base_url+'images/contentImages/jobCardLogo.png',
      companyName: 'United Commercial Bank PLC',
      location: 'Gulshan, Dhaka',
      title: 'Senior Officer, Corporate Banking',
      jobType: ['Full Time', 'On-Site', 'Day Shift'],
      applyButtonText: 'Easy Apply',
      saveButtonIcon: base_url+'images/contentImages/saveIcon.png',
      description: 'Be part of the world’s most successful, purpose-led business...',
      requirements: [
        'Analyse internal data...',
        'Work with media teams...',
        'Create communication strategies...'
      ]
    },
    3: {
      companyLogo: base_url+'images/contentImages/jobCardLogo.png',
      companyName: 'United Commercial Bank PLC',
      location: 'Gulshan, Dhaka',
      title: 'Senior Officer, Corporate Banking',
      jobType: ['Full Time', 'On-Site', 'Day Shift'],
      applyButtonText: 'Easy Apply',
      saveButtonIcon: base_url+'images/contentImages/saveIcon.png',
      description: 'Be part of the world’s most successful, purpose-led business...',
      requirements: [
        'Analyse internal data...',
        'Work with media teams...',
        'Create communication strategies...'
      ]
    },
    4: {
      companyLogo: base_url+'images/contentImages/jobCardLogo.png',
      companyName: 'United Commercial Bank PLC',
      location: 'Gulshan, Dhaka',
      title: 'Senior Officer, Corporate Banking',
      jobType: ['Full Time', 'On-Site', 'Day Shift'],
      applyButtonText: 'Easy Apply',
      saveButtonIcon: base_url+'images/contentImages/saveIcon.png',
      description: 'Be part of the world’s most successful, purpose-led business...',
      requirements: [
        'Analyse internal data...',
        'Work with media teams...',
        'Create communication strategies...'
      ]
    },
    // Add other job details here...
  };

  const job = jobDetails[jobId];

  // Update job details section with the new information
  const jobDetailsDiv = document.querySelector('.job-details');

  // Clear the previous content
  jobDetailsDiv.innerHTML = '';

  // Add company logo, job title, description, and requirements
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

  // Attach event listener to apply button
  document.querySelector('.apply-btn').addEventListener('click', showEasyApplyModal);
}





// Show job details in a modal for mobile/tablet
function showJobModal(jobId) {
  const jobDetails = {
    1: {
      companyLogo: base_url+'images/contentImages/jobDetailsLogoforJs.png',
      companyName: 'United Commercial Bank PLC',
      location: 'Gulshan, Dhaka',
      title: 'Senior Officer, Corporate Banking',
      jobType: ['Full Time', 'On-Site', 'Day Shift'],
      applyButtonText: 'Easy Apply',
      saveButtonIcon: base_url+'images/contentImages/saveIcon.png',
      description: 'Be part of the world’s most successful, purpose-led business...',
      requirements: [
        'Analyse internal data...',
        'Work with media teams...',
        'Create communication strategies...'
      ]
    },
    // Add other jobs here...
  };

  const job = jobDetails[jobId];

  const modalContent = `
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


  // Insert the modal content
  const modalDiv = document.createElement('div');
 modalDiv.classList.add('job-modal');

  modalDiv.innerHTML = modalContent;
  document.body.appendChild(modalDiv);

  // Attach event listener to apply button in modal
  modalDiv.querySelector('.apply-btn').addEventListener('click', showEasyApplyModal);
}

// Close modal
function closeModal() {
const modal = document.querySelector('.job-modal');

  if (modal) {
    modal.remove();
  }
}

// Easy apply modal
function showEasyApplyModal() {
  document.getElementById('easyApplyModal').style.display = 'flex';
}

// Close the Easy Apply Modal when "Cancel" is clicked
function closeEasyApplyModal() {
  document.getElementById('easyApplyModal').style.display = 'none';
}

// Show success notification when profile is shared
function shareProfile() {
  // Close the Easy Apply Modal
  closeEasyApplyModal();

  // Show the success notification
  const notification = document.getElementById('notification');
  notification.style.display = 'block';

  // Hide the notification after 5 seconds
  setTimeout(closeNotification, 5000);
}

// Close the success notification
function closeNotification() {
  const notification = document.getElementById('notification');
  notification.style.display = 'none';
}

// Attach the "Easy Apply" modal functionality to the "Easy Apply" button
document.querySelectorAll('.apply-btn').forEach(button => {
  button.addEventListener('click', showEasyApplyModal);
});









// profile toggle dropdown option
function toggleDropdown() {
  var dropdown = document.getElementById("userDropdown");
  dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
}

// Close the dropdown if the user clicks anywhere outside of it
window.onclick = function(event) {
  if (!event.target.matches('.userProfile, .userProfile *')) {
    var dropdown = document.getElementById("userDropdown");
    if (dropdown) {
      dropdown.style.display = "none";
    }
  }
}





// applied jobs threedot options

  function toggleActionMenu(trigger) {
    // Close other open menus
    document.querySelectorAll('.appliedJobs .action-dropdown').forEach(menu => {
      if (menu !== trigger.nextElementSibling) {
        menu.style.display = 'none';
      }
    });

    const dropdown = trigger.nextElementSibling;
    dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
  }

  // Close dropdown if clicked outside (but does not override window.onclick)
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.appliedJobs .action')) {
      document.querySelectorAll('.appliedJobs .action-dropdown').forEach(menu => {
        menu.style.display = 'none';
      });
    }
  });


