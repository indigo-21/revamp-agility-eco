$(function () {

    // Initialize DataTables
    let measuresTable = $('#measuresTable').DataTable();
    let qualificationsTable = $('#qualificationsTable').DataTable();

    function validateMeasuresFields() {
        let measureCat = $('select[name="measure_id"]').val();
        let feeValue = $('input[name="measure_fee_value"]').val();
        let expiryDate = $('input[name="measure_expiry_date"]').val();
        let fileInput = $('input[name="measure_certificate"]')[0];
        let file = fileInput.files.length > 0;

        if (measureCat && feeValue && expiryDate && file) {
            $('#addMeasures').prop('disabled', false);
        } else {
            $('#addMeasures').prop('disabled', true);
        }
    }

    function validateQualificationsFields() {
        let qualificationName = $('input[name="qualification_name"]').val();
        let issueDate = $('input[name="qualification_issue_date"]').val();
        let expiryDate = $('input[name="qualification_expiry_date"]').val();
        let fileInput = $('input[name="qualification_certificate"]')[0];
        let file = fileInput.files.length > 0;

        if (qualificationName && issueDate && expiryDate && file) {
            $('#addQualifications').prop('disabled', false);
        } else {
            $('#addQualifications').prop('disabled', true);
        }
    }

    // Check validation on input change
    $('select[name="measure_id"], input[name="measure_fee_value"], input[name="measure_expiry_date"], input[name="measure_certificate"]').on('input change', validateMeasuresFields);
    $('input[name="qualification_name"], input[name="qualification_issue_date"], input[name="qualification_expiry_date"], input[name="qualification_certificate"]').on('input change', validateQualificationsFields);

    $('#addMeasures').on('click', function () {
        let measureCat = $('select[name="measure_id"] option:selected').text();
        let feeValue = $('input[name="measure_fee_value"]').val();
        let feeCurrency = $('input[name="measure_fee_currency"]').val();
        let expiryDate = $('input[name="measure_expiry_date"]').val();

        let fileInput = $('input[name="measure_certificate"]')[0];
        let file = fileInput.files[0];
        let fileName = file ? file.name : 'No File';
        let imageTag = file ? `<img src="${URL.createObjectURL(file)}" width="auto" height="150">` : 'No File';

        // Create a new file input element and clone the file
        let clonedFileInput = `<input type="file" class="hidden-file-name-${measureCat}" style="display:none;">`;

        measuresTable.row.add([
            measureCat,
            feeValue,
            feeCurrency,
            expiryDate,
            imageTag + clonedFileInput, // Add the cloned file input
            '<button class="btn btn-danger btn-sm deleteRow">Delete</button>'
        ]).draw();

        // Assign the file to the cloned input
        let newFileInput = $(`.hidden-file-name-${measureCat}`).last()[0];
        if (file && newFileInput) {
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            newFileInput.files = dataTransfer.files;
        }

        // Clear input fields
        $('select[name="measure_id"]').val('').trigger('change');
        $('input[name="measure_fee_value"]').val('');
        $('input[name="measure_expiry_date"]').val('');
        $('input[name="measure_certificate"]').val('');

        validateMeasuresFields();
    });

    // Handle Add Button Click for Qualifications
    $('#addQualifications').on('click', function () {
        let qualificationName = $('input[name="qualification_name"]').val();
        let issueDate = $('input[name="qualification_issue_date"]').val();
        let expiryDate = $('input[name="qualification_expiry_date"]').val();
        let issue = $('input[name="qualification_issue"]').val();

        let fileInput = $('input[name="qualification_certificate"]')[0];
        let file = fileInput.files[0];
        let fileName = file ? file.name : 'No File';
        let imageTag = file ? `<img src="${URL.createObjectURL(file)}" width="auto" height="150">` : 'No File';

        // Create a new file input element and clone the file
        let clonedFileInput = `<input type="file" class="hidden-file-name-${issueDate}" style="display:none;">`;

        qualificationsTable.row.add([
            qualificationName,
            issueDate,
            expiryDate,
            imageTag + clonedFileInput, // Display image but store filename
            issue,
            '<button class="btn btn-danger btn-sm deleteRow">Delete</button>'
        ]).draw();

        // Assign the file to the cloned input
        let newFileInput = $(`.hidden-file-name-${issueDate}`).last()[0];
        if (file && newFileInput) {
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            newFileInput.files = dataTransfer.files;
        }

        // Clear input fields
        $('input[name="qualification_name"]').val('');
        $('input[name="qualification_issue_date"]').val('');
        $('input[name="qualification_expiry_date"]').val('');
        $('input[name="qualification_certificate"]').val('');
        $('input[name="qualification_issue"]').val('');

        validateQualificationsFields();
    });

    // Handle Row Deletion
    $('#measuresTable tbody, #qualificationsTable tbody').on('click', '.deleteRow', function () {
        let table = $(this).closest('table').DataTable();
        table.row($(this).parents('tr')).remove().draw();
    });

    // Initialize validation state on load
    validateMeasuresFields();
    validateQualificationsFields();

    $('input[name="charging_scheme_id"]').on('change', function () {
        if ($(this).val() == 1) {
            $("#property_visit_fee").attr('disabled', false);
            $("#property_fee_currency").attr('disabled', false);
            $("#payment_terms").attr('disabled', false);
        } else {
            $("#property_visit_fee").attr('disabled', true);
            $("#property_fee_currency").attr('disabled', true);
            $("#payment_terms").attr('disabled', true);
        }
    });

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

    bsCustomFileInput.init();

    $('.select2').select2();

    //Date picker
    $('.date').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('.select2').select2();

    $('#submitButton').on('click', (e) => {
        e.preventDefault();

        let propertyInspectorForm = $('#propertyInpectorForm');
        let formRoute = propertyInspectorForm.attr('action');
        let formData = new FormData(propertyInspectorForm[0]);

        $('#measuresTable tbody tr').each(function (index) {
            let rowData = $(this).find('td').map(function () {
                return $(this).text().trim();
            }).get();

            // Retrieve the file object from the corresponding file input
            let fileInput = $(this).find(`input[type="file"].hidden-file-name-${rowData[0]}`)[0];
            let file = fileInput ? fileInput.files[0] : null;

            if (rowData.length > 0) {
                formData.append(`measures[${index}][measure_cat]`, rowData[0]);
                formData.append(`measures[${index}][measure_fee_value]`, rowData[1]);
                formData.append(`measures[${index}][measure_fee_currency]`, rowData[2]);
                formData.append(`measures[${index}][measure_expiry_date]`, rowData[3]);

                if (file) {
                    formData.append(`measures[${index}][measure_certificate]`, file);
                }
            }
        });

        $('#qualificationsTable tbody tr').each(function (index) {
            let rowData = $(this).find('td').map(function () {
                return $(this).text().trim();
            }).get();

            // Retrieve the file object from the corresponding file input
            let fileInput = $(this).find(`input[type="file"].hidden-file-name-${rowData[1]}`)[0];
            let file = fileInput ? fileInput.files[0] : null;

            if (rowData.length > 0) {
                formData.append(`qualifications[${index}][qualification_name]`, rowData[0]);
                formData.append(`qualifications[${index}][qualification_issue_date]`, rowData[1]);
                formData.append(`qualifications[${index}][qualification_expiry_date]`, rowData[2]);
                formData.append(`qualifications[${index}][qualification_issue]`, rowData[4]); // Assuming 4th is issue

                if (file) {
                    formData.append(`qualifications[${index}][qualification_certificate]`, file);
                }
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: formRoute,
            type: 'POST',
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
                    window.location.href = '/property-inspector';
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



        // console.log(formData);
        console.log('submit');
    })

});