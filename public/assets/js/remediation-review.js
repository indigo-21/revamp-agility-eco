$(function () {
    let pendingRedirectUrl = null;

    const successPrompt = () => {
        $("#comment").val("");
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "info",
            title: "Please wait while the form is being processed.",
        });

        setTimeout(function () {
            location.reload();
        }, 1200);
    };

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(document.body, {
        // Make the whole body a dropzone
        url: "/store-remediation", // Set the url
        paramName: "files", // <--- add this line
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        uploadMultiple: true,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    });

    myDropzone.on("addedfile", function (file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function () {
            myDropzone.enqueueFile(file);
        };
    });

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function (progress) {
        document.querySelector("#total-progress .progress-bar").style.width =
            progress + "%";
    });

    myDropzone.on("sendingmultiple", function (files, xhr, formData) {
        formData.append("comment", $("#comment").val());
        formData.append("user", "Agent");
        formData.append("completedJobId", $("#completedJobId").val());
        formData.append("jobId", $("#jobId").val());
    });

    myDropzone.on("successmultiple", function (files, response) {
        if (response && response.redirect) {
            pendingRedirectUrl = response.redirect;
        }
    });

    myDropzone.on("sending", function (file, xhr, formData) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1";
        // And disable the start button
        file.previewElement
            .querySelector(".start")
            .setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function () {
        document.querySelector("#total-progress").style.opacity = "0";
        myDropzone.removeAllFiles(true);

        successPrompt();
    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function () {
        if (myDropzone.getAcceptedFiles().length > 0) {
            myDropzone.enqueueFiles(
                myDropzone.getFilesWithStatus(Dropzone.ADDED),
            );
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "This will be uploaded to the remediation without any files.",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, proceed without files!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content",
                            ),
                        },
                    });

                    $.ajax({
                        url: "/store-remediation",
                        type: "POST",
                        data: {
                            comment: $("#comment").val(),
                            user: "Agent",
                            completedJobId: $("#completedJobId").val(),
                            jobId: $("#jobId").val(),
                        },
                        success: function (response) {
                            if (response && response.redirect) {
                                pendingRedirectUrl = response.redirect;
                            }

                            successPrompt();
                        },
                        error: function (xhr, status, error) {
                            console.error(
                                "There was an error with the request: ",
                                status,
                                error,
                            );
                            Swal.fire(
                                "Error!",
                                "There was an error deleting the image.",
                                "error",
                            );
                        },
                    });
                }
            });

            // Swal.fire({
            //     icon: 'warning',
            //     title: 'No files selected',
            //     text: 'Please add files before starting the upload.'
            // })
        }
    };
    // document.querySelector("#actions .cancel").onclick = function () {
    //     myDropzone.removeAllFiles(true)
    // }
    // DropzoneJS Demo Code End
});

$(".remediation").on("click", function () {
    const buttonText = $(this).text().trim();
    const value = $(this).data("value");

    Swal.fire({
        title: "Are you sure?",
        text: "The remediation history will be with " + buttonText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Submit",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
            });

            $.ajax({
                url: "/store-remediation",
                type: "POST",
                data: {
                    comment: $("#comment").val(),
                    user: "Agent",
                    completedJobId: $("#completedJobId").val(),
                    jobId: $("#jobId").val(),
                    remediationType: value,
                },
                success: function (response) {
                    Swal.fire(
                        "Success!",
                        "The job has been marked as remediation.",
                        "success", 
                    ).then(() => {
                        location.reload();
                        // console.log(response);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(
                        "There was an error with the request: ",
                        status,
                        error,
                    );
                    Swal.fire(
                        "Error!",
                        "There was an error marking the job as remediation.",
                        "error",
                    );
                },
            });
        }
    });
});
