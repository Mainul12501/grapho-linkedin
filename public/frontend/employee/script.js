/* =================================================
   GRAPHO SCRIPT (safe, commented, part-by-part friendly)
   - Keep everything in clear blocks
   - New backend helpers marked with // [BACKEND]
================================================= */

/** ------------------------------------------------
 * DATA: Central job data source (single source of truth)
 * ------------------------------------------------ */
const JOBS = {
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
  2: {
    companyLogo: 'images/contentImages/jobCardLogo.png',
    companyName: 'Dutch-Bangla Bank',
    location: 'Banani, Dhaka',
    title: 'Relationship Manager',
    jobType: ['Full Time', 'Hybrid', 'Day Shift'],
    applyButtonText: 'Easy Apply',
    saveButtonIcon: 'images/contentImages/saveIcon.png',
    description: 'Build and maintain client relationships to grow portfolio.',
    requirements: [
      '3+ years in corporate sales/banking',
      'Strong communication & negotiation',
      'Experience with CRM tools'
    ]
  },
  3: {
    companyLogo: 'images/contentImages/jobCardLogo.png',
    companyName: 'BRAC Bank',
    location: 'Motijheel, Dhaka',
    title: 'Assistant Manager, SME',
    jobType: ['Contract', 'On-Site', 'Day Shift'],
    applyButtonText: 'Easy Apply',
    saveButtonIcon: 'images/contentImages/saveIcon.png',
    description: 'Support SME acquisition and portfolio health.',
    requirements: [
      'BBA/MBA preferred',
      'SME credit knowledge',
      'Excel/PowerPoint proficiency'
    ]
  },
  4: {
    companyLogo: 'images/contentImages/jobCardLogo.png',
    companyName: 'City Bank',
    location: 'Uttara, Dhaka',
    title: 'Credit Analyst',
    jobType: ['Full Time', 'On-Site', 'Day Shift'],
    applyButtonText: 'Easy Apply',
    saveButtonIcon: 'images/contentImages/saveIcon.png',
    description: 'Analyze creditworthiness and prepare reports.',
    requirements: [
      '2+ years in credit analysis',
      'Strong analytical mindset',
      'Knowledge of Basel guidelines'
    ]
  }
};

/** Safely fetch a job by ID */
function getJob(jobId) {
  return JOBS[jobId] ?? null;
}

/* =================================================
   BUILD: Job details (used by Desktop panel & Mobile modal)
   - Easy Apply is a REAL <form> submit
   - "Share profile" is a separate button (opens share modal)
================================================= */
function renderJobDetails(job) {
  return `
    <div class="company-info">
      <img src="${job.companyLogo}" alt="${job.companyName} Logo" class="company-logo">
      <div class="company-details">
        <h3>${job.companyName}</h3>
        <p>${job.location}</p>
      </div>
    </div>

    <h4 class="job-title">${job.title}</h4>

    <div class="job-type">
      ${job.jobType.map(type => `<span class="badge">${type}</span>`).join(' ')}
    </div>

    <!-- Easy Apply = REAL FORM -->
    <form class="apply-form" action="/api/jobs/apply" method="POST">
      <input type="hidden" name="jobId" value="">
      <input type="hidden" name="jobTitle" value="${job.title}">
      <div class="actions d-flex gap-2 mt-2">
        <button type="submit" class="apply-btn">${job.applyButtonText}</button>
        <button type="button" class="share-btn">Share profile</button>
        <button type="button" class="save-btn">
          <img src="${job.saveButtonIcon}" alt="Save Icon" class="save-icon"> Save
        </button>
      </div>
    </form>

    <h5>About ${job.companyName}</h5>
    <p>${job.description}</p>

    <h5>Job Requirements</h5>
    <ul class="job-requirements">
      ${job.requirements.map(req => `<li>${req}</li>`).join('')}
    </ul>
  `;
}

/* =================================================
   COUNTRY CODE SELECTOR WITH FLAG ICON (UI only)
================================================= */
const countryCodeSelector = document.getElementById('countryCode');
const flagImg = document.getElementById('flagIcon');

