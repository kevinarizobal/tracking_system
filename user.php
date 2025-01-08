<!DOCTYPE html>
<html lang="en">
<?php include('link/header.php');?>
<body>
<?php include('link/navbar.php');?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>User Management</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0"></h5>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-database-add"></i> Add User</button>
                    </div>
                    <table id="userTable" class="display">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Dynamic rows will be added here via PHP and AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addUserForm">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" required>
          </div>
          <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" required>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" required>
              <option value="Admin">Admin</option>
              <option value="User">User</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm">
          <input type="hidden" id="editUserId">
          <div class="mb-3">
            <label for="editEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="editEmail" required>
          </div>
          <div class="mb-3">
            <label for="editUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="editUsername" required>
          </div>
          <div class="mb-3">
            <label for="editFullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="editFullname" required>
          </div>
          <div class="mb-3">
            <label for="editPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="editPassword">
          </div>
          <div class="mb-3">
            <label for="editRole" class="form-label">Role</label>
            <select class="form-select" id="editRole" required>
              <option value="Admin">Admin</option>
              <option value="Staff">Staff</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editStatus" class="form-label">Status</label>
            <select class="form-select" id="editStatus" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('link/script.php');?>

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


</body>
</html>
