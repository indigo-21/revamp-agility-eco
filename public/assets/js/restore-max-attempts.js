$(".restoreMaxAttempts").on("click", function (e) {
    e.preventDefault();
    let jobId = $(this).data('id');
    const reinstateUrl = "/restore-max-attempts/" + jobId;

    Swal.fire({
        title: 'Are you sure?',
        text: "This will restore the job's max attempts.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: reinstateUrl,
                type: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire(
                        'Restored!',
                        'The job\'s max attempts have been restored successfully.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'There was an error restoring the job\'s max attempts.',
                        'error'
                    );
                }
            });
        }
    });
});