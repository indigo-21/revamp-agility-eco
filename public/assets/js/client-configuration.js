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
});