if (countryCodeSelector && flagImg) {
  countryCodeSelector.addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const flagCode = selectedOption?.getAttribute('data-flag'); // e.g., 'bd'
    if (flagCode) {
      flagImg.src = `https://flagcdn.com/w40/${flagCode}.png`;
      flagImg.alt = `Flag ${flagCode.toUpperCase()}`;
    }
  });
}

/* =================================================
   JOB DETAILS SECTION (Desktop + Mobile)
   - Desktop: inject into #job-details
   - Mobile : open custom modal
================================================= */
function setLetSideActiveJob(jobId){
    // Active highlight on list
    document.querySelectorAll('.job-card').forEach(card => card.classList.remove('active'));
    const activeCard = document.getElementById('job-' + jobId);
    if (activeCard) activeCard.classList.add('active');
}
function showJobDetails(jobId) {
  const job = getJob(jobId);
  if (!job) return;

  // Active highlight on list
  document.querySelectorAll('.job-card').forEach(card => card.classList.remove('active'));
  const activeCard = document.getElementById('job-' + jobId);
  if (activeCard) activeCard.classList.add('active');

  // Mobile → modal, Desktop → inline panel
  if (window.innerWidth <= 768) {
    showJobModal(jobId);
    return;
  }

  const jobDetailsDiv = document.querySelector('.job-details');
  if (!jobDetailsDiv) return;

  jobDetailsDiv.style.display = 'block';
  jobDetailsDiv.innerHTML = renderJobDetails(job);

  // Wire form submit (Easy Apply)
  const form = jobDetailsDiv.querySelector('.apply-form');
  if (form) {
    const hid = form.querySelector('input[name="jobId"]');
    if (hid) hid.value = String(jobId);
    form.addEventListener('submit', handleApplySubmit);
  }

  // Share opens the existing share modal
  const shareBtn = jobDetailsDiv.querySelector('.share-btn');
  if (shareBtn) shareBtn.addEventListener('click', showEasyApplyModal);
}

