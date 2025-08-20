//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
})

$('.invoiceBtn').on('click', function () {
    let jobId = $(this).data('id');

    Swal.fire({
        title: 'Account Reconciliation',
        text: "This job will be invoiced",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Invoice'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: `account-reconciliation/${jobId}`,
                type: "PUT",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // console.log(response);
                        window.location.href = "/account-reconciliation";
                    });

                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to invoice the job. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });


});