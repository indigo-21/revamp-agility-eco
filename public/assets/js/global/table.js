$(function () {
    $(".table").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        autoWidth: false,
        filter: true,
        "buttons": ["csv", "colvis"]
    });
});