/* =================================================
   JOB MODAL (Mobile view)
================================================= */
function showJobModal(jobId) {
  const job = getJob(jobId);
  if (!job) return;

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
        <button class="close-btn" aria-label="Close" onclick="closeModal()">X</button>
      </div>
      <div class="modal-body">
        ${renderJobDetails(job)}
      </div>
    </div>
  `;
  document.body.appendChild(modalDiv);

  // Wire form submit (Easy Apply)
  const form = modalDiv.querySelector('.apply-form');
  if (form) {
    const hid = form.querySelector('input[name="jobId"]');
    if (hid) hid.value = String(jobId);
    form.addEventListener('submit', handleApplySubmit);
  }

  // Share opens the existing share modal
  const shareBtn = modalDiv.querySelector('.share-btn');
  if (shareBtn) shareBtn.addEventListener('click', showEasyApplyModal);
}

/** Close job modal (mobile) */
function closeModal() {
  const modal = document.querySelector('.job-modal');
  if (modal) modal.remove();
}

/* =================================================
   EASY APPLY (Share Profile) MODAL
   - This is your existing "Share your profile?" modal
================================================= */
function showEasyApplyModal() {
  const modal = document.getElementById('easyApplyModal');
  if (modal) modal.style.display = 'flex';
}
function closeEasyApplyModal() {
  const modal = document.getElementById('easyApplyModal');
  if (modal) modal.style.display = 'none';
}
/** After sharing → small toast */
function shareProfile() {
  closeEasyApplyModal();
  setNotification('Your profile has been shared with the company.');
}

/* =================================================
   APPLY HELPERS (form submit + toast)
================================================= */
function handleApplySubmit(e) {
  e.preventDefault();
  const form = e.currentTarget;
  const data = Object.fromEntries(new FormData(form).entries());
  const jobTitle = data.jobTitle || 'this job';

  // Keep backend call commented until ready:
  // fetch(form.action, {
  //   method: 'POST',
  //   headers: { 'Content-Type': 'application/json' },
  //   body: JSON.stringify(data)
  // }).then(() => showApplyToast(jobTitle))
  //   .catch(() => showApplyToast(jobTitle));

  // Frontend feedback for now
  showApplyToast(jobTitle);
}
function showApplyToast(title) {
  setNotification(`You applied for the job: ${title}`);
}
function setNotification(message) {
  const n = document.getElementById('notification');
  if (!n) return;
  const c = n.querySelector('.notification-content');
  if (c) {
    c.innerHTML = `
      <span class="checkmark"><img src="images/contentImages/easyApplyNotificationIcon.png" alt="" /></span>
      ${message}
      <span class="close-btn" onclick="closeNotification()">
        <img src="images/contentImages/easyApplynotificationCloseIcon.png" alt="" />
      </span>
    `;
  }
  n.style.display = 'block';
  setTimeout(() => (n.style.display = 'none'), 5000);
}
function closeNotification() {
  const n = document.getElementById('notification');
  if (n) n.style.display = 'none';
}

/* =================================================
   USER DROPDOWN MENU
================================================= */
function toggleDropdown() {
  const dropdown = document.getElementById('userDropdown');
  if (dropdown) {
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
  }
}
// Close dropdown when clicking outside
window.addEventListener('click', function (event) {
  if (!event.target.closest('.userProfile')) {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown) dropdown.style.display = 'none';
  }
});

/* =================================================
   ACTION MENU (Applied Jobs Section)
================================================= */
document.addEventListener('click', function (e) {
  if (!e.target.closest('.appliedJobs .action')) {
    document.querySelectorAll('.appliedJobs .action-dropdown').forEach(menu => (menu.style.display = 'none'));
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

/* =================================================
   BACKEND HELPERS (NEW) — build full phone number
   NOTE: Pure logic for API payload; no UI changes.
   Marked with // [BACKEND] for easy search.
================================================= */
/** [BACKEND] Sanitize local number: keep digits only */
function sanitizeLocalNumber(num) {
  return (num || '').replace(/\D/g, '');
}
/** [BACKEND] Build full phone (E.164-like): +<country><local> */
function buildFullPhone() {
  const rawCC = countryCodeSelector?.value || '';               // e.g., "+880"
  const rawLocal = document.getElementById('phoneInput')?.value || '';
  const ccDigits = rawCC.replace(/\D/g, '');                    // "+880" -> "880"
  const localDigits = sanitizeLocalNumber(rawLocal);            // "1653523779"
  if (!ccDigits || !localDigits) return null;                   // guard if missing
  return `+${ccDigits}${localDigits}`;                          // "+8801653523779"
}
/** [BACKEND] Create payload for sending OTP/login */
function createSendOtpPayload() {
  const phone = buildFullPhone();
  return { phone }; // e.g., { phone: "+8801653523779" }
}

/* =================================================
   BEFORE & AFTER LOGIN TOGGLE
   (Existing behavior + hooks to backend payload)
================================================= */
window.addEventListener('DOMContentLoaded', function () {
  const continueBtn = document.querySelector('.beforeContinue button');
  const beforeDiv = document.querySelector('.beforeContinue');
  const afterDiv = document.querySelector('.afterContinue');

  if (continueBtn && beforeDiv && afterDiv) {
    // Step-2 hidden initially
    afterDiv.style.display = 'none';

    continueBtn.addEventListener('click', function (e) {
      e.preventDefault();

      // ---- [BACKEND] Build payload here (no UI change) ----
      const payload = createSendOtpPayload();
      // fetch('/api/auth/send-otp', { ... JSON.stringify(payload) });

      // UI flow (unchanged)
      beforeDiv.style.display = 'none';
      afterDiv.style.display = 'block';

      // Optional message update:
      // const otpInfo = document.querySelector('.afterContinue p.mb-0');
      // if (otpInfo && payload?.phone) otpInfo.textContent = `OTP has been sent to ${payload.phone}`;
    });
  }
});

/* =================================================
   ROLE SELECTION UPDATE
================================================= */
function updateRole(role) {
  const el = document.getElementById('selectedRole');
  if (el) el.innerText = role;
}

/* =================================================
   INITIALIZE JOB SECTION (safe even if panel absent)
================================================= */
// try { showJobDetails(1); } catch {  }

/* =================================================
   SIGNUP: CREATE ACCOUNT CLICK → BACKEND PAYLOAD
   (Uses the same [BACKEND] helpers; no UI change)
================================================= */
window.addEventListener('DOMContentLoaded', function () {
  // Run ONLY on the Signup page (must have signup-specific fields)
  const isSignUpPage = document.getElementById('signUpMail') || document.getElementById('supPassword');
  if (!isSignUpPage) return;

  const signUpCard = document.querySelector('.signUpCard');
  if (!signUpCard) return;

  const createBtn = signUpCard.querySelector('button[type="button"]');
  if (!createBtn) return;

  if (!document.getElementById('countryCode') || !document.getElementById('phoneInput')) return;

  createBtn.addEventListener('click', function () {
    const payload = createSendOtpPayload(); // -> { phone: "+880..." }
    // fetch('/api/auth/signup', { ... JSON.stringify({ phone: payload.phone }) });
    console.log('[Signup] Prepared phone:', payload.phone);
  });
});

/* =================================================
   OTP INPUT UX — auto-advance, backspace, paste
   + hidden sink (#otpFull) for backend
================================================= */
window.addEventListener('DOMContentLoaded', function () {
  const container = document.querySelector('.otp-container');
  if (!container) return;

  const inputs = Array.from(container.querySelectorAll('.otp-input'));
  if (!inputs.length) return;

  // Create (or reuse) a hidden input to hold the full OTP
  function ensureOtpSink() {
    let sink = document.getElementById('otpFull');
    if (!sink) {
      sink = document.createElement('input');
      sink.type = 'hidden';
      sink.id = 'otpFull';
      (document.querySelector('.signUpCard') || document.body).appendChild(sink);
    }
    return sink;
  }
  const otpSink = ensureOtpSink();

  // Update hidden sink + emit a custom event
  function updateOtpSink() {
    const otp = inputs.map(inp => inp.value.replace(/\D/g, '')).join('');
    otpSink.value = otp;                            // <-- backend can read this
    container.dataset.otp = otp;                   // optional: read via data attr
    container.dispatchEvent(new CustomEvent('otp:change', { detail: { otp } }));
  }

  inputs.forEach((input, idx) => {
    input.setAttribute('inputmode', 'numeric');
    input.setAttribute('autocomplete', 'one-time-code');
    input.setAttribute('pattern', '[0-9]*');

    input.addEventListener('focus', () => input.select());

    input.addEventListener('input', () => {
      let val = input.value.replace(/\D/g, '');
      if (val.length > 1) val = val.charAt(0);
      input.value = val;

      // move to next on digit
      if (val && idx < inputs.length - 1) {
        inputs[idx + 1].focus();
        inputs[idx + 1].select();
      }
      updateOtpSink();
    });

    input.addEventListener('keydown', (e) => {
      const k = e.key;

      if (k.length === 1 && !/[0-9]/.test(k)) e.preventDefault();

      if (k === 'Backspace') {
        if (input.value) {
          input.value = '';
          e.preventDefault();
          updateOtpSink();
        } else {
          const prev = inputs[idx - 1];
          if (prev) {
            prev.focus();
            prev.value = '';
            e.preventDefault();
            updateOtpSink();
          }
        }
      }

      if (k === 'ArrowLeft') {
        const prev = inputs[idx - 1];
        if (prev) { prev.focus(); prev.select(); e.preventDefault(); }
      }
      if (k === 'ArrowRight') {
        const next = inputs[idx + 1];
        if (next) { next.focus(); next.select(); e.preventDefault(); }
      }

      if (k === 'Enter') {
        const scope = input.closest('.signUpCard') || document;
        const btn = scope.querySelector('button[type="button"]');
        if (btn) btn.click();
      }
    });

    input.addEventListener('paste', (e) => {
      const text = (e.clipboardData || window.clipboardData)?.getData('text') || '';
      const digits = text.replace(/\D/g, '');
      if (!digits) return;

      e.preventDefault();
      inputs.forEach(inp => inp.value = '');
      for (let i = 0; i < inputs.length && i < digits.length; i++) {
        inputs[i].value = digits[i];
      }
      updateOtpSink();

      const filled = Math.min(digits.length, inputs.length) - 1;
      const target = inputs[Math.max(0, filled)];
      target.focus();
      target.select();
    });
  });

  // initialize sink on load (in case some inputs are prefilled)
  updateOtpSink();
});

/* =================================================
   PASSWORD TOGGLE (show/hide) — generic
   Works on any page with .input-wrapper + .toggle-icon
================================================= */
window.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.input-wrapper').forEach(wrapper => {
    const input  = wrapper.querySelector('input[type="password"], input[type="text"]');
    const toggle = wrapper.querySelector('.toggle-icon');
    if (!input || !toggle) return;

    // Make the icon accessible/interactive
    toggle.setAttribute('role', 'button');
    toggle.setAttribute('tabindex', '0');
    toggle.setAttribute('aria-label', 'Show password');

    function setType(show) {
      input.type = show ? 'text' : 'password';
      toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
      toggle.classList.toggle('showing', show); // optional class for styling
    }

    // Click / keyboard to toggle
    toggle.addEventListener('click', () => setType(input.type === 'password'));
    toggle.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        setType(input.type === 'password');
      }
    });
  });
});

/* =================================================
   PROFILE SETUP WIZARD (Contact → Work → Education → Document)
   - Adds a guided flow on top of your existing modals
   - Save = write data to page + turn the button into “Next”
   - Next = closes current modal, opens the next step
   - Runs only on pages that contain .profileMain
================================================= */
document.addEventListener('DOMContentLoaded', () => {
  const isProfilePage = document.querySelector('.profileMain');
  if (!isProfilePage) return;

  // ---------- Small helpers ----------
  const T = s => (s || '').trim();
  const modalAPI = el => bootstrap.Modal.getOrCreateInstance(el);

  // Find a field inside a modal by its visible label text
  function fieldByLabel(modal, labelText) {
    const group = [...modal.querySelectorAll('.mb-3')]
      .find(g => T(g.querySelector('.form-label')?.textContent) === labelText);
    return group ? group.querySelector('input, textarea, select') : null;
  }

  // Left panel targets (where we mirror Contact info)
  const profileRoot = document.querySelector('.left-panel .profile');
  const setText = (sel, val) => { const el = profileRoot?.querySelector(sel); if (el && val) el.textContent = val; };
  const setLink = (sel, href, text) => { const el = profileRoot?.querySelector(sel); if (el && text) { el.textContent = text; el.setAttribute('href', href); }};

  // Resolve the right-panel container by its <h3> label
  function sectionByTitle(title) {
    const h = [...document.querySelectorAll('.right-panel .profileOverview h3')]
      .find(h3 => T(h3.textContent) === title);
    return h ? h.closest('.right-panel') : null;
  }
  const containers = {
    experience: sectionByTitle('Work experiences'),
    education:  sectionByTitle('Education'),
    documents:  sectionByTitle('Documents')
  };

  // ---------- Renderers for cards we append ----------
  function renderExperienceCard(d) {
    const row = document.createElement('div');
    row.className = 'row jobCard border-bottom';
    row.innerHTML = `
      <div class="col-2 col-md-1">
        <img src="images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
        <img style="width:40px;height:42px" src="images/contentImages/companyLogoFor job.png" alt="Company Logo" class="mobileLogo" />
      </div>
      <div class="col-10 col-md-11">
        <div class="jobPosition d-flex justify-content-between">
          <div class="d-flex">
            <div class="profileCard">
              <h3>${d.title || 'Title'}</h3>
              <h4>${d.company || 'Company'} <img src="images/profile/dotDevider.png" alt="" /> <span>${d.type || '—'}</span></h4>
              <p class="mb-0">${d.start || ''}${d.end ? ' - ' + d.end : (d.current ? ' - Present' : '')}
                <img src="images/profile/2ndDotDevider.png" alt="" /> <span>${d.location || ''}</span>
              </p>
              ${d.summary ? `<div class="profileSummery mt-4"><h4>Job Summary:</h4><p class="mb-0">${d.summary.replace(/\n/g,'<br>')}</p></div>` : ''}
            </div>
          </div>
          <div>
            <div class="dropdown">
              <img src="images/contentImages/threedot.png" alt="Options" class="threeDot" role="button" data-bs-toggle="dropdown" aria-expanded="false" />
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Edit</a></li>
                <li><a class="dropdown-item" href="#">Delete</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>`;
    containers.experience?.appendChild(row);
  }

  function renderEducationCard(d) {
    const row = document.createElement('div');
    row.className = 'row jobCard border-bottom';
    row.innerHTML = `
      <div class="col-2 col-md-1">
        <img src="images/profile/norSouthUnivercity.png" alt="University" class="companyLogo" />
        <img style="width:40px;height:42px" src="images/profile/norSouthUnivercity.png" alt="University" class="mobileLogo" />
      </div>
      <div class="col-10 col-md-11">
        <div class="jobPosition d-flex justify-content-between">
          <div class="d-flex">
            <div class="profileCard">
              <h3>${d.university || 'University'}</h3>
              <h4>${d.degree || ''}${d.field ? ' - ' + d.field : ''} <img src="images/profile/dotDevider.png" alt="" /> <span>${d.cgpa || ''}</span></h4>
              <p class="mb-0">${d.start || ''}${d.end ? ' - ' + d.end : ''}</p>
              <p>${d.location || ''}</p>
            </div>
          </div>
          <div>
            <div class="dropdown">
              <img src="images/contentImages/threedot.png" alt="Options" class="threeDot" role="button" data-bs-toggle="dropdown" aria-expanded="false" />
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Edit</a></li>
                <li><a class="dropdown-item" href="#">Delete</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>`;
    containers.education?.appendChild(row);
  }

  function renderDocumentCard(d) {
    const row = document.createElement('div');
    row.className = 'row jobCard border-bottom';
    row.innerHTML = `
      <div class="col-2">
        <img src="images/profile/CV.png" alt="Doc" class="companyLogo" />
        <img style="width:40px;height:42px" src="images/profile/CV.png" alt="Doc" class="mobileLogo" />
      </div>
      <div class="col-10">
        <div class="jobPosition d-flex justify-content-between">
          <div class="d-flex">
            <div class="profileCard">
              <h3>${d.name || 'Document'}</h3>
              <p class="mb-0">${d.type || ''} - ${d.size || ''}</p>
              <p>${d.location || 'Uploaded'}</p>
            </div>
          </div>
          <div>
            <div class="dropdown">
              <img src="images/contentImages/threedot.png" alt="Options" class="threeDot" role="button" data-bs-toggle="dropdown" aria-expanded="false" />
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Edit</a></li>
                <li><a class="dropdown-item" href="#">Delete</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>`;
    containers.documents?.appendChild(row);
  }

  const MONTH = { jan:'Jan', feb:'Feb', mar:'Mar', apr:'Apr', may:'May', jun:'Jun', jul:'Jul', aug:'Aug', sep:'Sep', oct:'Oct', nov:'Nov', dec:'Dec' };
  const fmtMY = (m, y) => (m && y) ? `${MONTH[m] || m} ${y}` : (y || '');

  // ---------- Steps definition ----------
  // const STEPS = [
  //   {
  //     id: 'editContactModal',
  //     nextLabel: 'Next: Work',
  //     collect(modal) {
  //       return {
  //         location: fieldByLabel(modal,'Location')?.value || '',
  //         email:    fieldByLabel(modal,'Email')?.value || '',
  //         phone:    fieldByLabel(modal,'Phone')?.value || '',
  //         website:  fieldByLabel(modal,'Website')?.value || ''
  //       };
  //     },
  //     apply(d) {
  //       setText('.profileIngo.location p', d.location);
  //       setLink('.profileIngo.email p a', `mailto:${d.email}`, d.email);
  //       setText('.profileIngo.phone p', d.phone);
  //       const url = d.website ? (d.website.startsWith('http') ? d.website : `https://${d.website}`) : '';
  //       setLink('.profileIngo.website p a', url, d.website || '');
  //     }
  //   },
  //   {
  //     id: 'addWorkExperienceModal',
  //     nextLabel: 'Next: Education',
  //     collect(modal) {
  //       return {
  //         title:    modal.querySelector('#jobTitleInput')?.value || '',
  //         type:     (modal.querySelector('#jobTypeInput')?.value || '').replace('-', ' ').replace(/\b\w/g,c=>c.toUpperCase()),
  //         company:  modal.querySelector('#companyInput')?.value || '',
  //         start:    fmtMY(modal.querySelector('#startMonthInput')?.value, modal.querySelector('#startYearInput')?.value),
  //         current:  modal.querySelector('#currentJobCheck')?.checked || false,
  //         location: modal.querySelector('#locationInput')?.value || '',
  //         summary:  modal.querySelector('#workSummaryInput')?.value || ''
  //       };
  //     },
  //     apply: renderExperienceCard
  //   },
  //   {
  //     id: 'addEducationModal',
  //     nextLabel: 'Next: Document',
  //     collect(modal) {
  //       return {
  //         degree:     modal.querySelector('#degreeInput')?.value || '',
  //         university: modal.querySelector('#universityInput')?.value || '',
  //         field:      modal.querySelector('#fieldOfStudyInput')?.value || '',
  //         major:      modal.querySelector('#majorSubjectInput')?.value || '',
  //         start:      fmtMY(modal.querySelector('#startMonthInput')?.value, modal.querySelector('#startYearInput')?.value),
  //         end:        fmtMY(modal.querySelector('#endMonthInput')?.value,   modal.querySelector('#endYearInput')?.value),
  //         cgpa:       modal.querySelector('#cgpaInput')?.value || '',
  //         location:   modal.querySelector('#locationInput')?.value || ''
  //       };
  //     },
  //     apply: renderEducationCard
  //   },
  //   {
  //     id: 'addDocumentModal',
  //     nextLabel: 'Finish',
  //     collect(modal) {
  //       const f = modal.querySelector('#documentFileInput')?.files?.[0];
  //       const sizeKB = f ? `${Math.round(f.size / 1024)} KB` : '';
  //       return {
  //         name: f?.name || 'Document',
  //         type: f ? (f.type?.toUpperCase().split('/').pop() || 'FILE') : '',
  //         size: sizeKB,
  //         location: 'Dhaka, Bangladesh'
  //       };
  //     },
  //     apply: renderDocumentCard
  //   }
  // ];

  // ---------- Wire Save → Next behavior ----------
  // STEPS.forEach((step, idx) => {
  //   const modalEl = document.getElementById(step.id);
  //   if (!modalEl) return;
  //
  //   const saveBtn = modalEl.querySelector('.modal-footer .btn.btn-primary');
  //   if (!saveBtn) return;
  //
  //   // initial mode
  //   saveBtn.dataset.mode = 'save';
  //   const originalLabel = saveBtn.textContent;
  //
  //   saveBtn.addEventListener('click', () => {
  //     const mode = saveBtn.dataset.mode;
  //
  //     if (mode === 'save') {
  //       // 1) Save: collect + apply to page
  //       const data = step.collect(modalEl);
  //       step.apply(data);
  //
  //       // 2) Turn this same button into “Next”
  //       saveBtn.dataset.mode = 'next';
  //       saveBtn.textContent = step.nextLabel || 'Next';
  //
  //     } else {
  //       // “Next”: move to the next step
  //       modalAPI(modalEl).hide();
  //       const next = STEPS[idx + 1];
  //       if (next) {
  //         const nextEl = document.getElementById(next.id);
  //         if (nextEl) modalAPI(nextEl).show();
  //       }
  //     }
  //   });
  //
  //   // Reset the button back to “Save” whenever modal closes
  //   modalEl.addEventListener('hidden.bs.modal', () => {
  //     saveBtn.dataset.mode = 'save';
  //     saveBtn.textContent = originalLabel;
  //   });
  // });
});

