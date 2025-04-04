$(function () {

    $("#clientConfigurationTable").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
           "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "columnDefs": [
                        { className: "vertical-center", targets: [0, 1, 2, 3, 4, 5, 6] } // Apply to columns 0, 1, 2, and 3
                     ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    $("#clientMeasureTable").DataTable();
    $("#clientJobStatusTable").DataTable();




    // STEPPER SCRIPT
    let stepIndex   = 0;
    let steps       = $(".step");
    let stepNav     = $(".stepper-nav")
    let progressBar = $("#progress-bar");
    let totalSteps  = steps.length;
    

    function updateStepper() {
        steps.removeClass("active-step").eq(stepIndex).addClass("active-step");
        progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
        progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
        progressBar.text("Step " + (stepIndex + 1));
        stepNav.removeClass("btn-primary").addClass("btn-outline-primary").eq(stepIndex).removeClass("btn-outline-primary").addClass("btn-primary");
        
    }

        $(".next").click(function () {
            let formID      = $(this).attr("formid");
            let errorCount  = validateForm(formID);
            if (errorCount < 1 &&(stepIndex < totalSteps - 1)) {
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

    //Initialize Select2 Elements
    $('.select2').select2()

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

});


