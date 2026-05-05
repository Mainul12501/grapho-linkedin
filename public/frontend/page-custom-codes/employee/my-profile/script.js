// Edit Work Experience
$(document).on('click', '.edit-work-experience', function () {
    var jobId = $(this).attr('data-work-experience-id');
    var thisObject = $(this);
    sendAjaxRequest('employee/employee-work-experiences/'+jobId+'/edit', 'GET').then(function (response) {
        $('#workExperienceEditForm').append(response);
        $('#editWorkSummaryInput').summernote({
            height: 300
        });
        $('.select2').selectize();
        $('#editWorkExperienceModal').modal('show');
    })
})

// Edit Education
$(document).on('click', '.edit-education', function () {
    var jobId = $(this).attr('data-education-id');
    var thisObject = $(this);
    sendAjaxRequest('employee/employee-educations/'+jobId+'/edit', 'GET').then(function (response) {
        $('#educationEditForm').append(response);
        $('.select2').selectize();
        $('#editEducationModal').modal('show');
    })
})

// Edit Document
$(document).on('click', '.edit-document', function () {
    var jobId = $(this).attr('data-document-id');
    sendAjaxRequest('employee/employee-documents/'+jobId+'/edit', 'GET').then(function (response) {
        $('#documentEditForm').append(response);
        $('.select2').selectize();
        $('#editDocumentModal').modal('show');
    })
})

// Change job active status
$(document).on('click', '.change-job-active-status', function () {
    var val = $(this).attr('data-value');
    var msg = $(this).attr('data-msg');
    sendAjaxRequest('employee/change-job-active-status/'+val, 'GET').then(function (response) {
        if (response.status == 'success') {
            $('#selectedRole').text(msg);
            toastr.success(response.success);
        } else {
            toastr.error('Something went wrong. Please try again.');
        }
    })
})

// Toggle institute name on education degree change
function toggleInstituteNameOnEducationDegreeChange(hasInstituteNameValue = 0) {
    if (hasInstituteNameValue == 1) {
        $('#instituteNameDiv').removeClass('d-none');
        $('#universityDiv').addClass('d-none');
        $('label[for="cgpaInput"]').text('Grade');
    } else {
        $('#universityDiv').removeClass('d-none');
        $('#instituteNameDiv').addClass('d-none');
        $('input[name="institute_name"]').val('');
        $('input[name="group_name"]').val('');
        $('label[for="cgpaInput"]').text('GPA');
    }
}

// Disable end date on current job check
$(document).on('change', '#currentJobCheck', function () {
    if ($(this).is(':checked')) {
        $('input[name="end_date"]').prop('disabled', true).val('');
    } else {
        $('input[name="end_date"]').prop('disabled', false);
    }
});

// Disable end date on current job check during edit
$(document).on('change', '#editCurrentJobCheck', function () {
    if ($(this).is(':checked')) {
        $('input[name="end_date"]').prop('disabled', true).val('');
    } else {
        $('input[name="end_date"]').prop('disabled', false);
    }
});

// Profile Image Modal - Drag Drop Crop
(function() {
    let cropper = null;
    let originalFile = null;

    const dragDropArea = document.getElementById('piDragDropArea');
    const fileInput = document.getElementById('piFileInput');
    const uploadContent = document.getElementById('piUploadContent');
    const previewContainer = document.getElementById('piPreviewContainer');
    const imagePreview = document.getElementById('piImagePreview');
    const cropControls = document.getElementById('piCropControls');
    const finalPreviewContainer = document.getElementById('piFinalPreviewContainer');
    const finalPreview = document.getElementById('piFinalPreview');
    const croppedImageData = document.getElementById('piCroppedImageData');

    dragDropArea.addEventListener('click', () => fileInput.click());
    dragDropArea.addEventListener('dragover', (e) => { e.preventDefault(); dragDropArea.classList.add('dragover'); });
    dragDropArea.addEventListener('dragleave', (e) => { e.preventDefault(); dragDropArea.classList.remove('dragover'); });
    dragDropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dragDropArea.classList.remove('dragover');
        if (e.dataTransfer.files.length > 0) handleFile(e.dataTransfer.files[0]);
    });
    fileInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

    document.getElementById('piResetCrop').addEventListener('click', (e) => { e.preventDefault(); cropper && cropper.reset(); });
    document.getElementById('piRotateLeft').addEventListener('click', (e) => { e.preventDefault(); cropper && cropper.rotate(-90); });
    document.getElementById('piRotateRight').addEventListener('click', (e) => { e.preventDefault(); cropper && cropper.rotate(90); });
    document.getElementById('piCropImage').addEventListener('click', (e) => { e.preventDefault(); handleCropImage(); });
    document.getElementById('piChangeImage').addEventListener('click', (e) => { e.preventDefault(); resetUpload(); });

    function handleFile(file) {
        if (!file.type.startsWith('image/')) { alert('Please select an image file.'); return; }
        if (file.size > 5 * 1024 * 1024) { alert('File size must be less than 5MB.'); return; }
        originalFile = file;
        const reader = new FileReader();
        reader.onload = (e) => displayImageForCropping(e.target.result);
        reader.readAsDataURL(file);
    }

    function displayImageForCropping(imageSrc) {
        uploadContent.style.display = 'none';
        previewContainer.style.display = 'block';
        cropControls.style.display = 'block';
        finalPreviewContainer.style.display = 'none';
        imagePreview.src = imageSrc;
        if (cropper) cropper.destroy();
        cropper = new Cropper(imagePreview, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.8,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    }

    function handleCropImage() {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 300, height: 300, imageSmoothingEnabled: true, imageSmoothingQuality: 'high' });
        canvas.toBlob((blob) => {
            finalPreview.src = URL.createObjectURL(blob);
            croppedImageData.value = canvas.toDataURL('image/jpeg', 0.8);
            previewContainer.style.display = 'none';
            cropControls.style.display = 'none';
            finalPreviewContainer.style.display = 'block';
        }, 'image/jpeg', 0.8);
    }

    function resetUpload() {
        if (cropper) { cropper.destroy(); cropper = null; }
        fileInput.value = '';
        croppedImageData.value = '';
        originalFile = null;
        uploadContent.style.display = 'block';
        previewContainer.style.display = 'none';
        cropControls.style.display = 'none';
        finalPreviewContainer.style.display = 'none';
    }

    document.getElementById('changeProfileImageModal').addEventListener('hidden.bs.modal', function () {
        resetUpload();
    });
})();

