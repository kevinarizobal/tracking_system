<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: index.php");
    exit();
}

// Get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the current record
$sql = "SELECT * FROM ics_tb WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Assign values to variables
if ($row) {
    $entity_name = $row['entity_name'];
    $fund_cluster = $row['fund_cluster'];
    $ics_no = $row['ics_no'];
    $qty = $row['qty'];
    $unit = $row['unit'];
    $unit_cost = $row['unit_cost'];
    $total_cost = $row['total_cost'];
    $description = $row['description'];
    $item_no = $row['item_no'];
    $estimate = $row['estimate'];
    $receive_by = $row['receive_by'];
    $role1 = $row['role1'];
    $receivefrom_date = $row['receivefrom_date'];
    $issue_by = $row['issue_by'];
    $role2 = $row['role2'];
    $receiveby_date = $row['receiveby_date'];
} else {
    die("Record not found.");
}

// Function to check if ICS No exists
function icsNoExists($conn, $ics_no, $id = null) {
    if ($id) {
        $sql = "SELECT id FROM ics_tb WHERE ics_no = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $ics_no, $id);
    } else {
        $sql = "SELECT id FROM ics_tb WHERE ics_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ics_no);
    }

    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

// Handle form submission for update
if (isset($_POST['update'])) {
    // Retrieve form values
    $entity_name = $_POST['entity_name'];
    $fund_cluster = $_POST['fund_cluster'];
    $ics_no = $_POST['ics_no'];
    $qty = $_POST['qty'];
    $unit = $_POST['unit'];
    $unit_cost = $_POST['unit_cost'];
    $total_cost = $_POST['total_cost'];
    $description = $_POST['description'];
    $item_no = $_POST['item_no'];
    $estimate = $_POST['estimate'];
    $receive_by = $_POST['receive_by'];
    $role1 = $_POST['role1'];
    $receivefrom_date = $_POST['receivefrom_date'];
    $issue_by = $_POST['issue_by'];
    $role2 = $_POST['role2'];
    $receiveby_date = $_POST['receiveby_date'];

    // Check if ICS No already exists (excluding the current record)
    if (icsNoExists($conn, $ics_no, $id)) {
        echo "<script>alert('Error: ICS Number already exists! Please use a different ICS No.'); window.history.back();</script>";
        exit();
    }

    // Update query using prepared statement
    $update_sql = "UPDATE ics_tb SET 
        entity_name = ?, 
        fund_cluster = ?, 
        ics_no = ?, 
        qty = ?, 
        unit = ?, 
        unit_cost = ?, 
        total_cost = ?, 
        description = ?, 
        item_no = ?, 
        estimate = ?, 
        receive_by = ?, 
        role1 = ?, 
        receivefrom_date = ?, 
        issue_by = ?, 
        role2 = ?, 
        receiveby_date = ? 
        WHERE id = ?";

    $stmt = $conn->prepare($update_sql);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("ssssssssssssssssi", 
        $entity_name, $fund_cluster, $ics_no, $qty, $unit, $unit_cost, $total_cost, 
        $description, $item_no, $estimate, $receive_by, $role1, $receivefrom_date, 
        $issue_by, $role2, $receiveby_date, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully!'); window.location.href = 'ics.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
    }
}

// Handle form submission for insert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entity'])) {
    // Collect form values for ICS
    $entity_name = $_POST['entity'];
    $fund_cluster = $_POST['fund-cluster'];
    $ics_no = $_POST['par-no'];

    // Check if ICS No already exists
    if (icsNoExists($conn, $ics_no)) {
        echo "<script>alert('Error: ICS Number already exists! Please use a different ICS No.'); window.history.back();</script>";
        exit();
    }

    $date_acquired = date('Y-m-d');
    $receive_by = $_POST['received-by'];
    $role1 = $_POST['role1'];
    $issue_by = $_POST['issued-by'];
    $role2 = $_POST['role2'];
    $issue_date = $_POST['issue-date'];
    $receive_date = $_POST['receive-date'];

    // Collect item data
    $quantities = $_POST['quantity'];
    $units = $_POST['unit'];
    $descriptions = $_POST['description'];
    $costs = $_POST['cost'];
    $amounts = $_POST['amount'];
    $estimates = $_POST['estimate'];
    $item_numbers = $_POST['item-number'];

    // Insert item data into the database
    foreach ($quantities as $index => $quantity) {
        // Prepare SQL query for each item
        $sql = "INSERT INTO ics_tb (entity_name, fund_cluster, ics_no, qty, unit, unit_cost, total_cost, description, item_no, estimate, receive_by, role1, issue_by, role2, date_file, receivefrom_date, receiveby_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param('ssssssssssssssss', 
            $entity_name, 
            $fund_cluster, 
            $ics_no, 
            $quantity, 
            $units[$index], 
            $costs[$index], 
            $amounts[$index], 
            $descriptions[$index], 
            $item_numbers[$index], 
            $estimates[$index], 
            $receive_by, 
            $role1, 
            $issue_by, 
            $role2, 
            $date_acquired, 
            $receive_date
        );

        $stmt->execute();
    }

    echo "<script>alert('ICS information added successfully!');</script>";
    echo "<script>window.location.href = 'ics.php';</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include('link/header.php'); ?>
