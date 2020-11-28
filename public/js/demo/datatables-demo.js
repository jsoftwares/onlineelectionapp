// Call the dataTables jQuery plugin
$(document).ready(function() {
    $.noConflict();
    $('#dataTable').DataTable();
    $('#dataTable-poll').DataTable();
    $('#dataTable-company').DataTable();
    $('#dataTable-event').DataTable();
});