// Call the dataTables jQuery plugin
$(document).ready(function() {
    $.noConflict();
    $('#dataTable').DataTable();
    $('#dataTable-attendee').DataTable();
    $('#dataTable-poll').DataTable();
    $('#dataTable-company').DataTable();
    $('#dataTable-event').DataTable();
});