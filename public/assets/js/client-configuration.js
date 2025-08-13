$(function () {


    $("#clientConfigurationTable").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "columnDefs": [
            { className: "vertical-center", targets: [0, 1, 2, 3, 4, 5, 6] } // Apply to columns 0, 1, 2, and 3
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        const form = $(this).closest('.delete-form');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            imageUrl: '../assets/images/danger.png', // Use imageUrl instead of icon
            imageWidth: 100, // Optional: set image width
            imageHeight: 90, // Optional: set image height
            imageAlt: 'Custom delete icon', // Optional: alt text for accessibility
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        // Get current URL and add query parameters
        var url = new URL(window.location.href);
        var params = new URLSearchParams(formData);

        // Clear existing parameters
        url.search = '';

        // Add new parameters
        params.forEach(function (value, key) {
            if (value) {
                url.searchParams.append(key, value);
            }
        });

        // Reload the page with new parameters
        window.location.href = url.toString();
    });
});



