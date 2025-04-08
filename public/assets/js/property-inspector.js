$(function () {
    $("#propertyInspectorList").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["csv", "excel", "colvis"]
    }).buttons().container().appendTo('#propertyInspectorList .col-md-6:eq(0)');
});