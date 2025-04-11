$(function () {
    $("#installerConfigurationTable").DataTable();
    //Initialize Select2 Elements
    $('.select2').select2();
});

let clientTable = $("#installerClientTable").DataTable({
    "bLengthChange": false,
});
let clientsArray = [];

$("#submitBtn").on("click", function(e) {
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
        success: function(data) {
            console.log(data);   
        },
        error: function(xhr, status, error) {
            console.error("There was an error with the request: ", status, error);  // Handle errors
            console.error(xhr.responseText);
        }
    });
});

$("#addClient").on("click", function() {
    let clientData = {
        dataId: Math.floor(Math.random() * 100) + 1,
        suffic: $('#client').val(),
        client: $('#client option:selected').text(),
        tmln:   $("#tmln").val(),
    };

    clientTable.row.add([
        clientData.suffic,
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
     
$(document).on("click", ".deleteClient", function() {
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


    


