
$(function () {

    $('.table').DataTable();

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    if (typeof toastType !== 'undefined' && toastType === 'success') {
        Toast.fire({
            icon: 'success',
            title: 'Property Inspector deleted successfully'
        });
    }
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
