// Company Information Form Validation
$(document).ready(function() {
    $('#employerCompanyEditModal form').on('submit', function(e) {
        e.preventDefault();
        clearCompanyErrors();

        let isValid = true;
        let errors = [];

        const nameInput = $(this).find('[name="name"]');
        const nameValue = nameInput.val().trim();
        if (!nameValue) {
            showCompanyError(nameInput, 'Company name is required');
            errors.push('Company name is required');
            isValid = false;
        } else if (nameValue.length < 2) {
            showCompanyError(nameInput, 'Company name must be at least 2 characters');
            errors.push('Company name must be at least 2 characters');
            isValid = false;
        }

        const emailInput = $(this).find('[name="email"]');
        const emailValue = emailInput.val().trim();
        if (!emailValue) {
            showCompanyError(emailInput, 'Email is required');
            errors.push('Email is required');
            isValid = false;
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailValue)) {
                showCompanyError(emailInput, 'Please enter a valid email address');
                errors.push('Invalid email format');
                isValid = false;
            }
        }

        const mobileInput = $(this).find('[name="phone"]');
        const mobileValue = mobileInput.val().trim();
        if (mobileValue) {
            const onlyDigits = /^[0-9]+$/;
            if (!onlyDigits.test(mobileValue)) {
                showCompanyError(mobileInput, 'Mobile number must contain only digits');
                errors.push('Invalid mobile format');
                isValid = false;
            } else if (!mobileValue.startsWith('01')) {
                showCompanyError(mobileInput, 'Mobile number must start with 01');
                errors.push('Mobile must start with 01');
                isValid = false;
            } else if (mobileValue.length !== 11) {
                showCompanyError(mobileInput, 'Mobile number must be exactly 11 digits');
                errors.push('Mobile must be 11 digits');
                isValid = false;
            } else {
                const validPrefixes = ['013', '014', '015', '016', '017', '018', '019'];
                const prefix = mobileValue.substring(0, 3);
                if (!validPrefixes.includes(prefix)) {
                    showCompanyError(mobileInput, 'Invalid operator (must start with 013-019)');
                    errors.push('Invalid mobile operator prefix');
                    isValid = false;
                }
            }
        }

        const binInput = $(this).find('[name="bin_number"]');
        const binValue = binInput.val().trim();
        if (!binValue) {
            showCompanyError(binInput, 'BIN Number is required');
            errors.push('BIN Number is required');
            isValid = false;
        } else if (!/^[0-9]+$/.test(binValue)) {
            showCompanyError(binInput, 'BIN Number must contain only digits');
            errors.push('BIN Number must contain only digits');
            isValid = false;
        } else if (binValue.length < 6) {
            showCompanyError(binInput, 'BIN Number must be at least 6 characters');
            errors.push('Invalid BIN Number length');
            isValid = false;
        }

        const tradeInput = $(this).find('[name="trade_license_number"]');
        const tradeValue = tradeInput.val().trim();
        if (!tradeValue) {
            showCompanyError(tradeInput, 'Trade License Number is required');
            errors.push('Trade License Number is required');
            isValid = false;
        } else if (!/^[0-9]+$/.test(tradeValue)) {
            showCompanyError(tradeInput, 'Trade License Number must contain only digits');
            errors.push('Trade License Number must contain only digits');
            isValid = false;
        } else if (tradeValue.length < 6) {
            showCompanyError(tradeInput, 'Trade License Number must be at least 6 characters');
            errors.push('Invalid Trade License Number length');
            isValid = false;
        }

        const websiteInput = $(this).find('[name="website"]');
        const websiteValue = websiteInput.val().trim();
        if (websiteValue) {
            const urlPattern = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;
            if (!urlPattern.test(websiteValue)) {
                showCompanyError(websiteInput, 'Please enter a valid website URL');
                errors.push('Invalid website URL');
                isValid = false;
            }
        }

        const employeesInput = $(this).find('[name="total_employees"]');
        const employeesValue = employeesInput.val().trim();
        if (employeesValue) {
            if (isNaN(employeesValue) || parseInt(employeesValue) < 1) {
                showCompanyError(employeesInput, 'Total employees must be a valid number greater than 0');
                errors.push('Invalid total employees value');
                isValid = false;
            }
        }

        const categoryInput = $(this).find('[name="employer_company_category_id"]');
        const categoryValue = categoryInput.val();
        if (!categoryValue) {
            showCompanyError(categoryInput.next('.select2-container'), 'Please select a company category');
            errors.push('Company category is required');
            isValid = false;
        }

        const industryInput = $(this).find('[name="industry_id"]');
        const industryValue = industryInput.val();
        if (!industryValue) {
            showCompanyError(industryInput.next('.select2-container'), 'Please select an industry');
            errors.push('Industry is required');
            isValid = false;
        }

        const logoInput = $(this).find('[name="logo"]');
        if (logoInput[0].files.length > 0) {
            const file = logoInput[0].files[0];
            const fileSize = file.size / 1024 / 1024;
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                showCompanyError(logoInput, 'Logo must be a valid image file (JPEG, PNG, GIF, WEBP)');
                errors.push('Invalid logo file type');
                isValid = false;
            } else if (fileSize > 5) {
                showCompanyError(logoInput, 'Logo must be less than 5MB');
                errors.push('Logo file too large');
                isValid = false;
            }
        }

        if (!isValid) {
            displayCompanyErrorSummary(errors);
            const firstError = $('#employerCompanyEditModal .is-invalid').first();
            if (firstError.length) {
                $('#employerCompanyEditModal .modal-body, #employerCompanyEditModal .cp-modal-body').animate({
                    scrollTop: firstError.offset().top - $('#employerCompanyEditModal .cp-modal-body').offset().top + $('#employerCompanyEditModal .cp-modal-body').scrollTop() - 20
                }, 500);
            }
            return false;
        }

        this.submit();
    });

    $('#employerCompanyEditModal').on('input change', 'input, select, textarea', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').remove();
        $(this).next('.select2-container').removeClass('is-invalid');
        $(this).next('.select2-container').siblings('.invalid-feedback').remove();
        $('.company-error-summary').remove();
    });

    $('#employerCompanyEditModal').on('hidden.bs.modal', function() {
        clearCompanyErrors();
    });

    $('#employerCompanyEditModal [name="phone"]').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 11) value = value.substring(0, 11);
        $(this).val(value);
    });

    $('#employerCompanyEditModal [name="total_employees"]').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
});

