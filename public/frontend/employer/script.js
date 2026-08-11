/* =========================================================
   GRAPHO — MASTER JS
   Includes:
   (A) Snackbar / Toaster for "Post job"
   (B) Create Job → One modal, three-step wizard (single form)
       - All nav buttons are type="submit"
       - Final button (id=postSubmitBtn) = real submit to backend
   (C) Pill Filters (multi-select + search + JSON payload)
       - No page reload by default; updates URL query string
       - Set data-submit-mode="submit" on the form to do real submit
   ========================================================= */

/* ---------------------------
   (A) TOASTER / SNACKBAR
   --------------------------- */
document.addEventListener('DOMContentLoaded', () => {
  const postJobBtn = document.getElementById('modalPostJobBtn'); // button in Review modal (if used)
  const snackbar   = document.getElementById('snackbar');
  const closeBtn   = document.getElementById('snackbar-close');

  if (postJobBtn && snackbar) {
    postJobBtn.addEventListener('click', () => {
      snackbar.classList.add('show');
      setTimeout(() => snackbar.classList.remove('show'), 4000);
    });
  }
  if (closeBtn && snackbar) {
    closeBtn.addEventListener('click', () => snackbar.classList.remove('show'));
  }
});

/* -----------------------------------------------
   (B) CREATE JOB — ONE MODAL, THREE-STEP WIZARD
   Requirements:
   - Modal id="createJobModal"
   - Single <form id="createJobForm"> inside the modal
   - Step containers: .stepOne, .stepTwo, .stepThree
   - Nav buttons (all type="submit"):
       step 1: #continueToStep2, #btnCancelStep1
       step 2: #backToStepOne,  #goStep3
       step 3: #backToStepTwo,  #postSubmitBtn (final submit)
   - Optional preview targets in step 2/3:
       #previewTitle, #previewType, #previewLoc
   ----------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
  const modalEl = document.getElementById('createJobModal');
  if (!modalEl) return;

  const form  = document.getElementById('createJobForm') || modalEl.querySelector('form');
  const step1 = modalEl.querySelector('.stepOne');
  const step2 = modalEl.querySelector('.stepTwo');
  const step3 = modalEl.querySelector('.stepThree');

  if (!form || !step1 || !step2 || !step3) return;

  // Helper: show only one step at a time
  const show = (el) => {
    [step1, step2, step3].forEach(s => s.classList.add('d-none'));
    el.classList.remove('d-none');
    modalEl.scrollTop = 0; // reset scroll inside modal
  };

  // Keep wizard reset when modal opens/closes
  modalEl.addEventListener('shown.bs.modal', () => show(step1));
  modalEl.addEventListener('hidden.bs.modal', () => show(step1));

  // Optional preview sync to step 2/3
  const syncPreview = () => {
    const title = form.querySelector('input[name="title"]')?.value || 'Untitled job';
    const type  = form.querySelector('input[name="jobType"]:checked')?.value || '';
    const loc   = form.querySelector('input[name="jobLocation"]:checked')?.value || '';
    const t  = modalEl.querySelector('#previewTitle');
    const tp = modalEl.querySelector('#previewType');
    const lc = modalEl.querySelector('#previewLoc');
    if (t)  t.textContent  = title;
    if (tp) tp.textContent = type;
    if (lc) lc.textContent = loc;
  };
  form.addEventListener('input',  syncPreview);
  form.addEventListener('change', syncPreview);

  // Router: handle by clicked submitter's id
  form.addEventListener('submit', (e) => {
    const id = e.submitter ? e.submitter.id : '';

    // STEP 1
    if (id === 'continueToStep2') { e.preventDefault(); syncPreview(); show(step2); return; }
    if (id === 'btnCancelStep1')  { e.preventDefault(); bootstrap.Modal.getOrCreateInstance(modalEl).hide(); return; }

    // STEP 2
    if (id === 'backToStepOne')   { e.preventDefault(); show(step1); return; }
    if (id === 'goStep3')         { e.preventDefault(); syncPreview(); show(step3); return; }

    // STEP 3
    if (id === 'backToStepTwo')   { e.preventDefault(); show(step2); return; }

    // FINAL SUBMIT (REAL SUBMIT TO BACKEND)
    if (id === 'postSubmitBtn') { /* allow natural submit */ return; }

    // Enter-key fallback: advance wizard instead of submitting early
    if (!id) {
      e.preventDefault();
      if (!step1.classList.contains('d-none'))      document.getElementById('continueToStep2')?.click();
      else if (!step2.classList.contains('d-none')) document.getElementById('goStep3')?.click();
      else                                          document.getElementById('postSubmitBtn')?.click();
    }
  });
});

