var table;
 
jQuery(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
		"pageLength": 5,
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "organisasi/ajax_list",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,1,2,3 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
  
});
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function loadUrl(newLocation)
{
  window.location = newLocation;
  return false;
}