$(function () {
    // STEPPER SCRIPT
    let stepIndex = 0;
    let steps = $(".step");
    let stepNav = $(".stepper-nav")
    let progressBar = $("#progress-bar");
    let totalSteps = steps.length;


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

    $(".next").click(function () {
        if (stepIndex < totalSteps - 1) {
            stepIndex++;
            updateStepper();
        }
    });

    $(".prev").click(function () {
        if (stepIndex > 0) {
            stepIndex--;
            updateStepper();
        }
    });
    // END STEPPER SCRIPT

    $('.select2').select2();

    let measureTable = $('#measuresTable').DataTable();


});
