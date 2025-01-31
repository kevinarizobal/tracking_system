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

// Handle form submission
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('link/script.php'); ?>
</body>
</html>
