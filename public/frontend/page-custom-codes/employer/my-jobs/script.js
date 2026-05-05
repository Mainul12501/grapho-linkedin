// Fix dropdown z-index — lift the .col-12 wrapper so dropdown isn't hidden behind next card
$(document).on('show.bs.dropdown', '.mj-card-actions', function () {
    $(this).closest('.col-12').addClass('mj-dropdown-open');
});
$(document).on('hidden.bs.dropdown', '.mj-card-actions', function () {
    $(this).closest('.col-12').removeClass('mj-dropdown-open');
});

$(document).ready(function () {
    CKEDITOR.replace( 'summernote', {
        versionCheck: false,
        height: 450
    } );
})
function searchOnMobile() {
    window.location ="{{ route('employer.my-jobs') }}?search_text="+$('#mobile_search_text').val();
}

$(document).on('click', '.edit-job', function () {

    var jobId = $(this).attr('data-job-id');

    sendAjaxRequest('employer/job-tasks/'+jobId+'/edit', 'GET').then(function (response) {
        // console.log(response);
        $('#editJobForm').empty().append(response);

        $('.select2').select2({
            width: "100%",
        });
        CKEDITOR.replace( 'summernote2', {
            versionCheck: false
        } );
        $('#editJobModal').modal('show');
    })
})

$(document).ready(function() {
    // $('#summernote').summernote({
    //     height: 200
    // });

});
$(document).on('click', '.salary-type', function () {
    setInputValueByClassName($(this), 'job_pref_salary_payment_type', 'data-value');
})
$(document).on('click', '.return-to-first-part', function () {
    $('.stepTwo').addClass('d-none');
    $('.stepOne').removeClass('d-none');
})
$(document).on('click', '#continueToStep2', function () {
    var btnParentForm = $(this).attr('data-continue-btn-parent-form');
    $('#formJobTitle').text($('#'+btnParentForm+' input[name="job_title"]').val());
    $('#jobJobType').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_type_id"]:checked').attr('id')+'"]').text());
    $('#jobjobLocationType').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_location_type_id"]:checked').attr('id')+'"]').text());
    // document.querySelector('#createJobModal .stepOne').classList.add('d-none');
    $('.stepOne').addClass('d-none');
    // document.querySelector('#createJobModal .jobModalForPost').classList.remove('d-none');
    $('.jobModalForPost').removeClass('d-none');
    $('.stepTwo').removeClass('d-none');
})
$(document).on('click', '#continueToStep2Edit', function () {
    var btnParentForm = $(this).attr('data-continue-btn-parent-form');

    $('#formJobTitleEdit').text($('#'+btnParentForm+' input[name="job_title"]').val());
    $('#jobJobTypeEdit').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_type_id"]:checked').attr('id')+'"]').text());
    $('#jobjobLocationTypeEdit').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_location_type_id"]:checked').attr('id')+'"]').text());
    // document.querySelector('#createJobModal .stepOne').classList.add('d-none');
    $('.stepOne').addClass('d-none');
    // document.querySelector('#createJobModal .jobModalForPost').classList.remove('d-none');
    $('.jobModalForPost').removeClass('d-none');
    $('.stepTwo').removeClass('d-none');
})
$(document).on('click', '#createJobModal #backToStepOne', function () {
    // document.querySelector('#createJobModal .stepOne').classList.remove('d-none');
    $('#createJobModal .stepOne').removeClass('d-none');
    // document.querySelector('#createJobModal .jobModalForPost').classList.add('d-none');
    $('#createJobModal .jobModalForPost').addClass('d-none');
})
$(document).on('click', '#editJobModal #backToStepOne', function () {
    $('#editJobModal .stepOne').removeClass('d-none');
    $('#editJobModal .jobModalForPost').addClass('d-none');
})
$(document).on('click', '#showCustomExperienceField', function () {
    $('#customExperienceField').toggle();
})
$(document).on('click', '#editshowCustomExperienceField', function () {
    $('#editcustomExperienceField').toggle();
})

$(document).on('click', '.show-job-details', function () {
    var jobId = $(this).attr('data-job-id');
    sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET', {job_task: jobId})
        .then(function (response) {
            // console.log(response.job);

            $('#printJobDetailsHere').empty().append(response);
            $('#jobDetailsModal').modal('show');
        })
})

