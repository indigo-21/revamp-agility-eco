
$(function () {
    if (typeof bsCustomFileInput !== 'undefined') {
        bsCustomFileInput.init();
    }

    $('.table').DataTable({
        dom: 'Bfrtip',
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["csv", "colvis"]
    });

});
