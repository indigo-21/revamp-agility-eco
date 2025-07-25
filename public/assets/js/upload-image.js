// $(function () {
//     $("#uploadImageTable").DataTable(
//         {
//             responsive: true,
//             autoWidth: false,
//             filter: false,
//             info: false,
//             paging: false,
//             ordering: false,
//         }
//     );

// });

$('.deleteImage').on('click', function () {
    const completedJobId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will remove the image from the survey.",
        imageUrl: '../assets/images/danger.png', // Use imageUrl instead of icon
        imageWidth: 100, // Optional: set image width
        imageHeight: 90, // Optional: set image height
        imageAlt: 'Custom delete icon', // Optional: alt text for accessibility
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // include the CSRF token in the AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/delete-survey-photo',
                type: 'POST',
                data: {
                    completed_job_photo_id: completedJobId,
                },
                success: function (response) {
                    Swal.fire(
                        'Deleted!',
                        'The image has been removed from the survey.',
                        'success'
                    );
                    // setTimeout(function () {
                    $("#uploadImageTable").find('tr[data-id="image-' + completedJobId + '"]').remove();
                    // }, 2000);
                },
                error: function (xhr, status, error) {
                    console.error("There was an error with the request: ", status, error);
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the image.',
                        'error'
                    );
                }
            });
        }
    });
});

$(function () {

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/upload-survey-photo", // Set the url
        paramName: "photo", // <--- add this line
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        uploadMultiple: true,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })

    myDropzone.on("addedfile", function (file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function () { myDropzone.enqueueFile(file) }
    })

    myDropzone.on("sendingmultiple", function (files, xhr, formData) {
        formData.append("completed_job_id", $('#updateSurveyContent').data('id'));
        formData.append("filepath", $('#updateSurveyContent').data('filepath'));
    });

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function (progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })

    myDropzone.on("sending", function (file, xhr, formData) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function () {
        document.querySelector("#total-progress").style.opacity = "0";

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'info',
            title: 'Please wait while the image is being processed.'
        })

        setTimeout(function () {
            location.reload();
        }, 2000);
    })

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function () {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function () {
        myDropzone.removeAllFiles(true)
    }
    // DropzoneJS Demo Code End
});