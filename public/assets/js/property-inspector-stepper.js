$(function () {

    function setImagePreview({ inputSelector, imgSelector, placeholderSelector, metaSelector, label }) {
        let input = document.querySelector(inputSelector);
        if (!input) {
            return;
        }

        input.addEventListener('change', function () {
            let img = document.querySelector(imgSelector);
            let placeholder = document.querySelector(placeholderSelector);
            let meta = document.querySelector(metaSelector);

            if (!img || !placeholder || !meta) {
                return;
            }

            let file = input.files && input.files.length ? input.files[0] : null;

            if (!file) {
                let existingLocation = meta.getAttribute('data-existing-location') || '';
                if (existingLocation) {
                    placeholder.style.display = 'none';
                    img.style.display = '';
                } else {
                    img.style.display = 'none';
                    placeholder.style.display = '';
                }
                return;
            }

            img.src = URL.createObjectURL(file);
            img.style.display = '';
            placeholder.style.display = 'none';
            meta.textContent = `Selected: ${file.name}`;
        });
    }

    // Initialize DataTables
    let measuresTable = $('#measuresTable').DataTable();
    let qualificationsTable = $('#qualificationsTable').DataTable();

    let measureRowCounter = 0;
    let qualificationRowCounter = 0;
    const getMeasureFileKey = () => {
        measureRowCounter += 1;
        return `measure-${Date.now()}-${measureRowCounter}`;
    };

    const getQualificationFileKey = () => {
        qualificationRowCounter += 1;
        return `qualification-${Date.now()}-${qualificationRowCounter}`;
    };

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
        let measureId = $('select[name="measure_id"]').val();
        let measureCat = $('select[name="measure_id"] option:selected').text();
        let feeValue = $('input[name="measure_fee_value"]').val();
        let feeCurrency = $('input[name="measure_fee_currency"]').val();
        let expiryDate = $('input[name="measure_expiry_date"]').val();

        let fileInput = $('input[name="measure_certificate"]')[0];
        let file = fileInput.files[0];
        let fileName = file ? file.name : 'No File';
        let imageTag = file ? `<img src="${URL.createObjectURL(file)}" width="auto" height="150">` : 'No File';

        const fileKey = getMeasureFileKey();
        // Create a new file input element and clone the file
        let clonedFileInput = `<input type="file" class="hidden-measure-file-${fileKey}" style="display:none;">`;

        let rowNode = measuresTable.row.add([
            measureCat,
            feeValue,
            feeCurrency,
            expiryDate,
            imageTag + clonedFileInput, // Add the cloned file input
            '<button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>'
        ]).draw().node();

        $(rowNode)
            .attr('data-measure-id', measureId || '')
            .attr('data-pi-measure-id', '')
            .attr('data-file-key', fileKey);

        // Assign the file to the cloned input
        let newFileInput = $(`.hidden-measure-file-${fileKey}`)[0];
        if (file && newFileInput) {
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            newFileInput.files = dataTransfer.files;
        }

        // Clear input fields
        $('select[name="measure_id"]').val('').trigger('change');
        $('input[name="measure_fee_value"]').val('');
        $('input[name="measure_expiry_date"]').val('');

        let measureCertInput = $('input[name="measure_certificate"]');
        measureCertInput.val('');
        measureCertInput.trigger('change');
        let measureCertLabel = measureCertInput.closest('.custom-file').find('.custom-file-label');
        if (measureCertLabel.length) {
            measureCertLabel.text('Choose file');
        }

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

        const fileKey = getQualificationFileKey();
        // Create a new file input element and clone the file
        let clonedFileInput = `<input type="file" class="hidden-qualification-file-${fileKey}" style="display:none;">`;

        let rowNode = qualificationsTable.row.add([
            qualificationName,
            issueDate,
            expiryDate,
            imageTag + clonedFileInput, // Display image but store filename
            issue,
            '<button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>'
        ]).draw().node();

        $(rowNode)
            .attr('data-pi-qualification-id', '')
            .attr('data-file-key', fileKey);

        // Assign the file to the cloned input
        let newFileInput = $(`.hidden-qualification-file-${fileKey}`)[0];
        if (file && newFileInput) {
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            newFileInput.files = dataTransfer.files;
        }

        // Clear input fields
        $('input[name="qualification_name"]').val('');
        $('input[name="qualification_issue_date"]').val('');
        $('input[name="qualification_expiry_date"]').val('');

        let qualificationCertInput = $('input[name="qualification_certificate"]');
        qualificationCertInput.val('');
        qualificationCertInput.trigger('change');
        let qualificationCertLabel = qualificationCertInput.closest('.custom-file').find('.custom-file-label');
        if (qualificationCertLabel.length) {
            qualificationCertLabel.text('Choose file');
        }

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

    // $('input[name="charging_scheme_id"]').on('change', function () {
    //     if ($(this).val() == 1) {
    //         $("#property_visit_fee").attr('disabled', false);
    //         $("#property_fee_currency").attr('disabled', false);
    //         $("#payment_terms").attr('disabled', false);
    //     } else {
    //         $("#property_visit_fee").attr('disabled', true);
    //         $("#property_fee_currency").attr('disabled', true);
    //         $("#payment_terms").attr('disabled', true);
    //     }
    // });

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

    bsCustomFileInput.init();

    setImagePreview({
        inputSelector: '#photo',
        imgSelector: '#photoPreviewImg',
        placeholderSelector: '#photoPreviewPlaceholder',
        metaSelector: '#photoPreviewMeta',
        label: 'Photo'
    });

    setImagePreview({
        inputSelector: '#id_badge',
        imgSelector: '#idBadgePreviewImg',
        placeholderSelector: '#idBadgePreviewPlaceholder',
        metaSelector: '#idBadgePreviewMeta',
        label: 'ID Badge'
    });

    //Date picker
    $('.date').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $('#submitButton').on('click', (e) => {
        e.preventDefault();

        let propertyInspectorForm = $('#propertyInpectorForm');
        let formRoute = propertyInspectorForm.attr('action');
        let formMethod = propertyInspectorForm.attr('method');
        let formData = new FormData(propertyInspectorForm[0]);

        // Use DataTables API to get ALL measures data, not just visible rows
        let measureIndex = 0;
        measuresTable.rows().every(function () {
            let rowData = this.data();
            let rowNode = this.node();
            if (!rowData || rowData.length === 0 || !rowNode) {
                return;
            }

            let $row = $(rowNode);
            let measureId = $row.attr('data-measure-id');
            let piMeasureId = $row.attr('data-pi-measure-id');
            let fileKey = $row.attr('data-file-key');

            // Extract text content from HTML elements if needed
            let measureCat = typeof rowData[0] === 'string' ? rowData[0].replace(/<[^>]*>/g, '').trim() : rowData[0];
            let feeValue = typeof rowData[1] === 'string' ? rowData[1].replace(/<[^>]*>/g, '').trim() : rowData[1];
            let feeCurrency = typeof rowData[2] === 'string' ? rowData[2].replace(/<[^>]*>/g, '').trim() : rowData[2];
            let expiryDate = typeof rowData[3] === 'string' ? rowData[3].replace(/<[^>]*>/g, '').trim() : rowData[3];

            formData.append(`measures[${measureIndex}][measure_cat]`, measureCat);
            formData.append(`measures[${measureIndex}][measure_id]`, measureId || '');
            formData.append(`measures[${measureIndex}][measure_fee_value]`, feeValue);
            formData.append(`measures[${measureIndex}][measure_fee_currency]`, feeCurrency);
            formData.append(`measures[${measureIndex}][measure_expiry_date]`, expiryDate);

            if (piMeasureId) {
                formData.append(`measures[${measureIndex}][pi_measure_id]`, piMeasureId);
            }

            if (fileKey) {
                let fileInput = $(`.hidden-measure-file-${fileKey}`)[0];
                let file = fileInput ? fileInput.files[0] : null;
                if (file) {
                    formData.append(`measures[${measureIndex}][measure_certificate]`, file);
                }
            }

            measureIndex += 1;
        });

        // Use DataTables API to get ALL qualifications data, not just visible rows
        let qualificationIndex = 0;
        qualificationsTable.rows().every(function () {
            let rowData = this.data();
            let rowNode = this.node();
            if (!rowData || rowData.length === 0 || !rowNode) {
                return;
            }

            let $row = $(rowNode);
            let piQualificationId = $row.attr('data-pi-qualification-id');
            let fileKey = $row.attr('data-file-key');

            // Extract text content from HTML elements if needed
            let qualificationName = typeof rowData[0] === 'string' ? rowData[0].replace(/<[^>]*>/g, '').trim() : rowData[0];
            let issueDate = typeof rowData[1] === 'string' ? rowData[1].replace(/<[^>]*>/g, '').trim() : rowData[1];
            let expiryDate = typeof rowData[2] === 'string' ? rowData[2].replace(/<[^>]*>/g, '').trim() : rowData[2];
            let issue = typeof rowData[4] === 'string' ? rowData[4].replace(/<[^>]*>/g, '').trim() : rowData[4];

            formData.append(`qualifications[${qualificationIndex}][qualification_name]`, qualificationName);
            formData.append(`qualifications[${qualificationIndex}][qualification_issue_date]`, issueDate);
            formData.append(`qualifications[${qualificationIndex}][qualification_expiry_date]`, expiryDate);
            formData.append(`qualifications[${qualificationIndex}][qualification_issue]`, issue);

            if (piQualificationId) {
                formData.append(`qualifications[${qualificationIndex}][pi_qualification_id]`, piQualificationId);
            }

            if (fileKey) {
                let fileInput = $(`.hidden-qualification-file-${fileKey}`)[0];
                let file = fileInput ? fileInput.files[0] : null;
                if (file) {
                    formData.append(`qualifications[${qualificationIndex}][qualification_certificate]`, file);
                }
            }

            qualificationIndex += 1;
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
                    window.location.href = '/property-inspector';
                }, 1500);
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