$(function () {
    // Initialize Select2 after DOM is ready
    initializeSelect2();

    // Re-initialize Select2 if DataTable is being used
    if ($.fn.DataTable) {
        $(document).on('draw.dt', function () {
            initializeSelect2();
        });
    }


    // Handle navigation select changes (these are select elements, not inputs)
    $("select[name='navigation']").on("change", function () {
        account_level_id = $(this).data('account_level');
        navigation_id = $(this).data('navigation');
        selectedValue = $(this).val();
        type = "navigation";

        submit(navigation_id, selectedValue, account_level_id, type);
    });

    // Handle permission radio button changes
    $(".radioPermission").on("change", function () {
        account_level_id = $(this).data('account_level');
        navigation_id = $(this).data('navigation');
        selectedValue = $(this).val();
        type = "permission";

        submit(navigation_id, selectedValue, account_level_id, type);
    });
});

function initializeSelect2() {
    // Initialize Select2 with custom configuration
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        minimumResultsForSearch: Infinity // Disable search for simple dropdowns
    });
}

function submit(navigation_id, selectedValue = null, account_level_id = null, type = null) {
    $.ajax({
        url: `/user-profile-configuration/${navigation_id}`,
        type: 'PUT',
        data: {
            selectedValue: selectedValue,
            account_level_id: account_level_id,
            type: type
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            // Handle error response
            alert('Error saving configuration: ' + error);
        }
    });
}