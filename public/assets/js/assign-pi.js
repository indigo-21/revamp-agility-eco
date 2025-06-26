$(".viewDetails").on("click", function () {
    let piId = $(this).data("id");

    $('.allocatePi').attr('data-id', piId);
    $('.viewPi').attr('href', '/property-inspector/' + piId);

    $.ajax({
        url: "/pi/details/" + piId,
        type: "GET",
        data: {
            piId: piId
        },
        success: function (response) {

            $('.custom').attr('hidden', false);
            $('.default').attr('hidden', true);

            $('.widget-user-username').html(response.user.firstname + " " + response.user.lastname);
            $('.widget-user-desc').html(response.user.account_level.name);
            let bookedJobs = 0;
            let unbookedJobs = 0;
            let otherJobs = 0;

            response.job.forEach(job => {
                if (job.job_status_id === 1) {
                    bookedJobs++;
                } else if (job.job_status_id === 25) {
                    unbookedJobs++;
                } else {
                    otherJobs++;
                }
            });

            if (response.user.photo !== null) {
                $('.widget-user-image').html(
                    `<img class="img-circle elevation-2" style="width: 90px; height: 90px; object-fit: cover;" src="/storage/profile_images/${response.user.photo}" alt="User Avatar">`
                );
            } else {
                $('.widget-user-image').html(
                    ` <h6
                        style="background-color: #e7493a; color: #fff; border-radius: 50%; height: 90px; width: 90px;display: flex; align-items: center; justify-content: center; margin-bottom: 0; font-size: 2rem;">
                        ${response.user.firstname.charAt(0).toUpperCase()}${response.user.lastname.charAt(0).toUpperCase()}
                    </h6>`
                );
            }

            $('.bookedJobs').html(bookedJobs);
            $('.unbookedJobs').html(unbookedJobs);
            $('.otherJobs').html(otherJobs);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching PI details:", error);
            alert("Failed to load PI details. Please try again later.");
        }
    });

});

$('.allocatePi').on('click', function () {
    let piId = $(this).data('id');
    let jobNumber = $(this).data('job-number');

    Swal.fire({
        title: 'Are you sure?',
        text: "This job will be allocated to the selected Property Inspector.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Allocate'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/property-inspector-exception",
                type: "POST",
                data: {
                    piId: piId,
                    jobNumber: jobNumber,
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
                        // console.log(response);
                        window.location.href = "/property-inspector-exception";
                    });

                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to allocate Property Inspector. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });


});