$(document).on('click', '.show-review-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();

    // const formId = 'jobCreateForm';
    const formId = $(this).closest('form').attr('id');

    // Run validation FIRST
    if (validateJobForm(formId)) {
        // ✅ Validation passed - proceed with original functionality
        var getModalId = $(this).attr('data-modal-id');
        $(this).blur();

        // Call your existing function
        showReviewModalWithData(`#${getModalId} `);

        // Set attributes for submit button
        $('#modalPostJobBtn')
            .attr('req-for', 'create')
            .attr('data-modal-id', getModalId)
            .addClass('submit-form-after-review');

        // Show review modal after short delay
        setTimeout(function () {
            $('#jobDetailsModalReview').modal('show');
        }, 50);

        return true;
    } else {
        // ❌ Validation failed - stop everything
        toastr.error('Validation failed! Please fix the errors before reviewing.');

        // Scroll to first error
        const firstError = $('.is-invalid, .validation-error').first();
        if (firstError.length) {
            firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        return false;
    }
});


$(document).on('click', '.hide-review-modal', function () {

    $('#jobDetailsModalReview').modal('hide');

});
$(document).on('click', '.submit-form-after-review', function () {
    var modalId = $(this).attr('data-modal-id');
    $(`#${modalId} form`).submit();
});
function showReviewModalWithData(parentModalId = '#createJobModal ') {
    // collect values
    var companyLogo = $('#companyLogo').val();
    var companyName = $('#companyName').val();
    var companyAddress = $('#companyAddress').val();
    var companyOverview = $('#companyOverview').val();

    var jobTitle = $(parentModalId+'input[name="job_title"]').val();

    var jobType = $(parentModalId+'label[for="'+$(parentModalId+'input[name="job_type_id"]:checked').attr('id')+'"]').text();
    var jobLocationType = $(parentModalId+'label[for="'+$('input[name="job_location_type_id"]:checked').attr('id')+'"]').text();
    var requiredExperience = $(parentModalId+'input[name="required_experience"]:checked').val();
    // var description = $(parentModalId+'textarea[name="description"]').val();
    if (parentModalId == '#createJobModal ')
        var description = CKEDITOR.instances['summernote'].getData();
    else
        var description = CKEDITOR.instances['summernote2'].getData();

    var finalExperience = '';
    if (requiredExperience == 'custom')
    {
        finalExperience = $(parentModalId+'input[name="exp_range_start"]').val()+' - '+$('input[name="exp_range_end"]').val();
    } else {
        finalExperience = requiredExperience;
    }
    var deadline = $(parentModalId+'input[name="deadline"]').val();
    var salary = $(parentModalId+'input[name="salary_amount"]').val();
    var salaryPaymentType = $(parentModalId+'input[name="job_pref_salary_payment_type"]').val();
    var cgpa = $(parentModalId+'input[name="cgpa"]').val();


    var selectedFOSTexts = [];
    $(parentModalId+'select[name="field_of_study_preference[]"] option:selected').each(function() {
        selectedFOSTexts.push($(this).text());
    });
    if (selectedFOSTexts.length > 0)
        $('.toggle-fosp').removeClass('d-none');

    var selectedVersityTexts = [];
    $(parentModalId+'select[name="university_preference[]"] option:selected').each(function() {
        selectedVersityTexts.push($(this).text());
    });
    if (selectedVersityTexts.length > 0)
        $('.toggle-uni').removeClass('d-none');

    var selectedSkillsTexts = [];
    $(parentModalId+'.selected-skills-container .selected-skill-tag').each(function() {
        selectedSkillsTexts.push($(this).find('span:first').text());
    });
    if (selectedSkillsTexts.length > 0)
        $('.toggle-skills').removeClass('d-none');

    // print values
    $('.reviewJobTitle').text(jobTitle);
    $('#companyLogo').text(companyLogo);
    $('#modalCompanyLogo').attr('src', companyLogo);
    $('.companyName').text(companyName);
    $('#companyAddress').text(companyAddress);
    $('.companyOverview').html(companyOverview);

    $('#reviewJobType').text(jobType);
    $('#reviewJobLocationType').text(jobLocationType);
    $('#reviewExperience').text(finalExperience);
    $('#reviewDeadline').text(deadline);
    $('#reviewSalary').text(salary);
    $('#view_job_pref_salary_payment_type').text(salaryPaymentType);
    if (cgpa.length > 0)
    {
        $('.toggle-cgpa').removeClass('d-none');
    }
    $('#printCgpa').text(cgpa);
    $('#reviewJobRequirements').empty();
    $('#reviewJobRequirements').html(description);

    $('#printFieldOfStudy').empty();
    $.each(selectedFOSTexts, function(index, text) {
        $('#printFieldOfStudy').append('<li>' + text + '</li>');
    });
    $('#printUniversity').empty();
    $.each(selectedVersityTexts, function(index, text) {
        $('#printUniversity').append('<li>' + text + '</li>');
    });

    $('#printSkills').empty();
    $.each(selectedSkillsTexts, function(index, text) {
        $('#printSkills').append('<li>' + text + '</li>');
    });

}

