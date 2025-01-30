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
    $entity_name = $_POST['entity_name'];
    $fund_cluster = $_POST['fund_cluster'];
    $par_no = $_POST['par_no'];
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
    $position = $_POST['position'];
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
        `position` = '$position',
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('link/script.php'); ?>
</body>
</html>
