
$(function () {

    $('.select2').select2();

    $('.table').DataTable({
        "order": [[0, "desc"]],
        responsive: true,
        autoWidth: false,
        filter: true,
    });

    bsCustomFileInput.init();

    $('#client_id').on('change', function () {
        $.ajax({
            url: '/client/search-job-types',
            type: 'GET',
            data: {
                client_id: $(this).val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#job_type_id').empty();
                $('#job_type_id').append('<option value="" disabled selected> - Select Job Type - </option>');
                $.each(data[0].client_job_type, function (key, value) {
                    console.log(value);
                    $('#job_type_id').append('<option value="' + value.job_type.id + '">' + value.job_type.type + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error("There was an error with the request: ", status, error);  // Handle errors
                console.error(xhr.responseText);
            }
        })
    });

    // var Toast = Swal.mixin({
    //     toast: true,
    //     position: 'top-end',
    //     showConfirmButton: false,
    //     timer: 3000
    // });

    // if (typeof toastType !== 'undefined' && toastType === 'success') {
    //     Toast.fire({
    //         icon: 'success',
    //         title: 'Property Inspector deleted successfully'
    //     });
    // }
});

// $(document).on('click', '.delete-btn', function (e) {
//     e.preventDefault();
//     const form = $(this).closest('.delete-form');

//     Swal.fire({
//         title: 'Are you sure?',
//         text: "You won't be able to revert this!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             form.submit();
//         }
//     });
// });
