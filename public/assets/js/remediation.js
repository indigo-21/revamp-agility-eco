$(function () {
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $(".closeJob").on("click", function () {
        const jobId = $(this).data('id');

        $('.remediation-form').attr('action', '/remediation-review/' + jobId);
    });
});