function showCompanyError(element, message) {
    element.addClass('is-invalid');
    const errorDiv = $('<div class="invalid-feedback d-block"></div>').text(message);
    if (element.hasClass('select2-container')) {
        element.after(errorDiv);
    } else {
        element.after(errorDiv);
    }
}

function clearCompanyErrors() {
    $('#employerCompanyEditModal .is-invalid').removeClass('is-invalid');
    $('#employerCompanyEditModal .invalid-feedback').remove();
    $('#employerCompanyEditModal .company-error-summary').remove();
}

function displayCompanyErrorSummary(errors) {
    const summaryHtml = `
                <div class="alert alert-danger company-error-summary mb-3" style="border-radius:10px;font-size:13px;">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        ${errors.map(error => `<li>${error}</li>`).join('')}
                    </ul>
                </div>
            `;
    $('#employerCompanyEditModal .cp-modal-body').prepend(summaryHtml);
}

// Load contents on scroll
let page = 1;
let loading = false;


function loadMoreData() {
    if (loading || page >= lastPage) return;

    loading = true;
    page++;
    $("#loader").show();

    $.ajax({
        url: "?page=" + page + "&view=employer&employer_id={{ $companyDetails->id }}",
        type: "GET",
        success: function(res) {
            if (res.empty) {
                if (!$(".no-activity").length) {
                    $("#item-container").append(res.html);
                }
                $("#no-more-data").show();
                page = lastPage;
                return;
            }
            $("#item-container").append(res.html);
        },
        complete: function() {
            loading = false;
            $("#loader").hide();
        }
    });
}

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
        loadMoreData();
    }
});

// Show/hide overview
$(document).on('click', '#show-full-btn', function () {
    $('#short-overview').css('display', 'none');
    $('#long-overview').css('display', 'block');
});
$(document).on('click', '#show-less-btn', function () {
    $('#short-overview').css('display', 'block');
    $('#long-overview').css('display', 'none');
});

// Zoom plugin & AJAX modals
function sendAjaxRequest(url, method, data = {}) {
    return $.ajax({
        url: base_url + url,
        method: method,
        data: data
    })
        .done(function (data) {})
        .fail(function (error) {
            toastr.error(error);
        });
}

function showJobDetails(jobId, jobTitle = 'View Job Title') {
    sendAjaxRequest('get-job-details/' + jobId + '?render=1&show_apply=1', 'GET').then(function (response) {
        $('#viewJobModalTitle').empty().append(jobTitle);
        $('#viewJobModalBody').empty().append(response);
        $('#viewJobModal').modal('show');
    });
}

function showPostDetails(postId, postTitle = 'View Post Title') {
    sendAjaxRequest('employee-view-post/' + postId + '?render=1', 'GET').then(function (response) {
        $('#viewPostModalTitle').empty().append(postTitle);
        $('#viewPostModalBody').empty().append(response);
        $('.zoom-img').mBox();
        $('#viewPostModal').modal('show');
    });
}

$(document).on('click', '.ed-post-click', function(e) {
    e.preventDefault();
    var postId = $(this).data('post-id');
    var postTitle = $(this).data('post-title') || 'View Post';
    showPostDetails(postId, postTitle);
});