/* -----------------------------------------------------------------
   (C) PILL FILTERS — MULTI-SELECT + SEARCH + HIDDEN JSON PAYLOADS
   HTML contract:
   - <form id="jobFiltersPills" data-autosubmit="true" data-submit-mode="url">
       Each filter group: .pill-filter[data-filter-key][data-placeholder]
         .dropdown-toggle
         .dropdown-menu .pill-search + .pill-options (checkbox items)
         <input type="hidden" class="filter-payload" name="filters[<key>]" />
     </form>
   Behavior:
   - By default (data-submit-mode="url"), NO PAGE RELOAD.
     We update the URL query string using history.replaceState()
     This fixes "Cannot GET /jobs" when backend route is absent.
   - To force real submit: set data-submit-mode="submit" on the form.
   - Live state exposed as window.JOB_FILTERS and "filters:change" event.
   ----------------------------------------------------------------- */
/* =========================================================
   TOASTER (Review/Post modal)
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
  const postJobBtn = document.getElementById('modalPostJobBtn');
  const snackbar   = document.getElementById('snackbar');

  if (postJobBtn && snackbar) {
    postJobBtn.addEventListener('click', () => {
      snackbar.classList.add('show');
      setTimeout(() => snackbar.classList.remove('show'), 4000);
    });
  }
  document.getElementById('snackbar-close')?.addEventListener('click', () => {
    snackbar?.classList.remove('show');
  });
});

/* =========================================================
   ONE-MODAL WIZARD (step1 -> step2 -> step3)
   - All buttons are type="submit"
   - We preventDefault except the final submit
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
  const modalEl = document.getElementById('createJobModal');
  if (!modalEl) return;

  const form  = document.getElementById('createJobForm');
  const step1 = modalEl.querySelector('.stepOne');
  const step2 = modalEl.querySelector('.stepTwo');
  const step3 = modalEl.querySelector('.stepThree');

  const show = (el) => { [step1, step2, step3].forEach(s => s?.classList.add('d-none')); el?.classList.remove('d-none'); modalEl.scrollTop = 0; };

  // live preview sync (optional)
  const syncPreview = () => {
    const title = form?.querySelector('input[name="title"]')?.value || 'Untitled job';
    const type  = form?.querySelector('input[name="jobType"]:checked')?.value || '';
    const loc   = form?.querySelector('input[name="jobLocation"]:checked')?.value || '';
    const t  = modalEl.querySelector('#previewTitle'); if (t)  t.textContent  = title;
    const tp = modalEl.querySelector('#previewType');  if (tp) tp.textContent = type;
    const lc = modalEl.querySelector('#previewLoc');   if (lc) lc.textContent = loc;
  };
  form?.addEventListener('input',  syncPreview);
  form?.addEventListener('change', syncPreview);

  form?.addEventListener('submit', (e) => {
    const id = e.submitter ? e.submitter.id : '';

    // Step 1 controls
    if (id === 'continueToStep2') { e.preventDefault(); syncPreview(); show(step2); return; }
    if (id === 'btnCancelStep1')  { e.preventDefault(); bootstrap.Modal.getOrCreateInstance(modalEl).hide(); return; }

    // Step 2 controls
    if (id === 'backToStepOne')   { e.preventDefault(); show(step1); return; }
    if (id === 'goStep3')         { e.preventDefault(); syncPreview(); show(step3); return; }

    // Step 3 controls
    if (id === 'backToStepTwo')   { e.preventDefault(); show(step2); return; }

    // Final submit (Post submit) → allow natural submit
    if (id === 'postSubmitBtn') { return; }

    // Enter key fallback
    if (!id) {
      e.preventDefault();
      if (!step1.classList.contains('d-none'))      document.getElementById('continueToStep2')?.click();
      else if (!step2.classList.contains('d-none')) document.getElementById('goStep3')?.click();
      else                                          document.getElementById('postSubmitBtn')?.click();
    }
  });
});

/* ======================================================================
   PILL FILTERS — Multi-select + Search + Hidden JSON payloads + Top label
   Default: nothing preselected; autosubmit updates URL without reload.
   HTML contract:
   <form id="jobFiltersPills" data-autosubmit="true" data-submit-mode="url">
     .pill-filter[data-filter-key][data-placeholder]
       .dropdown-toggle
       .dropdown-menu .pill-search + .pill-options (checkbox items)
       <input type="hidden" class="filter-payload" name="filters[<key>]" />
   </form>
   Modes:
   - data-submit-mode="url"   → uses history.replaceState() (no  GET /jobs error)
   - data-submit-mode="submit"→ normal GET submit
   Live state: window.JOB_FILTERS + "filters:change" event
   ====================================================================== */
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('jobFiltersPills');
  if (!form) return;

  const autoSubmit = (form.dataset.autosubmit || 'true').toLowerCase() === 'true';
  const submitMode = (form.dataset.submitMode || 'url').toLowerCase(); // 'url' | 'submit'

  // Ensure nothing is checked by default (even if HTML had checked)
  form.querySelectorAll('.pill-checkbox:checked').forEach(cb => cb.checked = false);

  // global live object
  window.JOB_FILTERS = window.JOB_FILTERS || {};

  // helper: apply form values to URL (no reload)
  function applyFiltersNoReload() {
    const fd = new FormData(form);
    const qs = new URLSearchParams();
    for (const [k, v] of fd.entries()) {
      if (k && v && String(v).length) qs.set(k, v);
    }
    const url = `${location.pathname}?${qs.toString()}`;
    history.replaceState({}, '', url);
  }

  // add a top label above each pill, using placeholder as text
  document.querySelectorAll('.pill-filter').forEach(wrap => {
    if (wrap.querySelector('.pill-label')) return;
    const btn = wrap.querySelector('.dropdown-toggle');
    const labelText = wrap.dataset.label || wrap.dataset.placeholder || (btn ? btn.textContent.trim() : 'Filter');
    const span = document.createElement('span');
    span.className = 'pill-label';
    span.textContent = labelText;
    wrap.insertBefore(span, wrap.firstElementChild);
    if (btn) { const id = 'pilllbl-' + Math.random().toString(36).slice(2,8); span.id = id; btn.setAttribute('aria-labelledby', id); }
  });

  // wire each filter
  form.querySelectorAll('.pill-filter').forEach((wrap) => {
    const trigger    = wrap.querySelector('.dropdown-toggle');
    const payload    = wrap.querySelector('.filter-payload');
    const search     = wrap.querySelector('.pill-search');
    const optsBox    = wrap.querySelector('.pill-options');
    const checkboxes = wrap.querySelectorAll('.pill-checkbox');

    const filterKey   = wrap.dataset.filterKey || 'filter';
    const placeholder = wrap.dataset.placeholder || 'Select';

    // backend-friendly name if missing
    if (payload && !payload.name) payload.name = `filters[${filterKey}]`;

    // in-menu search
    if (search && optsBox) {
      search.addEventListener('input', (e) => {
        const q = e.target.value.toLowerCase();
        optsBox.querySelectorAll('.dropdown-item').forEach(item => {
          const text = (item.textContent || '').toLowerCase();
          item.style.display = text.includes(q) ? 'flex' : 'none';
        });
      });
    }

    // update button label + hidden payload + live object
    function updateSelected() {
      const labels = Array.from(checkboxes)
        .filter(cb => cb.checked)
        .map(cb => cb.parentElement?.textContent?.trim() || '')
        .filter(Boolean);

      if (labels.length) {
        trigger.textContent = labels.join(', ');
        trigger.classList.remove('btn-outline-secondary');
        trigger.classList.add('btn-outline-warning', 'active');
      } else {
        trigger.textContent = placeholder;
        trigger.classList.remove('btn-outline-warning', 'active');
        trigger.classList.add('btn-outline-secondary');
      }

      if (payload) payload.value = JSON.stringify(labels);

      window.JOB_FILTERS[filterKey] = labels;
      document.dispatchEvent(new CustomEvent('filters:change', { detail: { ...window.JOB_FILTERS } }));

      if (autoSubmit) {
        if (submitMode === 'submit') form.requestSubmit?.();
        else applyFiltersNoReload();
      }
    }

    // keep dropdown open on menu click
    wrap.querySelector('.dropdown-menu')?.addEventListener('click', (e) => e.stopPropagation());

    // bind changes
    checkboxes.forEach(cb => cb.addEventListener('change', updateSelected));

    // init state (none selected)
    updateSelected();
  });

  // Clear All
  const clearAllBtn = document.getElementById('pillFiltersClearAll');
  if (clearAllBtn) {
    clearAllBtn.addEventListener('click', () => {
      form.querySelectorAll('.pill-checkbox').forEach(cb => cb.checked = false);
      form.querySelectorAll('.pill-filter').forEach(wrap => {
        const trigger     = wrap.querySelector('.dropdown-toggle');
        const payload     = wrap.querySelector('.filter-payload');
        const placeholder = wrap.dataset.placeholder || 'Select';
        if (trigger){
          trigger.textContent = placeholder;
          trigger.classList.remove('btn-outline-warning','active');
          trigger.classList.add('btn-outline-secondary');
        }
        if (payload) payload.value = '[]';
      });
      window.JOB_FILTERS = {};
      document.dispatchEvent(new CustomEvent('filters:change', { detail: {} }));

      if (autoSubmit) {
        if (submitMode === 'submit') form.requestSubmit?.();
        else history.replaceState({}, '', location.pathname);  // wipe query
      }
    });
  }

  // Safety: prevent real submit when mode=url
  form.addEventListener('submit', (e) => {
    if (submitMode !== 'submit') {
      e.preventDefault();
      applyFiltersNoReload();
    }
  });
});
