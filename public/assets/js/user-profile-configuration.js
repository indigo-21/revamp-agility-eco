$(function () {
    // Initialize Select2 after DOM is ready
    initializeSelect2();

    // Re-initialize Select2 if DataTable is being used
    if ($.fn.DataTable) {
        $(document).on('draw.dt', function () {
            initializeSelect2();
        });
    }


    // Handle navigation select changes using event delegation
    $(document).on("change", "select[name='navigation']", function () {
        account_level_id = $(this).data('account_level');
        navigation_id = $(this).data('navigation');
        selectedValue = $(this).val();
        type = "navigation";
        updatePermissions($(this));

        submit(navigation_id, selectedValue, account_level_id, type);
    });

    // Handle permission radio button changes using event delegation
    $(document).on("change", ".radioPermission", function () {
        account_level_id = $(this).data('account_level');
        navigation_id = $(this).data('navigation');
        selectedValue = $(this).val();
        type = "permission";
        
        submit(navigation_id, selectedValue, account_level_id, type);
    });

    // Firm Data only toggle (Firm Admin / Firm Agent)
    $(document).on("change", "#firm_data_only", function () {
        account_level_id = $(this).data('account_level');
        selectedValue = $(this).is(':checked') ? 1 : 0;
        type = "firm_data_only";

        submit('firm-data-only', selectedValue, account_level_id, type);
    });
});

function initializeSelect2() {
    // Initialize Select2 with custom configuration
    $('.select2bs4').select2({
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
            successPrompt(response);
        },
        error: function (xhr, status, error) {
            // Handle error response
            alert('Error saving configuration: ' + error);
        }
    });
}

const successPrompt = (response) => {
  
    let toastElement    = document.querySelectorAll('.toast');
    let lastToast       = toastElement[toastElement.length - 1];
    let {message, data} = response;
    let subtitle        = "";

    if (data.type === 'firm_data_only') {
        subtitle = String(data.selectedValue) === "1" ? "Enabled" : "Disabled";
    } else {
        switch (data.selectedValue) {
            case "1":
                subtitle = "Viewing";
                break;
            case "2":
                subtitle = "View/Add/Edit";
                break;
            case "3":
                subtitle = "View/Add/Edit/Delete";
                break;
        
            default:
                subtitle = "No Access";
                break;
        }
    }


        $(document).Toasts('create', {
            class: 'bg-info',
            title: data.type === 'firm_data_only' ? "Firm Data only" : "Permission",
            subtitle: subtitle,
            body: message,
        })

        
        setTimeout(() => {
             if (lastToast) {
                lastToast.classList.remove("show"); // removes 'show' class
            }
        }, 3000);
       
}

const updatePermissions = (element) => {
    let canAccess = element.val() == 1;
    let parent = element.closest("tr");
    let radio = parent.find(".radioPermission");

    radio.first().attr("checked", canAccess);
    if(!canAccess){
        radio.attr("checked", false);
    }
    
}