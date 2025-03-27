$(document).ready(function () {
    var form = $("#example-advanced-form").show();

    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        autoAdjustHeight: true,
        stepsOrientation: "vertical",
        onStepChanging: function (event, currentIndex, newIndex) {

            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex) {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex) {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        // onStepChanged: function (event, currentIndex, priorIndex) {

        //     // Used to skip the "Warning" step if the user is old enough.
        //     if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
        //         form.steps("next");
        //     }
        //     // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        //     // if (currentIndex === 2 && priorIndex === 4) {
        //     //     console.log('test');
        //     //     form.steps("previous");
        //     // }
        // },     
        onFinishing: function (event, currentIndex) {

            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            alert("Submitted!");
            // $('.content input[type="text"]').val('');
            // $('.content input[type="email"]').val('');
            // $('.content input[type="password"]').val('');
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) {

            element.before(error);
        },
        rules: {
            confirm: {
                equalTo: "#password-2"
            }
        }
    });

    $('.filer_input').filer({
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
        changeInput: true,
        showThumbs: true,
    });

    $(".js-example-basic-single").select2();

    $("#measureCertificate").filer({
        limit: 3,
        maxSize: 3,
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
        changeInput: true,
    });

    $("#qualificationCertificate").filer({
        limit: 3,
        maxSize: 3,
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
        changeInput: true,
    });
    

    // Initialize DataTable
    const measureTable = $('#measureTable').DataTable({
        "dom": 'frtip',
        searching: false,
    });

    // Function to validate inputs
    function validateInputs() {
        const measureCat = $('#measureCatSelect').val();
        const feeValue = $('#measureFeeValue').val();
        const feeCurrency = $('#measureFeeCurrency').val();
        const expiryDate = $('#measureExpiryDate').val();
        const certificate = $('#measureCertificate').val();

        if (measureCat && feeValue && feeCurrency && expiryDate && certificate) {
            $('#measureDataAdd').prop('disabled', false);
        } else {
            $('#measureDataAdd').prop('disabled', true);
        }
    }

    // Attach input change events for validation
    $('#measureCatSelect, #measureFeeValue, #measureFeeCurrency, #measureExpiryDate, #measureCertificate').on('input change', validateInputs);

    // Add button functionality
    $('#measureDataAdd').on('click', function (e) {
        e.preventDefault();

        // Get input values
        const measureCat = $('#measureCatSelect').val();
        const feeValue = $('#measureFeeValue').val();
        const feeCurrency = $('#measureFeeCurrency').val();
        const expiryDate = $('#measureExpiryDate').val();
        const certificate = $('#measureCertificate').val().split('\\').pop();

        // Create an image element for the uploaded file
        const certificateImage = `<img src="${URL.createObjectURL($('#measureCertificate')[0].files[0])}" alt="${certificate}" style="width: 50px; height: auto;">`;

        // Add new row to the DataTable
        measureTable.row.add([
            measureCat,
            feeValue,
            feeCurrency,
            expiryDate,
            certificateImage,
            `<button class="btn btn-danger btn-sm delete-row">Delete</button>`
        ]).draw();

        // Clear input fields
        $('#measureFeeValue').val('');
        $('#measureExpiryDate').val('');
        $('#measureCertificate').prop("jFiler").reset();
        $('#measureCatSelect').val('AL').trigger('change');

        // Disable the add button after clearing inputs
        validateInputs();


        // Fetch data from measureTable
        const measureTableData = measureTable.rows().data();
        measureTableData.each(function (value, index) {
            console.log(`Row ${index}:`, value);
        });

    });

    // Delete row functionality
    $('#measureTable').on('click', '.delete-row', function () {
        measureTable.row($(this).closest('tr')).remove().draw();
    });

    // Initial validation check
    validateInputs();

    // Initialize DataTable for qualifications
    const qualificationsTable = $('#qualificationsTable').DataTable({
        "dom": 'frtip',
        searching: false
    });

    // Function to validate qualification inputs
    function validateQualificationInputs() {
        const qualificationName = $('#qualificationName').val();
        const issueDate = $('#qualificationIssueDate').val();
        const expiryDate = $('#qualificationExpiryDate').val();
        const certificate = $('#qualificationCertificate').val();
        const issue = $('#qualificationIssue').val();

        if (qualificationName && issueDate && expiryDate && certificate && issue) {
            $('#qualificationAdd').prop('disabled', false);
        } else {
            $('#qualificationAdd').prop('disabled', true);
        }
    }

    // Attach input change events for qualification validation
    $('#qualificationName, #qualificationIssueDate, #qualificationExpiryDate, #qualificationCertificate, #qualificationIssue').on('input change', validateQualificationInputs);

    // Add button functionality for qualifications
    $('#qualificationAdd').on('click', function (e) {
        e.preventDefault();

        // Get input values
        const qualificationName = $('#qualificationName').val();
        const issueDate = $('#qualificationIssueDate').val();
        const expiryDate = $('#qualificationExpiryDate').val();
        const certificate = $('#qualificationCertificate').val().split('\\').pop();
        const issue = $('#qualificationIssue').val();

        // Create an image element for the uploaded file
        const certificateImage = `<img src="${URL.createObjectURL($('#qualificationCertificate')[0].files[0])}" alt="${certificate}" style="width: 50px; height: auto;">`;

        // Add new row to the DataTable
        qualificationsTable.row.add([
            qualificationName,
            issueDate,
            expiryDate,
            certificateImage,
            issue,
            `<button class="btn btn-danger btn-sm delete-row">Delete</button>`
        ]).draw();

        // Clear input fields
        $('#qualificationName').val('');
        $('#qualificationIssueDate').val('');
        $('#qualificationExpiryDate').val('');
        $('#qualificationCertificate').prop("jFiler").reset();
        $('#qualificationIssue').val('');

        // Disable the add button after clearing inputs
        validateQualificationInputs();


        // Fetch data from qualificationsTable
        const qualificationsTableData = qualificationsTable.rows().data();
        qualificationsTableData.each(function (value, index) {
            console.log(`Row ${index}:`, value);
        });
    });

    // Delete row functionality for qualifications
    $('#qualificationsTable').on('click', '.delete-row', function () {
        qualificationsTable.row($(this).closest('tr')).remove().draw();
    });

    // Initial validation check for qualifications
    validateQualificationInputs();
});