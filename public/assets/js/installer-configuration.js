$(function () {
    $("#installerConfigurationTable").DataTable();

    // Initialize Select2 Elements only if they exist
    if ($('.select2').length > 0) {
        $('.select2').select2();
    }

    // Initialize Swal Toast only if Swal is defined
    if (typeof Swal !== 'undefined') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if (typeof toastType !== 'undefined' && toastType === 'success') {
            Toast.fire({
                icon: 'success',
                title: toastMessage
            });
        }
    }
});

$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();
    const form = $(this).closest('.delete-form');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

let clientTable = $("#installerClientTable").DataTable({
    "bLengthChange": false,
});
let clientsArray = [];

$("#submitBtn").on("click", function (e) {
    e.preventDefault();
    let installerForm = $('#installerForm');
    let formRoute = installerForm.attr('action');
    let formData = new FormData(installerForm[0]);

    formData.append('clientsArray', JSON.stringify(clientsArray));

    $.ajax({
        url: formRoute,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
        },
        error: function (xhr, status, error) {
            console.error("There was an error with the request: ", status, error);  // Handle errors
            console.error(xhr.responseText);
        }
    });
});

$("#addClient").on("click", function () {
    let clientData = {
        dataId: Math.floor(Math.random() * 100) + 1,
        suffix: $('#client').val(),
        client: $('#client option:selected').text(),
        tmln: $("#tmln").val(),
    };

    clientTable.row.add([
        clientData.suffix,
        clientData.client,
        clientData.tmln,
        ` <button type="button" class="btn bg-gradient-danger deleteClient" data-id="${clientData.dataId}">
          <i class="fa fa-trash-alt" aria-hidden="true"></i>
        </button>`,
    ]).draw();

    clientsArray.push(clientData);
    $('#tmln').val('');
    $('#client').val(null).trigger('change');
    // console.log(clientsArray);
});

$(document).on("click", ".deleteClient", function () {
    let dataId = $(this).data('id');
    let row = $(this).closest('tr');

    clientTable.row(row).remove().draw();
    clientsArray = clientsArray.filter(client => client.dataId !== dataId);
    // console.log(clientsArray); 
});

function clearForm() {
    $('#input').val('');
    $('#submit').val(null).trigger('change');
}





