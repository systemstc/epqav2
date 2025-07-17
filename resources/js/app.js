import './bootstrap';
import 'datatables.net-bs5';
// require('datatables.net-bs5');

// window.$ = window.jQuery = require('jquery');

// require('datatables.net-bs5')(); // Initialize DataTables

$(document).ready(function() {
    $('#example').DataTable(); // Initialize DataTables on your table ID
});