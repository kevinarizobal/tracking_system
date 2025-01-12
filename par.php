<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD with DataTable and Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">CRUD with DataTable and Modal</h2>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add New</button>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>PAR No</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'config.php';
            $sql = "SELECT * FROM par_tb";
            $result = $conn->query($sql);
            $num = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $num++ . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['par_no'] . "</td>
                            <td>
                                <button class='btn btn-warning btn-sm editBtn'>Edit</button>
                                <button class='btn btn-danger btn-sm deleteBtn'>Delete</button>
                            </td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    <div class="mb-3">
                        <label for="entity_name" class="form-label">Entity Name</label>
                        <input type="text" class="form-control" name="entity_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="fund_cluster" class="form-label">Fund Cluster</label>
                        <input type="text" class="form-control" name="fund_cluster" required>
                    </div>
                    <div class="mb-3">
                        <label for="par_no" class="form-label">PAR No.</label>
                        <input type="text" class="form-control" name="par_no" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" name="unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="property_number" class="form-label">Property Number</label>
                        <input type="text" class="form-control" name="unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_acquired" class="form-label">Date Acquired</label>
                        <input type="date" class="form-control" name="date_acquired" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>
                    <!-- Description Field - Multiple Input Text Fields -->
                    <div id="descriptionField">
                        <div class="mb-3 row align-items-center">
                            <div class="col-10">
                                <label for="description[]" class="form-label">Description</label>
                                <input type="text" class="form-control" name="description[]" required>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-danger removeField">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addMoreDescription" class="btn btn-secondary mb-3">Add More Description</button>

                    <!-- Other fields here -->
                    <div class="mb-3">
                        <label for="date_file" class="form-label">Date File</label>
                        <input type="date" class="form-control" name="date_file" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();

    // Add More Description Fields
    $('#addMoreDescription').click(function() {
        $('#descriptionField').append(
            '<div class="mb-3 row align-items-center">' +
            '<div class="col-10">' +
            '<label for="description[]" class="form-label">Description</label>' +
            '<input type="text" class="form-control" name="description[]" required>' +
            '</div>' +
            '<div class="col-2">' +
            '<button type="button" class="btn btn-danger removeField">Remove</button>' +
            '</div>' +
            '</div>'
        );
    });

    // Remove Description Field
    $(document).on('click', '.removeField', function() {
        $(this).closest('.mb-3').remove();
    });

    // Add Form Submit
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "insert_par.php",
            data: $(this).serialize(),
            success: function(response) {
                $('#addModal').modal('hide');
                location.reload();
            }
        });
    });

    // Edit Button Click
    $('.editBtn').on('click', function() {
        $('#editModal').modal('show');
        var data = $(this).closest('tr').children("td").map(function() {
            return $(this).text();
        }).get();
        $('#editId').val(data[0]);
        $('#editName').val(data[1]);
    });

    // Edit Form Submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "update_par.php",
            data: $(this).serialize(),
            success: function(response) {
                $('#editModal').modal('hide');
                location.reload();
            }
        });
    });

    // Delete Button Click
    $('.deleteBtn').on('click', function() {
        var id = $(this).closest('tr').find('td:first').text();
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                type: "POST",
                url: "delete_par.php",
                data: {id: id},
                success: function(response) {
                    location.reload();
                }
            });
        }
    });
});
</script>
</body>
</html>