// Form Validation
// ============================================
// COMMON VALIDATION FUNCTIONS
// ============================================

function validateRequired(value, fieldName) {
    if (!value || value.trim() === '') {
        toastr.error(`${fieldName} is required`);
        return false;
    }
    return true;
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        toastr.error('Please enter a valid email address');
        return false;
    }
    return true;
}

function validateBDPhone(phone) {
    const phoneRegex = /^0\d{10}$/;
    if (!phoneRegex.test(phone)) {
        toastr.error('Invalid Phone Number.');
        return false;
    }
    return true;
}

function getFieldLabel($field) {
    const $label = $('label[for="' + $field.attr('id') + '"]');
    return $label.length ? $label.text().replace('*', '').trim() : $field.attr('name');
}

// ============================================
// EMPLOYEE PROFILE UPDATE FORM VALIDATION
// ============================================

function validateEmployeeProfileForm() {
    let isValid = true;
    const $form = $('#employeeUpdateProfile');

    $form.find('[required]').each(function() {
        const $field = $(this);
        const value = $field.val();
        const fieldLabel = getFieldLabel($field);

        if (!validateRequired(value, fieldLabel)) {
            isValid = false;
            $field.addClass('is-invalid');
            return false;
        } else {
            $field.removeClass('is-invalid');
        }
    });

    if (!isValid) return false;

    const email = $form.find('input[name="email"]').val();
    if (email && !validateEmail(email)) {
        $form.find('input[name="email"]').addClass('is-invalid');
        return false;
    } else {
        $form.find('input[name="email"]').removeClass('is-invalid');
    }

    const phone = $form.find('input[name="mobile"]').val();
    if (phone && !validateBDPhone(phone)) {
        $form.find('input[name="mobile"]').addClass('is-invalid');
        return false;
    } else {
        $form.find('input[name="mobile"]').removeClass('is-invalid');
    }

    return true;
}

// ============================================
// WORK EXPERIENCE FORM VALIDATION
// ============================================
function validateWorkExperienceForm($form) {
    let valid = true;

    const title = $form.find('input[name="title"]').val();
    if (!title.trim()) {
        toastr.error('Position title is required');
        valid = false;
    }

    const startDate = $form.find('input[name="start_date"]').val();
    if (!startDate) {
        toastr.error('Start date is required');
        valid = false;
    }

    const isCurrent = $form.find('input[name="is_working_currently"]').is(':checked');
    const endDate = $form.find('input[name="end_date"]').val();

    if (!isCurrent && !endDate) {
        toastr.error('End date is required if not currently working');
        valid = false;
    }

    if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
        toastr.error('End date cannot be earlier than start date');
        valid = false;
    }

    return valid;
}

// ============================================
// EDUCATION FORM VALIDATION
// ============================================
function validateEducationForm($form) {
    let valid = true;

    const degree = $form.find('[name="education_degree_name_id"]').val();
    const institute = $form.find('[name="institute_name"]').val()?.trim();
    const field = $form.find('[name="field_of_study"]').val()?.trim();
    const year = $form.find('[name="passing_year"]').val()?.trim();
    const cgpa = $form.find('[name="cgpa"]').val()?.trim();

    if (!degree) { toastr.error('Education program is required'); valid = false; }
    if (!institute) { toastr.error('Institute name is required'); valid = false; }
    else if (/\d/.test(institute)) { toastr.error('Institute name cannot contain numbers'); valid = false; }
    if (!field) { toastr.error('Field of study is required'); valid = false; }
    else if (/\d/.test(field)) { toastr.error('Field of study cannot contain numbers'); valid = false; }
    if (!year) { toastr.error('Passing year is required'); valid = false; }
    else if (!/^\d{4}$/.test(year)) { toastr.error('Passing year must be a valid year (e.g., 2022)'); valid = false; }
    if (!cgpa) { toastr.error('CGPA is required'); valid = false; }
    else if (!/^\d+(\.\d+)?$/.test(cgpa)) { toastr.error('CGPA must be a number (e.g., 3.75)'); valid = false; }

    return valid;
}

