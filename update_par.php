<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}

include('config.php');

// Get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch data for the given ID
$sql = "SELECT `id`, `entity_name`, `fund_cluster`, `par_no`, `qty`, `unit`, `description`, `property_number`, 
`date_acquired`, `amount`, `received_by`, `position`, `issued_by`, `date_file`, `position2`, `receive_date`, `issue_date` 
FROM `par_tb` WHERE `id` = $id LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Assign fetched values to variables
    $entity_name = $row['entity_name'];
    $fund_cluster = $row['fund_cluster'];
    $par_no = $row['par_no'];
    $qty = $row['qty'];
    $unit = $row['unit'];
    $description = $row['description'];
    $property_number = $row['property_number'];
    $date_acquired = $row['date_acquired'];
    $amount = $row['amount'];
    $received_by = $row['received_by'];
    $position = $row['position'];
    $issued_by = $row['issued_by'];
    $date_file = $row['date_file'];
    $position2 = $row['position2'];
    $receive_date = $row['receive_date'];
    $issue_date = $row['issue_date'];
} else {
    die("No record found for ID $id");
}

// Handle the update form submission
if (isset($_POST['update'])) {
    $par_no = trim($_POST['par_no']);
    
    // Check if PAR No is empty
    if (empty($par_no)) {
        echo "<script>alert('PAR No cannot be empty!');</script>";
    } else {
        // Check if PAR No already exists (excluding current record)
        $check_sql = "SELECT id FROM `par_tb` WHERE `par_no` = '$par_no' AND `id` != $id";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            echo "<script>alert('PAR No already exists! Please use a different one.');</script>";
        } else {
            // Proceed with update
            $entity_name = $_POST['entity_name'];
            $fund_cluster = $_POST['fund_cluster'];
            $qty = $_POST['qty'];
            $unit = $_POST['unit'];
            $description = $_POST['description'];
            $property_number = $_POST['property_no'];
            $date_acquired = $_POST['date_acquired'];
            $amount = $_POST['amount'];
            $received_by = $_POST['received_by'];
            $position = $_POST['position'];
            $issued_by = $_POST['issued_by'];
            $position2 = $_POST['position2'];
            $receive_date = $_POST['receive-date'];
            $issue_date = $_POST['issue-date'];
            
            $update_sql = "UPDATE `par_tb` SET 
                `entity_name` = '$entity_name', 
                `fund_cluster` = '$fund_cluster', 
                `par_no` = '$par_no', 
                `qty` = '$qty', 
                `unit` = '$unit', 
                `description` = '$description', 
                `property_number` = '$property_number', 
                `date_acquired` = '$date_acquired', 
                `amount` = '$amount', 
                `received_by` = '$received_by', 
                `position` = '$position', 
                `issued_by` = '$issued_by', 
                `position2` = '$position2',
                `receive_date` = '$receive_date',
                `issue_date` = '$issue_date'
                WHERE `id` = $id";
            
            if ($conn->query($update_sql) === TRUE) {
                echo "<script>alert('PAR information updated successfully!');</script>";
                echo "<script>window.location.href = 'par.php';</script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
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
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>UPDATE PROPERTY ACKNOWLEDGEMENT RECEIPT</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="par.php" class="btn btn-primary mb-3">Return PAR</a>
                    </div>
                    <form method="POST">
                        <div class="row align-items-end">
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Entity Name</label>
                                <input type="text" id="entity-name" name="entity_name" class="form-control" value="<?= htmlspecialchars($entity_name); ?>" >
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Fund Cluster</label>
                                <input type="text" id="fund-cluster" name="fund_cluster" class="form-control" value="<?= htmlspecialchars($fund_cluster); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">PAR No.</label>
                                <input type="text" id="par-no" name="par_no" class="form-control" value="<?= htmlspecialchars($par_no); ?>" >
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Received By</label>
                                <input type="text" id="received-by" name="received_by" class="form-control" value="<?= htmlspecialchars($received_by); ?>" >
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Position/Office</label>
                                <input type="text" id="position" name="position" class="form-control" value="<?= htmlspecialchars($position); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Date Receive</label>
                                <input type="date" id="date-receive" name="receive-date" class="form-control" value="<?= htmlspecialchars($receive_date); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Issued By</label>
                                <input type="text" id="issued-by" name="issued_by" class="form-control" value="<?= htmlspecialchars($issued_by); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Position/Office</label>
                                <input type="text" id="position2" name="position2" class="form-control" value="<?= htmlspecialchars($position2); ?>">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Date Issue</label>
                                <input type="date" id="date-issue" name="issue-date" class="form-control" value="<?= htmlspecialchars($issue_date); ?>">
                            </div>
                            
                            <!-- Items -->
                            <div class="col-1 mb-3">
                                <label class="form-label" style="font-weight: 500;">Quantity</label>
                                <input type="number" id="qty" name="qty" class="form-control" value="<?= htmlspecialchars($qty); ?>" >
                            </div>
                            <div class="col-1 mb-3">
                                <label class="form-label" style="font-weight: 500;">Unit</label>
                                <input type="text" id="unit" name="unit" class="form-control" value="<?= htmlspecialchars($unit); ?>" >
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" style="font-weight: 500;">Description</label>
                                <input type="text" id="description" name="description" class="form-control" value="<?= htmlspecialchars($description); ?>">
                            </div>
                            <div class="col-2 mb-3">
                                <label class="form-label" style="font-weight: 500;">Property No.</label>
                                <input type="text" id="property-no" name="property_no" class="form-control" value="<?= htmlspecialchars($property_number); ?>">
                            </div>
                            <div class="col-2 mb-3">
                                <label class="form-label" style="font-weight: 500;">Date Acquired</label>
                                <input type="date" id="date_acquired" name="date_acquired" class="form-control" value="<?= htmlspecialchars($date_acquired); ?>">
                            </div>
                            <div class="col-2 mb-3">
                                <label class="form-label" style="font-weight: 500;">Amount</label>
                                <input type="number" id="amount" name="amount" class="form-control" value="<?= htmlspecialchars($amount); ?>">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mt-2" name="update" value="Update PAR Information">
                        <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#crudModal">Add More Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crudModalLabel">PAR Input Fields</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="crud-form" method="POST" action="insert.php">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="entity" class="form-label">Entity</label>
                            <input type="text" class="form-control" id="entity" name="entity" value="NEMSU Cantilan Campus" readonly>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="fund-cluster" class="form-label">Fund Cluster</label>
                            <input type="text" class="form-control" id="fund-cluster" name="fund-cluster" value="<?= htmlspecialchars($fund_cluster); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="par-no" class="form-label">PAR No</label>
                            <input type="text" class="form-control" id="par-no" name="par-no" value="<?= htmlspecialchars($par_no); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="received-by" class="form-label">Received By</label>
                            <input type="text" class="form-control" id="received-by" name="received-by" value="<?= htmlspecialchars($received_by); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="position" class="form-label">Position/Office</label>
                            <input type="text" class="form-control" id="position" name="position" value="<?= htmlspecialchars($position); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="receive-date" class="form-label">Received Date</label>
                            <input type="date" class="form-control" id="receive-date" name="receive-date" value="<?= htmlspecialchars($receive_date); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="issued-by" class="form-label">Issued By</label>
                            <input type="text" class="form-control" id="issued-by" name="issued-by" value="<?= htmlspecialchars($issued_by); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="position2" class="form-label">Position/Office</label>
                            <input type="text" class="form-control" id="position2" name="position2" value="<?= htmlspecialchars($position2); ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="issue-date" class="form-label">Issued Date</label>
                            <input type="date" class="form-control" id="issue-date" name="issue-date" value="<?= htmlspecialchars($issue_date); ?>">
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
                                <div class="col-2">
                                    <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" required>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control mb-2" name="property-number[]" placeholder="Property No" required>
                                </div>
                                <div class="col-2">
                                    <input type="date" class="form-control mb-2" name="date-acquired[]" placeholder="Date Acquired" required>
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control mb-2" name="amount[]" placeholder="Amount" required>
                                </div>
                                <div class="col-lg-1">
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

<!-- JavaScript for Adding and Removing Dynamic Fields -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('add-field');
    const dynamicFields = document.getElementById('dynamic-fields');

    addButton.addEventListener('click', function() {
        const newField = document.createElement('div');
        newField.classList.add('dynamic-field', 'mb-3');
        newField.innerHTML = `
            <div class="row">
                <div class="col-1">
                    <input type="text" class="form-control mb-2" name="quantity[]" placeholder="Qty" required>
                </div>
                <div class="col-1">
                    <input type="text" class="form-control mb-2" name="unit[]" placeholder="Unit" required>
                </div>
                <div class="col-2">
                    <input type="text" class="form-control mb-2" name="description[]" placeholder="Description" required>
                </div>
                <div class="col-2">
                    <input type="text" class="form-control mb-2" name="property-number[]" placeholder="Property No" required>
                </div>
                <div class="col-2">
                    <input type="date" class="form-control mb-2" name="date-acquired[]" placeholder="Date Acquired" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control mb-2" name="amount[]" placeholder="Amount" required>
                </div>
                <div class="col-lg-1">
                    <button type="button" class="btn btn-danger removeField">Remove</button>
                </div>
            </div>
        `;
        dynamicFields.appendChild(newField);
    });

    dynamicFields.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('removeField')) {
            e.target.closest('.dynamic-field').remove();
        }
    });
});
</script>
<script>
    function validateForm() {
        let parNo = document.getElementById("par-no").value.trim();
        if (parNo === "") {
            alert("PAR No cannot be empty!");
            return false;
        }
        return true;
    }
</script>


<?php include('link/script.php'); ?>
</body>
</html>
