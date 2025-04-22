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

    $('#client_id').on('change', function () {
        $.ajax({
            url: '/client/search-job-types',
            type: 'GET',
            data: {
                client_id: $(this).val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#job_type_id').empty();
                $('#job_type_id').append('<option value="" disabled selected> - Select Job Type - </option>');
                $.each(data[0].client_job_type, function (key, value) {
                    console.log(value);
                    $('#job_type_id').append('<option value="' + value.job_type.id + '">' + value.job_type.type + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error("There was an error with the request: ", status, error);  // Handle errors
                console.error(xhr.responseText);
            }
        })
    });

    $('.select2').select2();

    let measuresTable = $('#measuresTable').DataTable();

    function validateMeasuresFields() {
        let measureCat = $('select[name="measure_id"]').val();
        let umr = $('input[name="umr"]').val();
        let info = $('input[name="info"]').val();

        if (measureCat && umr && info) {
            $('#addMeasures').prop('disabled', false);
        } else {
            $('#addMeasures').prop('disabled', true);
        }
    }

    // Attach validation to input changes
    $('select[name="measure_id"], input[name="umr"], input[name="info"]').on('input change', validateMeasuresFields);

    $('#addMeasures').on('click', function () {
        let measureCat = $('select[name="measure_id"] option:selected').text();
        let umr = $('input[name="umr"]').val();
        let info = $('input[name="info"]').val();

        // Calculate job_suffix as a two-digit number based on the row count
        let job_suffix = String(measuresTable.rows().count() + 1).padStart(2, '0');

        measuresTable.row.add([
            job_suffix,
            umr,
            measureCat,
            info,
            '<button class="btn btn-danger btn-sm deleteRow" type="button">Delete</button>'
        ]).draw();

        // Clear input fields
        $('select[name="measure_id"]').val('').trigger('change');
        $('input[name="umr"]').val('');
        $('input[name="info"]').val('');

        // Revalidate fields after clearing
        validateMeasuresFields();
    });

    // Initial validation on page load
    validateMeasuresFields();

    // Handle Row Deletion
    $('#measuresTable tbody').on('click', '.deleteRow', function () {
        let table = $(this).closest('table').DataTable();
        table.row($(this).parents('tr')).remove().draw();
    });

    $('#submitButton').on('click', (e) => {
        e.preventDefault();

        let jobForm = $('#jobForm');
        let formRoute = jobForm.attr('action');
        let formMethod = jobForm.attr('method');
        let formData = new FormData(jobForm[0]);

        $('#measuresTable tbody tr').each(function (index) {
            let rowData = $(this).find('td').map(function () {
                return $(this).text().trim();
            }).get();

            if (rowData.length > 0) {
                formData.append(`measures[${index}][job_suffix]`, rowData[0]);
                formData.append(`measures[${index}][umr]`, rowData[1]);
                formData.append(`measures[${index}][measure_cat]`, rowData[2]);
                formData.append(`measures[${index}][info]`, rowData[3]);
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
                console.log('Form submitted successfully:', response);

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
                    window.location.href = '/job';
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

    });

});
