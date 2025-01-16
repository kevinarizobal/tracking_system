
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

$(document).ready(function() {
    $('#crud-table').DataTable();
});
</script>

<script>
// Initialize DataTable
$(document).ready(function() {
  var table = $('#userTable').DataTable({
    "ajax": "fetch_users.php", // Fetch data from the backend
    "columns": [
      {
        "data": null,
        "render": function(data, type, row, meta) {
          // UserID will be displayed incrementally here
          return meta.row + 1; // `meta.row` gives the current row index starting from 0
        }
      },
      { "data": "email" },
      { "data": "username" },
      { "data": "fullname" },
      { "data": "role" },
      { "data": "status" },
      {
        "data": null,
        "render": function(data, type, row) {
          return `
            <button class="btn btn-info btn-sm edit-btn" data-id="${row.userid}" data-email="${row.email}" data-username="${row.username}" data-fullname="${row.fullname}" data-role="${row.role}" data-status="${row.status}">Edit</button>
            <button class="btn btn-danger btn-sm delete-btn" data-id="${row.userid}">Delete</button>
          `;
        }
      }
    ]
  });

  // Handle Add User Form Submission
  $('#addUserForm').on('submit', function(e) {
    e.preventDefault();
    let formData = {
      email: $('#email').val(),
      username: $('#username').val(),
      fullname: $('#fullname').val(),
      password: md5($('#password').val()), // MD5 encryption
      role: $('#role').val(),
      status: $('#status').val(),
    };

    $.post('add_user.php', formData, function(response) {
      if (response.success) {
        $('#addModal').modal('hide');
        table.ajax.reload();
      }
    }, 'json');
  });

  // Handle Edit Button Click
  $('#userTable').on('click', '.edit-btn', function() {
    // Get user data from the button's data attributes
    const userId = $(this).data('id');
    const email = $(this).data('email');
    const username = $(this).data('username');
    const fullname = $(this).data('fullname');
    const role = $(this).data('role');
    const status = $(this).data('status');

    // Set the data into the Edit User Modal fields
    $('#editUserId').val(userId);
    $('#editEmail').val(email);
    $('#editUsername').val(username);
    $('#editFullname').val(fullname);
    $('#editRole').val(role);
    $('#editStatus').val(status);
    
    // Show the Edit Modal
    $('#editModal').modal('show');
  });

  // Handle Edit User Form Submission
  $('#editUserForm').on('submit', function(e) {
    e.preventDefault();

    let formData = {
      userId: $('#editUserId').val(),
      email: $('#editEmail').val(),
      username: $('#editUsername').val(),
      fullname: $('#editFullname').val(),
      password: $('#editPassword').val() ? md5($('#editPassword').val()) : '', // If password is empty, do not include it
      role: $('#editRole').val(),
      status: $('#editStatus').val(),
    };

    $.post('edit_user.php', formData, function(response) {
      if (response.success) {
        $('#editModal').modal('hide');
        table.ajax.reload();
      } else {
        alert('Failed to update user.');
      }
    }, 'json');
  });

  // Handle Delete
  $('#userTable').on('click', '.delete-btn', function() {
    let userId = $(this).data('id');
    if (confirm('Are you sure you want to delete this user?')) {
      $.post('delete_user.php', { userid: userId }, function(response) {
        if (response.success) {
          table.ajax.reload();
        }
      }, 'json');
    }
  });
});
</script>


