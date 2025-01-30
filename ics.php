<?php
include('config.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('link/header.php');?>
</head>
<body>
<?php include('link/navbar.php');?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>INVENTORY CUSTODIAN SLIP (ICS)</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crudModal">Create Form</button>
                    </div>
                    <table class="table table-responsive mt-4" id="crud-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Fund Cluster</th>
                                <th>ICS No.</th>
                                <th>Received From</th>
                                <th>Position/Office</th>
                                <th>Received Date</th>
                                <th>Received By</th>
                                <th>Position/Office</th>
                                <th>Received Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            include('config.php');
                            $i = 1;
                            $sql = "
                                SELECT * FROM ics_tb 
                                WHERE id IN (
                                    SELECT MIN(id)
                                    FROM ics_tb
                                    GROUP BY item_no
                                )
                            ";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                $no = $i++;
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['entity_name']}</td>
                                        <td>{$row['fund_cluster']}</td>
                                        <td>{$row['ics_no']}</td>
                                        <td>{$row['receive_by']}</td>
                                        <td>{$row['role1']}</td>
                                        <td>{$row['receivefrom_date']}</td>
                                        <td>{$row['issue_by']}</td>
                                        <td>{$row['role2']}</td>
                                        <td>{$row['receiveby_date']}</td>
                                        <td>
                                            <button class='btn btn-info btn-sm view-btn' data-id='{$row['id']}'><i class='bi bi-eye'></i></button>
                                            <a href='print_ics.php?id={$row['item_no']}' target='_blank' class='btn btn-success btn-sm'><i class='bi bi-printer'></i></a>
                                            <a href='update_ics.php?id={$row['id']}' class='btn btn-primary btn-sm'><i class='bi bi-pencil-square'></i></a>
                                            <a href='delete_ics.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></a>
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

