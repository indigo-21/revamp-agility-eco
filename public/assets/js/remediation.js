$(function () {
    $('.select2').select2();

    $(".closeJob").on("click", function () {
        const jobId = $(this).data('id');

        $('.remediation-form').attr('action', '/remediation-review/' + jobId);
    });
});
