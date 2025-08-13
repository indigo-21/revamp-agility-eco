$(function () {
    //Initialize Elements Plugin
    $('.duallistbox').bootstrapDualListbox()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    //End Initialize Elements Plugin

    var roles = ["QAI", "Assessor", "Surveyor"];
    roles.forEach(function (id) {
        $("#" + id).on('change', function () {
            $("#" + id.toLowerCase() + "_visit_duration").attr('disabled', !this.checked);
        });
    });

    // // STEPPER SCRIPT
    // let stepIndex = 0;
    // let steps = $(".step");
    // let stepNav = $(".stepper-nav")
    // let progressBar = $("#progress-bar");
    // let totalSteps = steps.length;


    // function updateStepper() {
    //     steps.removeClass("active-step").eq(stepIndex).addClass("active-step");
    //     progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
    //     progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
    //     progressBar.text("Step " + (stepIndex + 1));
    //     stepNav.removeClass("btn-primary")
    //         .addClass("btn-outline-primary")
    //         .eq(stepIndex)
    //         .removeClass("btn-outline-primary")
    //         .addClass("btn-primary");

    // }

    // $(".next").click(function () {
    //     if (stepIndex < totalSteps - 1) {
    //         stepIndex++;
    //         updateStepper();
    //     }
    // });

    // $(".prev").click(function () {
    //     if (stepIndex > 0) {
    //         stepIndex--;
    //         updateStepper();
    //     }
    // });
    // // END STEPPER SCRIPT

    function validateMeasuresFields() {
        let measureCat = $('select[name="measure_id"]').val();
        let measure_fee_value = $('input[name="measure_fee_value"]').val();

        if (measureCat && measure_fee_value) {
            $('#addMeasures').prop('disabled', false);
        } else {
            $('#addMeasures').prop('disabled', true);
        }
    }

    $('select[name="measure_id"], input[name="measure_fee_value"]').on('input change', validateMeasuresFields);

    let clientMeasureTable = $('#clientMeasureTable').DataTable();

    $('#addMeasures').on('click', function () {
        let measureCat = $('select[name="measure_id"] option:selected').text();
        let measure_fee_value = $('input[name="measure_fee_value"]').val();
        let measure_fee_currency = $('input[name="measure_fee_currency"]').val();

        clientMeasureTable.row.add([
            measureCat,
            measure_fee_value,
            measure_fee_currency,
            '<button class="btn btn-danger btn-sm deleteRow" type="button">Delete</button>'
        ]).draw();

        // Clear input fields
        $('select[name="measure_id"]').val('').trigger('change');
        $('input[name="measure_fee_value"]').val('');

        // Revalidate fields after clearing
        validateMeasuresFields();
    });

    // Initial validation on page load
    validateMeasuresFields();

    $('#clientMeasureTable tbody').on('click', '.deleteRow', function () {
        let table = $(this).closest('table').DataTable();
        table.row($(this).parents('tr')).remove().draw();
    });


    $('#submitButton').on('click', (e) => {
        e.preventDefault();

        let clientForm = $('#clientConfigurationForm');
        let formRoute = clientForm.attr('action');
        let formMethod = clientForm.attr('method');
        let formData = new FormData(clientForm[0]);

        $('#clientMeasureTable tbody tr').each(function (index) {
            let rowData = $(this).find('td').map(function () {
                return $(this).text().trim();
            }).get();

            if (rowData.length > 0) {
                formData.append(`measures[${index}][measure_cat]`, rowData[0]);
                formData.append(`measures[${index}][measure_fee_value]`, rowData[1]);
                formData.append(`measures[${index}][measure_fee_currency]`, rowData[2]);
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: formRoute,
            type: formMethod,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response.message);
                // console.log('Form submitted successfully:', response);

                // Remove the alert if it exists
                $('#formAlert').removeClass('alert-danger').addClass('d-none').empty();

                // Optionally show a success alert
                $('#formAlert')
                    .removeClass('d-none')
                    .addClass('alert alert-success')
                    .text('Form submitted successfully! Please wait...');

                // Hide the success message after a few seconds
                setTimeout(() => {
                    $('#formAlert').addClass('d-none').removeClass('alert alert-success').empty();
                    window.location.href = '/client-configuration';
                }, 1000);
            },
            error: function (xhr, status, error) {
                console.error('Form submission failed:', error);

                let alertBox = $('#formAlert');
                alertBox.removeClass().addClass('alert alert-danger').empty();

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    let errorList = '<ul class="mb-0">';
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errors[field].forEach(function (message) {
                                errorList += `<li>${message}</li>`;
                            });
                        }
                    }
                    errorList += '</ul>';
                    alertBox.html(errorList);
                } else {
                    alertBox.text('Something went wrong. Please try again.');
                }
            }
        });

        console.log('submitted!');
    });

});



