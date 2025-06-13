$(function () {
    $("#remediationReviewTable").DataTable(
        {
            responsive: true,
            autoWidth: false,
            filter: true,
        }
    );

});


$(".editComments").on('click', function () {
    const { id, comments } = $(this).data('completed-job-data');
    $("#updateCommentForm").attr("action", `/update-survey-comment/${id}`);
    $("#comments").val(comments);

    // console.log(id, comments);
});

$(".passFail").on('click', function () {
    const { id, pass_fail } = $(this).data('completed-job-data');
    $utvAllowed = $(this).data('utv-allowed');
    $naAllowed = $(this).data('na-allowed');

    $("#updatePassFail").attr("action", `/update-survey-pass-fail/${id}`);

    $("#pass_fail").empty();

    const options = [
        { value: "Passed", label: "Passed" },
        { value: "Non-Compliant", label: "Non-Compliant" }
    ];

    if ($utvAllowed) {
        options.push({ value: "Unable to Validate", label: "Unable to Validate" });
    }
    if ($naAllowed) {
        options.push({ value: "N/A", label: "N/A" });
    }

    options.forEach(opt => {
        const selected = pass_fail === opt.value ? 'selected' : '';
        $("#pass_fail").append(`<option value="${opt.value}" ${selected}>${opt.label}</option>`);
    });
});