// job form validations

// Common validation function for job forms
function validateJobForm(formId) {
    const form = document.getElementById(formId);
    let isValid = true;
    let errors = [];

    // Clear previous error messages
    clearErrors(form);

    // 1. Job Title - Required
    const jobTitle = form.querySelector('[name="job_title"]');
    if (!jobTitle || !jobTitle.value.trim()) {
        showError(jobTitle, 'Job title is required');
        errors.push('Job title is required');
        isValid = false;
    }

    // 2. Job Type - Required (at least one radio should be checked)
    const jobType = form.querySelector('[name="job_type_id"]:checked');
    if (!jobType) {
        const jobTypeContainer = form.querySelector('[name="job_type_id"]')?.closest('.mb-4');
        showError(jobTypeContainer, 'Please select a job type');
        errors.push('Job type is required');
        isValid = false;
    }

    // 3. Job Location Type - Required
    const jobLocationType = form.querySelector('[name="job_location_type_id"]:checked');
    if (!jobLocationType) {
        const locationContainer = form.querySelector('[name="job_location_type_id"]')?.closest('.mb-4');
        showError(locationContainer, 'Please select a job location type');
        errors.push('Job location type is required');
        isValid = false;
    }

    // 4. Required Experience - Required
    const experience = form.querySelector('[name="required_experience"]:checked');
    if (!experience) {
        const expContainer = form.querySelector('[name="required_experience"]')?.closest('.bg-white');
        showError(expContainer, 'Please select required experience');
        errors.push('Required experience is required');
        isValid = false;
    } else if (experience.value === 'custom') {
        // Validate custom experience range
        const expRangeStart = form.querySelector('[name="exp_range_start"]');
        const expRangeEnd = form.querySelector('[name="exp_range_end"]');

        if (!expRangeStart?.value || !expRangeEnd?.value) {
            showError(expRangeStart?.parentElement, 'Please enter both start and end years for custom experience');
            errors.push('Custom experience range incomplete');
            isValid = false;
        } else if (parseInt(expRangeStart.value) >= parseInt(expRangeEnd.value)) {
            showError(expRangeStart?.parentElement, 'End year must be greater than start year');
            errors.push('Invalid experience range');
            isValid = false;
        }
    }

    // 5. Industry - Required
    const industry = form.querySelector('[name="industry_id"]');
    if (!industry || !industry.value) {
        showError(industry, 'Please select an industry');
        errors.push('Industry is required');
        isValid = false;
    }


    // 8. CGPA - Required, must be a number, min 0
    const cgpa = form.querySelector('[name="cgpa"]');

    if (isNaN(cgpa.value) || parseFloat(cgpa.value) < 0) {
        showError(cgpa, 'CGPA must be a valid number greater than or equal to 0');
        errors.push('Invalid CGPA');
        isValid = false;
    } else if (parseFloat(cgpa.value) > 4.0) {
        showError(cgpa, 'CGPA cannot exceed 4.0');
        errors.push('CGPA too high');
        isValid = false;
    }

    // 9. Gender - Required
    const gender = form.querySelector('[name="gender"]');
    if (!gender || !gender.value) {
        showError(gender, 'Please select a gender.');
        errors.push('Gender is required');
        isValid = false;
    }



    // 11. Salary Amount - Required, must be a number, min 0
    const salary = form.querySelector('[name="salary_amount"]');


    // 13. Deadline - Required, must be a future date
    const deadline = form.querySelector('[name="deadline"]');
    if (!deadline || !deadline.value) {
        showError(deadline, 'Application deadline is required');
        errors.push('Application deadline is required');
        isValid = false;
    } else {
        const selectedDate = new Date(deadline.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Reset time to compare dates only

        if (selectedDate <= today) {
            showError(deadline, 'Application deadline must be a future date');
            errors.push('Invalid deadline date');
            isValid = false;
        }
    }

    // Display summary if there are errors
    if (!isValid) {
        displayErrorSummary(form, errors);
    }

    return isValid;
}

// Helper function to show error messages
function showError(element, message) {
    if (!element) return;

    // Add error class to input
    if (element.tagName === 'INPUT' || element.tagName === 'SELECT' || element.tagName === 'TEXTAREA') {
        element.classList.add('is-invalid');

        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;
        element.parentNode.appendChild(errorDiv);
    } else {
        // For containers
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger mt-2 validation-error';
        errorDiv.textContent = message;
        element.appendChild(errorDiv);
    }
}

// Helper function to clear all errors
function clearErrors(form) {
    // Remove error classes
    form.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });

    // Remove error messages
    form.querySelectorAll('.invalid-feedback, .validation-error, .error-summary').forEach(el => {
        el.remove();
    });
}

