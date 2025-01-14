<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic CRUD Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Dynamic Input Fields</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crudModal">Create Form</button>

        <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crudModalLabel">Dynamic Input Fields</h5>
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
                                    <label for="received-by" class="form-label">Received By</label>
                                    <input type="text" class="form-control" id="received-by" name="received-by" required>
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
                                            <input type="text" class="form-control mb-2" name="property-number[]" placeholder="Property Number" required>
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

        <table class="table table-responsive mt-4" id="crud-table">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Property Number</th>
                    <th>Date Acquired</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
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
                                <input type="text" class="form-control mb-2" name="property-number[]" placeholder="Property Number" required>
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
