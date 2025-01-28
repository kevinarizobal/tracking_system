<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('link/header.php'); ?>
</head>
<body>
<?php include('link/navbar.php'); ?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>PROPERTY ACKNOWLEDGEMENT RECEIPT (PAR)</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crudModal">Create Form</button>
                    </div>
                    <table class="table table-responsive mt-4" id="crud-table">
                        <thead>
                            <tr>
                                <th>PAR No.</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Description</th>
                                <th>Property Number</th>
                                <th>Amount</th>
                                <th>Date Filed</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            include('config.php');
                            $sql = "
                                SELECT * FROM par_tb 
                                WHERE id IN (
                                    SELECT MIN(id)
                                    FROM par_tb
                                    GROUP BY property_number
                                )
                            ";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['par_no']}</td>
                                        <td>{$row['qty']}</td>
                                        <td>{$row['unit']}</td>
                                        <td>{$row['description']}</td>
                                        <td>{$row['property_number']}</td>
                                        <td>{$row['amount']}</td>
                                        <td>{$row['date_file']}</td>
                                        <td>
                                            <button class='btn btn-info btn-sm view-btn' data-id='{$row['id']}'><i class='bi bi-eye'></i></button>
                                            <a href='print_par.php?id={$row['property_number']}' target='_blank' class='btn btn-success btn-sm'><i class='bi bi-printer'></i></a>
                                            <a href='update_par.php?id={$row['id']}' class='btn btn-primary btn-sm'><i class='bi bi-pencil-square'></i></a>
                                            <a href='delete_par.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></a>
                                        </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crudModalLabel">PAR Input Fields</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="crud-form">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="entity" class="form-label">Entity</label>
                            <input type="text" class="form-control" id="entity" name="entity" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="fund-cluster" class="form-label">Fund Cluster</label>
                            <input type="text" class="form-control" id="fund-cluster" name="fund-cluster" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="par-no" class="form-label">PAR No</label>
                            <input type="text" class="form-control" id="par-no" name="par-no" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="date-acquired" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control" name="date-acquired" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="property-number" class="form-label">Property</label>
                            <input type="text" class="form-control mb-2" name="property-number" placeholder="Property Number" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="received-by" class="form-label">Received By</label>
                            <input type="text" class="form-control" id="received-by" name="received-by" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="position" class="form-label">Position/Office</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="issued-by" class="form-label">Issued By</label>
                            <input type="text" class="form-control" id="issued-by" name="issued-by" required>
                        </div>
                    </div>
                    <div id="dynamic-fields">
                        <h5>Items</h5>
                        <div class="dynamic-field mb-3">
                            <div class="row">
                                <div class="col-lg-1">
                                    <input type="text" class="form-control mb-2" name="quantity[]" placeholder="Qty" required>
                                </div>
                                <div class="col-lg-1">
                                    <input type="text" class="form-control mb-2" name="unit[]" placeholder="Unit" required>
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" required>
                                </div>
                                <div class="col-lg-2">
                                    <input type="number" class="form-control mb-2" name="amount[]" placeholder="Amount" required>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-danger removeField">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-field" class="btn btn-primary">Add Field</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">View PAR Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="related-items">
                        <tr>
                            <td colspan="4">No related items found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#crud-table').DataTable();

        // Handle "View" button click
        $(document).on('click', '.view-btn', function () {
            const id = $(this).data('id');
            $('#viewModal').modal('show');

            // Fetch details
            $.ajax({
                type: 'GET',
                url: `fetch_par_details.php?id=${id}`,
                success: function (data) {
                    const details = JSON.parse(data);
                    const detailsHTML = `
                        <p><strong>PAR No:</strong> ${details.par_no}</p>
                        <p><strong>Quantity:</strong> ${details.qty}</p>
                        <p><strong>Unit:</strong> ${details.unit}</p>
                        <p><strong>Description:</strong> ${details.description}</p>
                        <p><strong>Property Number:</strong> ${details.property_number}</p>
                        <p><strong>Amount:</strong> ${details.amount}</p>
                        <p><strong>Date Filed:</strong> ${details.date_file}</p>
                    `;
                    $('#view-par-details').html(detailsHTML);

                    // Fetch related items
                    fetchRelatedItems(details.property_number);
                },
                error: function () {
                    $('#view-par-details').html('<p>Error fetching details.</p>');
                }
            });
        });

        function fetchRelatedItems(propertyNumber) {
            $.ajax({
                type: 'GET',
                url: `fetch_related_items.php?property_number=${propertyNumber}`,
                success: function (data) {
                    const items = JSON.parse(data);
                    const relatedItemsHTML = items.map(item => {
                        console.log('Item ID:', item.id);  // Log the ID to the console
                        return `
                            <tr>
                                <td>${item.qty}</td>
                                <td>${item.unit}</td>
                                <td>${item.description}</td>
                                <td>${item.amount}</td>
                                <td>
                                    <a href="update_par.php?id=${item.id}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a href="delete_par.php?id=${item.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        `;
                    }).join('');
                    $('#related-items').html(relatedItemsHTML);
                },

                error: function () {
                    $('#related-items').html('<tr><td colspan="5">Error fetching related items.</td></tr>');
                }
            });
        }

        // Add dynamic fields
        $('#add-field').click(function () {
            const fieldHTML = `
                <div class="dynamic-field mb-3">
                    <div class="row">
                        <div class="col-lg-1">
                            <input type="text" class="form-control mb-2" name="quantity[]" placeholder="Qty" required>
                        </div>
                        <div class="col-lg-1">
                            <input type="text" class="form-control mb-2" name="unit[]" placeholder="Unit" required>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" required>
                        </div>
                        <div class="col-lg-2">
                            <input type="number" class="form-control mb-2" name="amount[]" placeholder="Amount" required>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-danger removeField">Remove</button>
                        </div>
                    </div>
                </div>`;
            $('#dynamic-fields').append(fieldHTML);
        });

        // Remove dynamic fields
        $(document).on('click', '.removeField', function () {
            $(this).closest('.dynamic-field').remove();
        });

        // Handle form submission
        $('#crud-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'insert_par.php',
                data: $(this).serialize(),
                success: function (response) {
                    alert(response);
                    $('#crudModal').modal('hide');
                },
                error: function () {
                    alert('Error occurred!');
                }
            });
        });

    });
</script>
</body>
</html>