<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crudModalLabel">ICS Input Fields</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="crud-form">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="entity" class="form-label">Entity</label>
                            <input type="text" class="form-control" id="entity" name="entity" value="NEMSU Cantilan Campus" readonly>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="fund-cluster" class="form-label">Fund Cluster</label>
                            <input type="text" class="form-control" id="fund-cluster" name="fund-cluster" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="par-no" class="form-label">ICS No</label>
                            <input type="text" class="form-control" id="par-no" name="par-no" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="received-by" class="form-label">Received By</label>
                            <input type="text" class="form-control" id="received-by" name="received-by" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="role1" class="form-label">Position/Office</label>
                            <input type="text" class="form-control" id="role1" name="role1" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="received-by" class="form-label">Date Receive</label>
                            <input type="date" class="form-control" id="receive-date" name="receive-date" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="issued-by" class="form-label">Issued By</label>
                            <input type="text" class="form-control" id="issued-by" name="issued-by" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="role2" class="form-label">Position/Office</label>
                            <input type="text" class="form-control" id="role2" name="role2" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="issue-by" class="form-label">Date Receive</label>
                            <input type="date" class="form-control" id="issue-date" name="issue-date" required>
                        </div>
                    </div>
                    <div id="dynamic-fields">
                        <h5>Items</h5>
                        <div class="dynamic-field mb-3">
                            <div class="row">
                                <div class="col-1">
                                    <input type="text" class="form-control mb-2" name="quantity[]" placeholder="Qty" required>
                                </div>
                                <div class="col-1">
                                    <input type="text" class="form-control mb-2" name="unit[]" placeholder="Unit" required>
                                </div>
                                <div class="col-1">
                                    <input type="number" class="form-control mb-2" name="cost[]" placeholder="Unit Cost" required>
                                </div>
                                <div class="col-1">
                                    <input type="number" class="form-control mb-2" name="amount[]" placeholder="Total Cost" required>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" required>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control mb-2" name="item-number[]" placeholder="Inventory No" required>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control mb-2" name="estimate[]" placeholder="Estimated Life" required>
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


 <!-- Modal for Viewing Details -->
 <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">ICS Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                                <th>Description</th>
                                <th>Inventory No.</th>
                                <th>Estimated Life</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="related-items">
                            <!-- Related items will be dynamically loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#crud-table').DataTable();
        // Fetch and display records
        function fetchData() {
        $.get('fetch_data_par.php', function (data) {
            try {
                const records = JSON.parse(data);
                const table = $('#crud-table').DataTable();
                table.clear(); // Clear the table before adding new data
                
                // Populate table with the fetched records
                records.forEach(record => {
                    table.row.add([
                        record.id,
                        record.entity_name,
                        record.fund_cluster,
                        record.par_no,
                        record.date_acquired,
                        record.amount,
                        `
                        <button class="btn btn-warning btn-sm edit-btn" data-id="${record.id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${record.id}">Delete</button>
                        `
                    ]).draw();
                });
            } catch (error) {
                console.error("Error parsing data:", error);
            }
        }).fail(function () {
            alert('Error occurred while fetching data!');
        });
    }


        // Add dynamic fields
        $('#add-field').click(function () {
            const fieldHTML = `
                <div class="dynamic-field mb-3">
                    <div class="row">
                        <div class="col-1">
                            <input type="text" class="form-control mb-2" name="quantity[]" placeholder="Qty" required>
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control mb-2" name="unit[]" placeholder="Unit" required>
                        </div>
                        <div class="col-1">
                            <input type="number" class="form-control mb-2" name="cost[]" placeholder="Unit Cost" required>
                        </div>
                        <div class="col-1">
                            <input type="number" class="form-control mb-2" name="amount[]" placeholder="Total Cost" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control mb-2" name="item-number[]" placeholder="Inventory No" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control mb-2" name="estimate[]" placeholder="Estimated Life" required>
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
                url: 'insert_ics.php',
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

        // Handle "View" button click
        $(document).on('click', '.view-btn', function () {
            const id = $(this).data('id');
            $('#viewModal').modal('show');

            // Fetch details
            $.ajax({
                type: 'GET',
                url: `fetch_ics_details.php?id=${id}`,
                success: function (data) {
                    try {
                        const details = JSON.parse(data);
                        const detailsHTML = `
                            <p><strong>ICS No:</strong> ${details.ics_no}</p>
                            <p><strong>Quantity:</strong> ${details.qty}</p>
                            <p><strong>Unit:</strong> ${details.unit}</p>
                            <p><strong>Description:</strong> ${details.description}</p>
                            <p><strong>Inventory Number:</strong> ${details.item_no}</p>
                            <p><strong>Date Filed:</strong> ${details.date_file}</p>
                        `;
                        $('#view-par-details').html(detailsHTML);

                        // Fetch related items
                        fetchRelatedItems(details.item_no);
                    } catch (error) {
                        $('#view-par-details').html('<p>Error parsing data.</p>');
                        console.error("Parsing error:", error);
                    }
                },
                error: function () {
                    $('#view-par-details').html('<p>Error fetching details.</p>');
                }
            });
        });

        function fetchRelatedItems(itemNo) {
            $.ajax({
                type: 'GET',
                url: `fetch_related_ics_items.php?item_no=${itemNo}`,
                success: function (data) {
                    try {
                        const items = JSON.parse(data);
                        const relatedItemsHTML = items.map(item => `
                            <tr>
                                <td>${item.qty}</td>
                                <td>${item.unit}</td>
                                <td>${item.unit_cost}</td>
                                <td>${item.total_cost}</td>
                                <td>${item.description}</td>
                                <td>${item.item_no}</td>
                                <td>${item.estimate}</td>
                                <td>
                                    <a href="update_ics.php?id=${item.id}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a href="delete_ics.php?id=${item.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        `).join('');
                        $('#related-items').html(relatedItemsHTML);
                    } catch (error) {
                        $('#related-items').html('<tr><td colspan="5">Error parsing related items.</td></tr>');
                        console.error("Parsing error:", error);
                    }
                },
                error: function () {
                    $('#related-items').html('<tr><td colspan="5">Error fetching related items.</td></tr>');
                }
            });
        }


    });
</script>
</body>
</html>
