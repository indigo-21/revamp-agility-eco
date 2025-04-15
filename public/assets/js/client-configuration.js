$(function () {
    

    $("#clientConfigurationTable").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "columnDefs": [
                        { className: "vertical-center", targets: [0, 1, 2, 3, 4, 5, 6] } // Apply to columns 0, 1, 2, and 3
                    ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    //Initialize Select2 Elements
    $('.select2').select2();
});