// Display error summary at the top of the form
function displayErrorSummary(form, errors) {
    const summaryDiv = document.createElement('div');
    summaryDiv.className = 'alert alert-danger error-summary mb-3';
    summaryDiv.innerHTML = `
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            ${errors.map(error => `<li>${error}</li>`).join('')}
        </ul>
    `;

    // Insert at the beginning of the visible step
    const activeStep = form.querySelector('.wizard-step:not(.d-none)');
    if (activeStep) {
        activeStep.insertBefore(summaryDiv, activeStep.firstChild);
        // Scroll to top of modal
        summaryDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Initialize validation with jQuery
$(document).ready(function() {


    // Validate on form submit (as backup)
    $('#jobCreateForm').on('submit', function(e) {
        if (!validateJobForm('jobCreateForm')) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });

    // Handle continue to step 2 button
    $('#continueToStep2').on('click', function(e) {
        e.preventDefault();

        const form = $('#jobCreateForm');
        clearErrors(form[0]);
        let isValid = true;
        let errors = [];

        // Validate only Step 1 fields
        const jobTitle = form.find('[name="job_title"]');
        if (!jobTitle.val() || !jobTitle.val().trim()) {
            showError(jobTitle[0], 'Job title is required');
            errors.push('Job title is required');
            isValid = false;
        }

        const jobType = form.find('[name="job_type_id"]:checked');
        if (jobType.length === 0) {
            const container = form.find('[name="job_type_id"]').first().closest('.mb-4');
            showError(container[0], 'Please select a job type');
            errors.push('Job type is required');
            isValid = false;
        }

        const jobLocationType = form.find('[name="job_location_type_id"]:checked');
        if (jobLocationType.length === 0) {
            const container = form.find('[name="job_location_type_id"]').first().closest('.mb-4');
            showError(container[0], 'Please select a job location type');
            errors.push('Job location type is required');
            isValid = false;
        }

        if (!isValid) {
            displayErrorSummary(form[0], errors);
        } else {
            // Proceed to step 2
            $('.stepOne').addClass('d-none');
            $('.stepTwo').removeClass('d-none');
        }
    });

    // Handle back to step 1
    $('#backToStepOne, .return-to-first-part').on('click', function(e) {
        e.preventDefault();
        $('.stepTwo').addClass('d-none');
        $('.stepOne').removeClass('d-none');
        clearErrors($('#jobCreateForm')[0]);
    });

    // Salary type selection handler
    $(document).on('click', '.salary-type', function(e) {
        e.preventDefault();
        $('.salary-type').removeClass('active');
        $(this).addClass('active');
        $('.job_pref_salary_payment_type').val($(this).data('value'));
    });

    // Custom experience field toggle
    $('[name="required_experience"]').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#customExperienceField').show();
        } else {
            $('#customExperienceField').hide();
        }
    });

    // Real-time validation - clear error on input
    $(document).on('blur', '#jobCreateForm input, #jobCreateForm select, #jobCreateForm textarea', function() {
        $(this).removeClass('is-invalid');
        $(this).parent().find('.invalid-feedback').remove();
    });

    // Clear error when selecting from multi-select
    $(document).on('change', '#jobCreateForm select[multiple]', function() {
        $(this).removeClass('is-invalid');
        $(this).closest('.bg-white').find('.validation-error').remove();
    });
});