/* =================================================
   JOBS PAGE — FILTER DROPDOWNS (labels, payloads, UX)
   - Runs only on pages that have .customWrapper
   - For each .custom-select:
       • Shows top label (from markup)
       • Placeholder shown until user selects at least 1 option
       • Adds .select-boxCustom when selected.length > 0
       • Hidden input .filter-payload stores JSON array of labels
================================================= */
window.addEventListener('DOMContentLoaded', function () {
  const filterWrapper = document.querySelector('.customWrapper');
  if (!filterWrapper) return; // page guard

  // Initialize all dropdown widgets
  document.querySelectorAll('.custom-select').forEach(initDropdown);

  // Clear All
  const clearBtn = document.getElementById('clearAllBtn');
  if (clearBtn) clearBtn.addEventListener('click', resetAllDropdowns);

  function initDropdown(dropdownEl) {
    const searchBar        = dropdownEl.querySelector('.searchBar');
    const panel            = dropdownEl.querySelector('.locationDropdown');
    const input            = dropdownEl.querySelector('.locationSearch');
    const dropdownMenu     = dropdownEl.querySelector('.dropdown-menu');
    const hiddenPayload    = dropdownEl.querySelector('.filter-payload');
    const filterKey        = dropdownEl.dataset.filterKey || 'filter';
    const placeholderText  = dropdownEl.dataset.placeholder || 'Select...';

    if (!panel || !input) return;

    // Initial UI: no default selection → show placeholder
    input.value = '';
    input.placeholder = placeholderText;
    input.classList.remove('select-boxCustom');
    if (hiddenPayload && !hiddenPayload.value) hiddenPayload.value = '[]';

    // Toggle open/close
    input.addEventListener('click', () => {
      const isOpen = panel.style.display === 'block';
      document.querySelectorAll('.locationDropdown').forEach(dd => dd.style.display = 'none');
      panel.style.display = isOpen ? 'none' : 'block';
    });

    // Search filter
    if (searchBar) {
      searchBar.addEventListener('input', (e) => {
        const q = e.target.value.toLowerCase();
        dropdownEl.querySelectorAll('.checkbox-item').forEach(item => {
          item.style.display = item.textContent.toLowerCase().includes(q) ? 'block' : 'none';
        });
      });
    }

    // Update selected labels + UI + hidden payload
    const updateSelected = () => {
        const values = Array.from(dropdownEl.querySelectorAll('.locationCheckbox'))
            .filter(cb => cb.checked)
            .map(cb => cb.value)
            .filter(Boolean);

        // Get the LABELS from the checked checkboxes for the visible input field
        const labels = Array.from(dropdownEl.querySelectorAll('.locationCheckbox'))
            .filter(cb => cb.checked)
            .map(cb => cb.nextElementSibling?.textContent?.trim() || '')
            .filter(Boolean);

      // Display text + active bg
      if (labels.length) {
        input.value = labels.join(', ');
        input.classList.add('select-boxCustom');
      } else {
        input.value = '';
        input.placeholder = placeholderText;
        input.classList.remove('select-boxCustom');
      }

      // Hidden payload as JSON array (backend friendly)
      if (hiddenPayload) {
        try {
          hiddenPayload.name = hiddenPayload.name || `filters[${filterKey}]`;
          hiddenPayload.value = JSON.stringify(values);
        } catch { /* no-op */ }
      }

      // Optional: live object & event for backend hooks
      window.JOB_FILTERS = window.JOB_FILTERS || {};
      window.JOB_FILTERS[filterKey] = labels;
      document.dispatchEvent(new CustomEvent('filters:change', { detail: { ...window.JOB_FILTERS } }));
    };

    // Bind all checkboxes
    dropdownEl.querySelectorAll('.locationCheckbox')
      .forEach(cb => cb.addEventListener('change', updateSelected));

    // Close when clicking outside
    window.addEventListener('click', (e) => {
      if (!e.target.closest('.custom-select')) {
        panel.style.display = 'none';
      }
    });

    // Allow content to define height
    if (dropdownMenu) dropdownMenu.style.maxHeight = 'none';

    // Ensure clean start (in case some are pre-checked in markup)
    updateSelected();
  }

  function resetAllDropdowns() {
    document.querySelectorAll('.custom-select').forEach(dropdownEl => {
      dropdownEl.querySelectorAll('.locationCheckbox').forEach(cb => (cb.checked = false));
      const input = dropdownEl.querySelector('.locationSearch');
      const hiddenPayload = dropdownEl.querySelector('.filter-payload');
      const placeholderText = dropdownEl.dataset.placeholder || 'Select...';
      if (input) {
        input.value = '';
        input.placeholder = placeholderText;
        input.classList.remove('select-boxCustom');
      }
      if (hiddenPayload) hiddenPayload.value = '[]';
      const panel = dropdownEl.querySelector('.locationDropdown');
      if (panel) panel.style.display = 'none';
    });

    // Reset live object + event
    window.JOB_FILTERS = {};
    document.dispatchEvent(new CustomEvent('filters:change', { detail: {} }));
  }
});

/* =================================================
   >>> FUTURE DROP ZONES (paste next parts safely):
   // ==== [ZONE A] Header-only or small utilities ====
   // ==== [ZONE B] Feature: Search/filter jobs =======
   // ==== [ZONE C] Feature: Pagination/infinite scroll
================================================= */
