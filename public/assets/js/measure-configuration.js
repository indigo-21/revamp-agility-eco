$(function () {
    $('.table').DataTable({
        dom: 'Bfrtip',
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["csv", "colvis"]
    });

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
});


