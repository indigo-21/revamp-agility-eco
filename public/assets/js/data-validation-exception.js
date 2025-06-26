$(function () {
    let jobNumbers = [];
    const table = $("#dataValidationExceptionTable").DataTable({
        responsive: true,
        autoWidth: false,
        filter: true,
    });

    table.on('click', 'tbody tr', function (e) {
        const isSelected = e.currentTarget.classList.toggle('selected');
        const rowData = table.row(this).data();
        const firstColumnValue = rowData[0];
        if (isSelected && rowData) {
            if (!jobNumbers.includes(firstColumnValue)) {
                jobNumbers.push(firstColumnValue);
            }
        } else if (!isSelected) {
            jobNumbers = jobNumbers.filter(jobNumber => jobNumber !== firstColumnValue);
        }
    });


    $("#reimportBtn").click(function (e) {
        e.preventDefault();
        const reimportForm = $("#reimportForm");

        Swal.fire({
            title: 'Are you sure?',
            text: "This will reimport the data validation exception.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reimport it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/data-validation-exception',
                    type: 'POST',
                    data: {
                        jobNumbers: jobNumbers,
                    },
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
                            console.log(response);
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'An error occurred while reimporting.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
                reimportForm.submit();
            }
        });
    });

});
