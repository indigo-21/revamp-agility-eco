$(function () {
    $('.table').DataTable({
        dom: 'Bfrtip',
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["csv", "colvis"]
    });

    // Initialize the DataTable and store reference
    var piJobsTable = $("#piListOfJobs").DataTable();
});

$("input[name='jobs']").on('change', function () {
    var selectedValue = $(this).val();

    // Get the existing DataTable instance
    var table = $("#piListOfJobs").DataTable();

    // Clear any existing custom search functions
    while ($.fn.dataTable.ext.search.length > 0) {
        $.fn.dataTable.ext.search.pop();
    }

    if (selectedValue == 1) {
        // Filter to show only rows where 2nd column TD ID equals 1
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                if (settings.nTable.id !== 'piListOfJobs') {
                    return true;
                }
                // Get the row node and check the ID attribute of the 2nd column (index 1)
                var row = table.row(dataIndex).node();
                var secondColumnTd = $(row).find('td').eq(1);
                var tdId = secondColumnTd.attr('id');
                return tdId == '1';
            }
        );
        table.draw();
        console.log("Filtered table for 2nd column TD ID = 1");

    } else if (selectedValue == 2) {
        // Filter to show only rows where 2nd column ID is 1 or 25
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                if (settings.nTable.id !== 'piListOfJobs') {
                    return true;
                }
                // Get the row node and check the ID attribute of the 2nd column (index 1)
                var row = table.row(dataIndex).node();
                var secondColumnTd = $(row).find('td').eq(1);
                var tdId = secondColumnTd.attr('id');
                return (tdId == '1' || tdId == '25');
            }
        );
        table.draw();
        console.log("Filtered table for 2nd column TD ID = 1 or 25");

    } else if (selectedValue == 3) {
        // Filter to show only rows where 2nd column TD ID equals 3
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                if (settings.nTable.id !== 'piListOfJobs') {
                    return true;
                }
                // Get the row node and check the ID attribute of the 2nd column (index 1)
                var row = table.row(dataIndex).node();
                var secondColumnTd = $(row).find('td').eq(1);
                var tdId = secondColumnTd.attr('id');
                return tdId == '3';
            }
        );
        table.draw();
        console.log("Filtered table for 2nd column TD ID = 3");

    } else if (selectedValue == 4) {
        // Show all data without any filter
        table.search('').columns().search('').draw();
        console.log("Showing all data - no filters applied");

    } else {
        // Default: clear all filters for any other value
        table.search('').columns().search('').draw();
        console.log("Filter cleared - default case");
    }

    // Get filtered results
    var filteredIds = [];
    table.column(1, { search: 'applied' }).nodes().to$().each(function () {
        var tdId = $(this).attr('id');
        if (tdId) {
            filteredIds.push(tdId);
        }
    });
    console.log("Filtered 2nd column IDs:", filteredIds);
    console.log("Total filtered rows:", table.rows({ search: 'applied' }).count());
});
