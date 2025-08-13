$(document).ready(function () {
    // STEPPER SCRIPT
    let stepIndex = 0;
    let steps = $(".step");
    let stepNav = $(".stepper-nav")
    let progressBar = $("#progress-bar");
    let totalSteps = steps.length;

    $('.next').on('click', function () {
        // Get the current active step
        const currentStep = steps.eq(stepIndex);
        console.log('Current step:', currentStep);
        const stepId = currentStep.attr('id');
        let allValid = true;
        let validationContainer = currentStep.find('.validation-row');

        if (validationContainer.length === 0) {
            validationContainer = currentStep;
        }

        const selectInputs = validationContainer.find('select[required], input[required]');
        // console.log('Validating step:', stepId, 'Found required inputs:', selectInputs.length);

        selectInputs.each(function () {
            if (!$(this).val() || $(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                // console.log('Validation failed for required field: ', $(this).attr('name') || $(this).attr('id') || 'unknown field');
                allValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Only proceed if all fields are valid
        if (allValid && stepIndex < totalSteps - 1) {
            stepIndex++;
            updateStepper();
        }
    });

    function updateStepper() {
        steps.removeClass("active-step").eq(stepIndex).addClass("active-step");
        progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
        progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
        progressBar.text("Step " + (stepIndex + 1));
        stepNav.removeClass("btn-primary")
            .addClass("btn-outline-primary")
            .eq(stepIndex)
            .removeClass("btn-outline-primary")
            .addClass("btn-primary");

    }

    $(".prev").click(function () {
        if (stepIndex > 0) {
            stepIndex--;
            updateStepper();
        }
    });
    // END STEPPER SCRIPT
});