<body>
<?php include('link/navbar.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3>UPDATE INVENTORY CUSTODIAN RECEIPT</h3>
            <div class="card">
                <div class="card-body">
                    <a href="ics.php" class="btn btn-primary mb-3">Return ICS</a>
                    <form method="POST">
                        <div class="row align-items-end">
                            <div class="col-4 mb-3">
                                <label class="form-label">Entity Name</label>
                                <input type="text" name="entity_name" class="form-control" value="<?= htmlspecialchars($entity_name); ?>" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Fund Cluster</label>
                                <input type="text" name="fund_cluster" class="form-control" value="<?= htmlspecialchars($fund_cluster); ?>" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">ICS No.</label>
                                <input type="text" name="ics_no" class="form-control" value="<?= htmlspecialchars($ics_no); ?>" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="qty" class="form-control" value="<?= htmlspecialchars($qty); ?>" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">Unit</label>
                                <input type="text" name="unit" class="form-control" value="<?= htmlspecialchars($unit); ?>" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">Unit Cost</label>
                                <input type="number" step="0.01" name="unit_cost" class="form-control" value="<?= htmlspecialchars($unit_cost); ?>" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">Total Cost</label>
                                <input type="number" step="0.01" name="total_cost" class="form-control" value="<?= htmlspecialchars($total_cost); ?>" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Description</label>
                                <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($description); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Inventory No.</label>
                                <input type="text" name="item_no" class="form-control" value="<?= htmlspecialchars($item_no); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Estimated Life Used</label>
                                <input type="text" name="estimate" class="form-control" value="<?= htmlspecialchars($estimate); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Received By</label>
                                <input type="text" name="receive_by" class="form-control" value="<?= htmlspecialchars($receive_by); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Position/Office</label>
                                <input type="text" name="role1" class="form-control" value="<?= htmlspecialchars($role1); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Received From Date</label>
                                <input type="date" name="receivefrom_date" class="form-control" value="<?= htmlspecialchars($receivefrom_date); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Issued By</label>
                                <input type="text" name="issue_by" class="form-control" value="<?= htmlspecialchars($issue_by); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Position/Office</label>
                                <input type="text" name="role2" class="form-control" value="<?= htmlspecialchars($role2); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label">Received By Date</label>
                                <input type="date" name="receiveby_date" class="form-control" value="<?= htmlspecialchars($receiveby_date); ?>">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mt-2" name="update" value="Update ICS Information">
                        <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#crudModal">Add More Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal for More Items -->
<!-- Modal Structure -->
<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crudModalLabel">ICS Input Fields</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="crud-form" method="POST" action="ics_insert.php">
                    <div class="row">
                        <!-- Basic Information Fields -->
                        <div class="col-4 mb-3">
                            <label for="entity" class="form-label">Entity</label>
                            <input type="text" class="form-control" id="entity" name="entity" value="NEMSU Cantilan Campus" readonly>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="fund-cluster" class="form-label">Fund Cluster</label>
                            <input type="text" class="form-control" id="fund-cluster" name="fund-cluster" value="<?= htmlspecialchars($fund_cluster); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="par-no" class="form-label">ICS No</label>
                            <input type="text" class="form-control" id="par-no" name="par-no" value="<?= htmlspecialchars($ics_no); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="received-by" class="form-label">Received By</label>
                            <input type="text" class="form-control" id="received-by" name="received-by" value="<?= htmlspecialchars($receive_by); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="role1" class="form-label">Position/Office</label>
                            <input type="text" class="form-control" id="role1" name="role1" value="<?= htmlspecialchars($role1); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="receive-date" class="form-label">Date Receive</label>
                            <input type="date" class="form-control" id="receive-date" name="receive-date" value="<?= htmlspecialchars($receivefrom_date); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="issued-by" class="form-label">Issued By</label>
                            <input type="text" class="form-control" id="issued-by" name="issued-by" value="<?= htmlspecialchars($issue_by); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="role2" class="form-label">Position/Office</label>
                            <input type="text" class="form-control" id="role2" name="role2" value="<?= htmlspecialchars($role2); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="issue-date" class="form-label">Issue Date</label>
                            <input type="date" class="form-control" id="issue-date" name="issue-date" value="<?= htmlspecialchars($receiveby_date); ?>">
                        </div>
                    </div>

                    <!-- Dynamic Fields for Items -->
                    <div id="dynamic-fields">
                        <h5>Items</h5>
                        <div class="dynamic-field mb-3">
                            <div class="row">
                                <div class="col-1">
                                    <input type="number" class="form-control mb-2" name="quantity[]" placeholder="Qty" required>
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

                    <!-- Buttons for Add Field and Submit -->
                    <button type="button" id="add-field" class="btn btn-primary">Add Field</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Add a new item field
document.getElementById('add-field').addEventListener('click', function() {
    let fieldHTML = `
        <div class="dynamic-field mb-3">
            <div class="row">
                <div class="col-1">
                    <input type="number" class="form-control mb-2" name="quantity[]" placeholder="Qty" required>
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
    `;
    document.getElementById('dynamic-fields').insertAdjacentHTML('beforeend', fieldHTML);
});

// Remove item field
document.getElementById('dynamic-fields').addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('removeField')) {
        e.target.closest('.dynamic-field').remove();
    }
});

</script>

<?php include('link/script.php'); ?>
</body>
</html>
