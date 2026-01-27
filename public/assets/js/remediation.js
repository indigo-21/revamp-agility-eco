$(function () {
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $(document).on("click", ".closeJob", function () {
        const actionUrl = $(this).data('url');
        const jobId = $(this).data('id');

        if (actionUrl) {
            $('.remediation-form').attr('action', actionUrl);
            return;
        }

        if (jobId) {
            $('.remediation-form').attr('action', '/remediation-review/' + jobId);
        }
    });
});
