
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>

<script>
function deleteRecord(id) {
    if(confirm("Are you sure you want to delete this record?")) {
        window.location.href = "?delete=" + id;
    }
}

function loadEditData(id) {
    $.ajax({
        url: 'fetch_record.php', // Ensure this is the path to your PHP file that fetches data by ID
        type: 'GET',
        data: {id: id},
        success: function(response) {
            var data = JSON.parse(response);
            $('#edit_id').val(data.id);
            $('#office').val(data.office);
            $('#article').val(data.article);
            $('#unit').val(data.unit);
            $('#cost').val(data.cost);
            $('#acquired').val(data.date_acquired);
            $('#counted').val(data.date_counted);
            $('#coa').val(data.coa_rep);
            $('#custod').val(data.property_cus);
            $('#propid').val(data.property_id);  // Display Property No
            $('#qrdata').val(data.serial_id);    // Display Serial No

            // Handle service status checkboxes
            if (data.service_status === 'Serviceable') {
                $('#serviceableCheck').prop('checked', true);
                $('#unserviceableCheck').prop('checked', false);
            } else {
                $('#serviceableCheck').prop('checked', false);
                $('#unserviceableCheck').prop('checked', true);
            }
        },
        error: function(error) {
            console.log("Error fetching data", error);
        }
    });
}


$(document).ready(function() {
    $('#qrTable').DataTable();
});
</script>