// ============================================
// FORM SUBMIT HANDLERS
// ============================================

$(document).ready(function() {

    // Employee Profile Update Form
    $('#employeeUpdateProfile').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const $submitBtn = $(this).find('button[type="submit"]');
        if (validateEmployeeProfileForm()) {
            const formData = new FormData(this);
            $submitBtn.prop('disabled', true).text('Saving...');

            const croppedData = $('#croppedImageData').val();
            if (croppedData) {
                const arr = croppedData.split(',');
                const mime = arr[0].match(/:(.*?);/)[1];
                const bstr = atob(arr[1]);
                let n = bstr.length;
                const u8arr = new Uint8Array(n);
                while (n--) { u8arr[n] = bstr.charCodeAt(n); }
                const blob = new Blob([u8arr], { type: mime });
                formData.delete('profile_image');
                formData.append('profile_image', blob, 'profile.jpg');
            }

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success('Profile updated successfully!');
                    $('#editContactModal').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).text('{{ trans("common.save_changes") }}');
                },
                error: function(xhr) {
                    toastr.error('Failed to update profile. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // Profile Image Form
    $('#profileImageForm').on('submit', function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        const croppedData = $('#piCroppedImageData').val();

        if (!croppedData) {
            toastr.error('Please select and crop an image first.');
            return;
        }

        const formData = new FormData(this);
        const arr = croppedData.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while (n--) { u8arr[n] = bstr.charCodeAt(n); }
        const blob = new Blob([u8arr], { type: mime });
        formData.delete('profile_image');
        formData.append('profile_image', blob, 'profile.jpg');

        $submitBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Profile image updated successfully!');
                $('#changeProfileImageModal').modal('hide');
                setTimeout(() => location.reload(), 1500);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).text('{{ trans("common.save_changes") }}');
            },
            error: function(xhr) {
                toastr.error('Failed to update profile image. Please try again.');
                console.error(xhr.responseText);
            }
        });
    });

    // Work Experience Form Validation
    $('#createEmployeeWorkExperienceForm').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        if (validateWorkExperienceForm($form)) {
            this.submit();
        }
    });

    $(document).on('shown.bs.modal', '#editWorkExperienceModal', function() {
        const $form = $(this).find('form#editEmployeeWorkExperienceForm');
        $form.off('submit.validate');
        $form.on('submit.validate', function(e) {
            e.preventDefault();
            if (validateWorkExperienceForm($form)) {
                this.submit();
            }
        });
    });

    // Document validation
    const allowedExt = ['pdf','jpg','jpeg','png'];

    function validateDocumentForm($form) {
        const val = (selector) => ($form.find(selector).val() || '').toString().trim();
        const title = val('[name="title"]');
        const fileInput = $form.find('[name="file"]');
        const fileVal = fileInput.val();

        $form.find('.is-invalid').removeClass('is-invalid');

        if (!title) {
            toastr.error('Please select or enter a document title');
            const $titleField = $form.find('[name="title"]').first();
            if ($titleField.length) $titleField.addClass('is-invalid');
            return false;
        }

        if (!fileVal) {
            toastr.error('Please upload a file');
            fileInput.addClass('is-invalid');
            return false;
        }

        const fileName = fileVal.split('\\').pop().split('/').pop();
        const ext = (fileName.split('.').pop() || '').toLowerCase();
        if (allowedExt.indexOf(ext) === -1) {
            toastr.error('Only PDF, JPG, JPEG or PNG files are allowed');
            fileInput.addClass('is-invalid');
            return false;
        }

        return true;
    }

    // Education Form Validation
    $('#addEducationForm').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        if (validateEducationForm($form)) {
            this.submit();
        }
    });

    $(document).on('shown.bs.modal', '#editEducationModal', function() {
        const $form = $(this).find('form#editEducationForm');
        $form.off('submit.validateEducation');
        $form.on('submit.validateEducation', function(e) {
            e.preventDefault();
            if (validateEducationForm($form)) {
                this.submit();
            }
        });
    });

    // Document submit handler
    $(document).on('submit', '#createEmployeeDocuments, #editEmployeeDocuments', function (e) {
        e.preventDefault();
        const $form = $(this);
        if ($form.data('submitting')) {
            $form.removeData('submitting');
            return true;
        }
        if (!validateDocumentForm($form)) {
            return false;
        }
        $form.data('submitting', true);
        $form[0].submit();
    });

    // Remove invalid state dynamically
    $(document).on('input change', 'input, select, textarea', function () {
        $(this).removeClass('is-invalid');
    });
});

// Show profile edit btn on mobile
$(document).on('click', '#showMobileProfileEditBox', function (event) {
    event.preventDefault();
    $('.viewoProfileforSmallDevice').addClass('d-none');
    $('.profileEdit').addClass('d-block');
});
