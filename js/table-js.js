$(document).ready( function () {
    $('#dataTable').DataTable( {
  "pageLength": 50
} ).order( [ 1, 'desc' ] ).draw();
} );

// filter table
function selectPayer() {
    var val = $("#selectPayer option:selected").text();
    var table = $('#dataTable').DataTable();
    if (val=='All'){
        table.search( '' ).draw();
    }
    else
    {
        table.search( val ).draw();
    }
}