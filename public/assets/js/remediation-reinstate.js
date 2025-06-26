$(".reinstateJob").on("click", function (e) {
    e.preventDefault();
    let jobId = $(this).data('id');
    const reinstateUrl = "/remediation-reinstate/" + jobId;

    Swal.fire({
        title: 'Are you sure?',
        text: "This will reinstate the job.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reinstate it!'
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
                        'Reinstated!',
                        'The job has been reinstated successfully.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });

                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'There was an error reinstating the job.',
                        'error'
                    );
                }
            });
        }
    });
});