$(document).ready(function() {
    let searchTimer;

    // Get form type from element
    function getForm(el) {
        return $(el).closest('[data-form]').data('form') || $(el).data('form');
    }

    // Check if skill is selected
    function isSelected(form, skillId) {
        return $(`.selected-skills-container[data-form="${form}"] .selected-skill-tag[data-id="${skillId}"]`).length > 0;
    }

    // Add skill
    function addSkill(form, skillId, skillName) {
        if (isSelected(form, skillId)) return;

        var tag = `<div class="selected-skill-tag" data-id="${skillId}">
              <input type="hidden" name="required_skills[]" value="${skillId}">
              <span>${skillName}</span>
              <span class="remove-skill">&times;</span>
          </div>`;

        $(`.selected-skills-container[data-form="${form}"]`).append(tag);
        $(`.skill-category-box[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).addClass('selected-skill');
        $(`.skill-search-results[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).addClass('selected-skill');
    }

    // Remove skill
    function removeSkill(form, skillId) {
        $(`.selected-skills-container[data-form="${form}"] .selected-skill-tag[data-id="${skillId}"]`).remove();
        $(`.skill-category-box[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).removeClass('selected-skill');
        $(`.skill-search-results[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).removeClass('selected-skill');
    }

    // Show categories
    function showCategories(form) {
        $(`.skill-search-results[data-form="${form}"]`).addClass('d-none');
        $(`.skill-category-box[data-form="${form}"]`).show();
    }

    // Show search results
    function showSearchResults(form) {
        $(`.skill-search-results[data-form="${form}"]`).removeClass('d-none');
        $(`.skill-category-box[data-form="${form}"]`).hide();
    }

    // Click on category skill
    $(document).on('click', '.skill-category-box .skill-btn', function(e) {
        e.preventDefault();
        var form = getForm(this);
        var skillId = $(this).data('id');
        var skillName = $(this).data('name');

        if (isSelected(form, skillId)) {
            removeSkill(form, skillId);
        } else {
            addSkill(form, skillId, skillName);
        }
    });

    // Click on search result skill
    $(document).on('click', '.skill-search-results .skill-btn', function(e) {
        e.preventDefault();
        var form = getForm(this);
        var skillId = $(this).data('id');
        var skillName = $(this).data('name');

        if (isSelected(form, skillId)) {
            removeSkill(form, skillId);
        } else {
            addSkill(form, skillId, skillName);
        }
    });

    // Click remove button
    $(document).on('click', '.remove-skill', function(e) {
        e.preventDefault();
        var tag = $(this).closest('.selected-skill-tag');
        var form = getForm(tag.closest('.selected-skills-container'));
        var skillId = tag.data('id');
        removeSkill(form, skillId);
    });

    // Search input
    $(document).on('input', '.skill-search-input', function() {
        clearTimeout(searchTimer);
        var input = $(this);
        var form = input.data('form');
        var query = input.val().trim();

        if (query === '') {
            showCategories(form);
            return;
        }

        searchTimer = setTimeout(function() {
            $.ajax({
                url: '{{ route("search-skills") }}',
                method: 'GET',
                data: { q: query },
                success: function(skills) {
                    var html = '';
                    if (skills.length === 0) {
                        html = '<p class="text-muted">No skills found</p>';
                    } else {
                        skills.forEach(function(skill) {
                            var selected = isSelected(form, skill.id) ? 'selected-skill' : '';
                            var category = skill.skills_category ? ' <small class="text-muted">(' + skill.skills_category.category_name + ')</small>' : '';
                            html += `<label class="btn border skill-btn m-1 ${selected}" data-id="${skill.id}" data-name="${skill.skill_name}">${skill.skill_name}${category}</label>`;
                        });
                    }
                    $(`.skill-search-results[data-form="${form}"] .skill-search-list`).html(html);
                    showSearchResults(form);
                }
            });
        }, 300);
    });

    // Show/hide clear button based on input value
    $(document).on('input', '.skill-search-input', function() {
        const form = $(this).data('form');
        const hasValue = $(this).val().trim().length > 0;
        $(`.clear-skill-search[data-form="${form}"]`).toggle(hasValue);
    });

    // Clear skill search input and show category skills
    $(document).on('click', '.clear-skill-search', function() {
        const form = $(this).data('form');
        $(`.skill-search-input[data-form="${form}"]`).val('').focus();
        $(`.skill-search-results[data-form="${form}"]`).addClass('d-none');
        $(`.skill-category-box[data-form="${form}"]`).show();
        $(this).hide();
    });

    // Modal events - Create
    $('#createJobModal').on('shown.bs.modal', function() {
        $('.skill-search-input[data-form="create"]').val('');
        showCategories('create');
    });

    $('#createJobModal').on('hidden.bs.modal', function() {
        $('.skill-search-input[data-form="create"]').val('');
        $('.selected-skills-container[data-form="create"]').empty();
        $('.skill-category-box[data-form="create"] .skill-btn').removeClass('selected-skill');
        showCategories('create');
    });

    // Modal events - Edit
    $('#editJobModal').on('shown.bs.modal', function() {
        $('.skill-search-input[data-form="edit"]').val('');
        showCategories('edit');
    });

    $('#editJobModal').on('hidden.bs.modal', function() {
        $('.skill-search-input[data-form="edit"]').val('');
        showCategories('edit');
    });
});
