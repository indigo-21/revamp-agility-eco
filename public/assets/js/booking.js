$(function () {
    // $('#managebookings-table').DataTable({
    //     "order": [[0, "desc"]],
    //     responsive: true,
    //     autoWidth: false,
    // });

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

});

$(document).on('click', '.closeJob', function () {
    let job_number = $(this).data('job-number');

    $('#job_number_closed_job').val(job_number);
});

$(document).on('click', '.attemptMade', function () {
    let job_number = $(this).data('job-number');

    $('#job_number_attempt_made').val(job_number);
});

$(document).on('click', '.unbook-job', function (e) {
    e.preventDefault();
    const form = $(this).closest('.unbook-job-form');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will unbook the job!",
        imageUrl: '../assets/images/danger.png', // Use imageUrl instead of icon
        imageWidth: 100, // Optional: set image width
        imageHeight: 90, // Optional: set image height
        imageAlt: 'Custom delete icon', // Optional: alt text for accessibility
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, unbook it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});