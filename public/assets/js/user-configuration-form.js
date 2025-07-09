$('.select2').select2();

bsCustomFileInput.init();

// Password validation
$(document).ready(function () {
    const passwordInput = $('#password');
    const confirmPasswordInput = $('#password_confirmation');

    // Password requirements validation
    passwordInput.on('input keyup', function () {
        const password = $(this).val();
        validatePassword(password);
    });

    // Confirm password validation
    confirmPasswordInput.on('input keyup', function () {
        const password = passwordInput.val();
        const confirmPassword = $(this).val();
        validatePasswordMatch(password, confirmPassword);
    });

    function validatePassword(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
        };

        // Update requirement indicators
        updateRequirement('length-req', requirements.length);
        updateRequirement('uppercase-req', requirements.uppercase);
        updateRequirement('lowercase-req', requirements.lowercase);
        updateRequirement('number-req', requirements.number);
        updateRequirement('special-req', requirements.special);

        // Calculate password strength
        const validCount = Object.values(requirements).filter(Boolean).length;
        updatePasswordStrength(validCount, password.length > 0);
    }

    function updateRequirement(elementId, isValid) {
        const element = $('#' + elementId);
        if (isValid) {
            element.addClass('valid');
            element.find('i').removeClass('fa-times text-danger').addClass('fa-check text-success');
        } else {
            element.removeClass('valid');
            element.find('i').removeClass('fa-check text-success').addClass('fa-times text-danger');
        }
    }

    function updatePasswordStrength(validCount, hasPassword) {
        const strengthBar = $('#password-strength-bar');
        const strengthText = $('#password-strength-text');

        if (!hasPassword) {
            strengthBar.removeClass().addClass('password-strength-bar');
            strengthText.text('');
            return;
        }

        strengthBar.removeClass();
        strengthBar.addClass('password-strength-bar');

        switch (validCount) {
            case 0:
            case 1:
                strengthBar.addClass('strength-weak');
                strengthText.text('Weak').css('color', '#dc3545');
                break;
            case 2:
            case 3:
                strengthBar.addClass('strength-fair');
                strengthText.text('Fair').css('color', '#fd7e14');
                break;
            case 4:
                strengthBar.addClass('strength-good');
                strengthText.text('Good').css('color', '#ffc107');
                break;
            case 5:
                strengthBar.addClass('strength-strong');
                strengthText.text('Strong').css('color', '#28a745');
                break;
        }
    }

    function validatePasswordMatch(password, confirmPassword) {
        const confirmInput = confirmPasswordInput.closest('.form-group');

        if (confirmPassword.length === 0) {
            confirmInput.removeClass('has-error');
            confirmInput.find('.invalid-feedback').remove();
            return;
        }

        if (password !== confirmPassword) {
            confirmInput.addClass('has-error');
            if (!confirmInput.find('.invalid-feedback').length) {
                confirmInput.append('<div class="invalid-feedback d-block">Passwords do not match</div>');
            }
            confirmPasswordInput.addClass('is-invalid');
        } else {
            confirmInput.removeClass('has-error');
            confirmInput.find('.invalid-feedback').remove();
            confirmPasswordInput.removeClass('is-invalid').addClass('is-valid');
        }
    }

    // Form submission validation
    // $('form').on('submit', function (e) {
    //     const password = passwordInput.val();
    //     const confirmPassword = confirmPasswordInput.val();

    //     // Check if password meets all requirements
    //     const requirements = {
    //         length: password.length >= 8,
    //         uppercase: /[A-Z]/.test(password),
    //         lowercase: /[a-z]/.test(password),
    //         number: /[0-9]/.test(password),
    //         special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
    //     };

    //     const allValid = Object.values(requirements).every(Boolean);
    //     const passwordsMatch = password === confirmPassword;

    //     if (!allValid || !passwordsMatch) {
    //         e.preventDefault();
    //         if (!allValid) {
    //             Swal.fire({
    //                 title: 'Password Requirements Not Met',
    //                 text: 'Please ensure your password meets all requirements before submitting.',
    //                 icon: 'warning',
    //                 confirmButtonColor: '#3085d6',
    //                 confirmButtonText: 'OK'
    //             });
    //         } else if (!passwordsMatch) {
    //             Swal.fire({
    //                 title: 'Passwords Do Not Match',
    //                 text: 'Please make sure both password fields contain the same value.',
    //                 icon: 'error',
    //                 confirmButtonColor: '#3085d6',
    //                 confirmButtonText: 'OK'
    //             });
    //         }
    //     }
    // });

    $("#resetpassword").on("click", function () {
        userId = $(this).data("id");
        Swal.fire({
            title: 'Reset Password',
            text: 'Are you sure you want to reset the password for this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.isConfirmed) {
                if (userId) {
                    $.ajax({
                        url: `/user-configuration/${userId}/reset-password`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#3085d6'
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: xhr.responseJSON.message || 'An error occurred while resetting the password.',
                                icon: 'error',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'User ID is not available.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            }
        });
    }
    );
});
