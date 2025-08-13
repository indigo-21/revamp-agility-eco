$(function () {
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $(document).on("click", ".closeJob", function () {
        const jobId = $(this).data('id');

        $('.remediation-form').attr('action', '/reminder-exception/' + jobId);
    });

    $(document).on('click', '.createReminder', function () {
        const installer = $(this).data('installer');
        const jobId = $(this).data('id');


        $("#installer_id").val(installer.id);
        $("#installer_name").val(installer.user.firstname);
        $("#job_id").val(jobId);


        $('.reminder-exception').attr('action', '/reminder-exception');
    });

    bsCustomFileInput.init();


});
