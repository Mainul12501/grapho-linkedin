// Employee Settings Form Validation
$(document).ready(function() {

    // Validate Employee Settings Form on Submit
    $('#employeeSettingsModal form').on('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        clearSettingsErrors();

        let isValid = true;
        let errors = [];

        // 1. Name Validation - Required
        const nameInput = $(this).find('[name="name"]');
        const nameValue = nameInput.val().trim();

        if (!nameValue) {
            showSettingsError(nameInput, 'Full name is required');
            errors.push('Full name is required');
            isValid = false;
        } else if (nameValue.length < 3) {
            showSettingsError(nameInput, 'Full name must be at least 3 characters');
            errors.push('Full name must be at least 3 characters');
            isValid = false;
        }

        // 2. Mobile Validation - Bangladeshi format (01XXXXXXXXX - 11 digits starting with 01)
        const mobileInput = $(this).find('[name="mobile"]');
        const mobileValue = mobileInput.val().trim();

        if (!mobileValue) {
            showSettingsError(mobileInput, 'Mobile number is required');
            errors.push('Mobile number is required');
            isValid = false;
        } else {
            // Check if mobile contains only digits
            const onlyDigits = /^[0-9]+$/;
            if (!onlyDigits.test(mobileValue)) {
                showSettingsError(mobileInput, 'Mobile number must contain only digits (no text or special characters)');
                errors.push('Invalid mobile format - only digits allowed');
                isValid = false;
            }
            // Check Bangladeshi mobile format: starts with 01 and exactly 11 digits
            else if (!mobileValue.startsWith('01')) {
                showSettingsError(mobileInput, 'Bangladeshi mobile number must start with 01');
                errors.push('Mobile must start with 01');
                isValid = false;
            } else if (mobileValue.length !== 11) {
                showSettingsError(mobileInput, 'Bangladeshi mobile number must be exactly 11 digits');
                errors.push('Mobile must be 11 digits');
                isValid = false;
            }
            // Additional validation for valid BD operator prefixes
            else {
                const validPrefixes = ['013', '014', '015', '016', '017', '018', '019'];
                const prefix = mobileValue.substring(0, 3);
                if (!validPrefixes.includes(prefix)) {
                    showSettingsError(mobileInput, 'Invalid Bangladeshi mobile operator (must start with 013-019)');
                    errors.push('Invalid mobile operator prefix');
                    isValid = false;
                }
            }
        }

        // 3. Email Validation
        const emailInput = $(this).find('[name="email"]');
        const emailValue = emailInput.val().trim();

        if (emailValue) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailValue)) {
                showSettingsError(emailInput, 'Please enter a valid email address');
                errors.push('Invalid email format');
                isValid = false;
            }
        }

        // 4. Profile Image Validation
        const profileImageInput = $(this).find('[name="profile_image"]');
        if (profileImageInput[0].files.length > 0) {
            const file = profileImageInput[0].files[0];
            const fileSize = file.size / 1024 / 1024; // Convert to MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

            if (!allowedTypes.includes(file.type)) {
                showSettingsError(profileImageInput, 'Profile image must be a valid image file (JPEG, PNG, GIF, WEBP)');
                errors.push('Invalid image file type');
                isValid = false;
            } else if (fileSize > 5) {
                showSettingsError(profileImageInput, 'Profile image must be less than 5MB');
                errors.push('Image file too large');
                isValid = false;
            }
        }

        // Show error summary if validation fails
        if (!isValid) {
            displaySettingsErrorSummary(errors);

            // Scroll to first error
            const firstError = $('#employeeSettingsModal .is-invalid').first();
            if (firstError.length) {
                firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            return false;
        }

        // All validations passed - submit the form
        this.submit();
    });

    // Real-time validation - clear errors on input
    $('#employeeSettingsModal').on('input', 'input', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').remove();
        $('.settings-error-summary').remove();
    });

    // Clear errors when modal is closed
    $('#employeeSettingsModal').on('hidden.bs.modal', function() {
        clearSettingsErrors();
    });

    // Real-time mobile number formatting and validation
    $('#employeeSettingsModal [name="mobile"]').on('input', function() {
        // Remove any non-digit characters
        let value = $(this).val().replace(/\D/g, '');

        // Limit to 11 digits
        if (value.length > 11) {
            value = value.substring(0, 11);
        }

        $(this).val(value);
    });
});

// Helper function to show error for settings form
function showSettingsError(element, message) {
    element.addClass('is-invalid');

    const errorDiv = $('<div class="invalid-feedback d-block"></div>').text(message);
    element.after(errorDiv);
}

// Helper function to clear all errors in settings form
function clearSettingsErrors() {
    $('#employeeSettingsModal .is-invalid').removeClass('is-invalid');
    $('#employeeSettingsModal .invalid-feedback').remove();
    $('#employeeSettingsModal .settings-error-summary').remove();
}

// Display error summary at the top of modal body
function displaySettingsErrorSummary(errors) {
    const summaryHtml = `
        <div class="alert alert-danger settings-error-summary mb-3">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                ${errors.map(error => `<li>${error}</li>`).join('')}
            </ul>
        </div>
    `;

    $('#employeeSettingsModal .modal-body').prepend(summaryHtml);
}
