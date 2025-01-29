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
$sql = "SELECT `id`, `entity_name`, `fund_cluster`, `ics_no`, `qty`, `unit`, `unit_cost`, `total_cost`, `description`, `item_no`, `estimate`, `receive_by`, `role1`, `issue_by`, `role2`, `date_file` 
FROM `ics_tb` WHERE `id` = $id LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Assign fetched values to variables
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
    $issue_by = $row['issue_by'];
    $role2 = $row['role2'];
    $date_file = $row['date_file'];
} else {
    die("No record found for ID $id");
}

// Handle the update form submission
if (isset($_POST['update'])) {
    // Get updated values from the form
    $entity_name = $_POST['entity_name'];
    $fund_cluster = $_POST['fund_cluster'];
    $ics_no = $_POST['par_no'];
    $qty = $_POST['qty'];
    $unit = $_POST['unit'];
    $unit_cost = $_POST['unit_cost'];
    $total_cost = $_POST['total_cost'];
    $description = $_POST['description'];
    $item_no = $_POST['item_no'];
    $estimate = $_POST['estimate'];
    $receive_by = $_POST['receive_by'];
    $role1 = $_POST['role1'];
    $issue_by = $_POST['issue_by'];
    $role2 = $_POST['role2'];
    $date_file = $_POST['date_file'];

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE `ics_tb` SET 
        `entity_name` = ?, 
        `fund_cluster` = ?, 
        `ics_no` = ?, 
        `qty` = ?, 
        `unit` = ?, 
        `unit_cost` = ?, 
        `total_cost` = ?, 
        `description` = ?, 
        `item_no` = ?, 
        `estimate` = ?, 
        `receive_by` = ?, 
        `role1` = ?, 
        `issue_by` = ?, 
        `role2` = ?, 
        `date_file` = ? 
        WHERE `id` = ?");
    $stmt->bind_param("sssissdssssssssi", 
        $entity_name, 
        $fund_cluster, 
        $ics_no, 
        $qty, 
        $unit, 
        $unit_cost, 
        $total_cost, 
        $description, 
        $item_no, 
        $estimate, 
        $receive_by, 
        $role1, 
        $issue_by, 
        $role2, 
        $date_file, 
        $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully'); window.location.href = 'ics.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
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
                <h3>UPDATE INVENTORY CUSTODIAN RECEIPT</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="ics.php" class="btn btn-primary mb-3">Return ICS</a>
                    </div>
                    <form method="POST">
                        <div class="row align-items-end">
                            <div class="col-6 mb-3">
                                <label class="form-label" style="font-weight: 500;">Entity Name</label>
                                <input type="text" id="entity-name" name="entity_name" class="form-control" value="<?= htmlspecialchars($entity_name); ?>" >
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" style="font-weight: 500;">Fund Cluster</label>
                                <input type="text" id="fund-cluster" name="fund_cluster" class="form-control" value="<?= htmlspecialchars($fund_cluster); ?>">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" style="font-weight: 500;">ICS No.</label>
                                <input type="text" id="par-no" name="par_no" class="form-control" value="<?= htmlspecialchars($ics_no); ?>" >
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label" style="font-weight: 500;">Quantity</label>
                                <input type="number" id="qty" name="qty" class="form-control" value="<?= htmlspecialchars($qty); ?>" >
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label" style="font-weight: 500;">Unit</label>
                                <input type="text" id="unit" name="qty" class="form-control" value="<?= htmlspecialchars($unit); ?>" >
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label" style="font-weight: 500;">Unit Cost</label>
                                <input type="number" id="unit-cost" name="unit_cost" class="form-control" value="<?= htmlspecialchars($unit_cost); ?>" >
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label" style="font-weight: 500;">Total Cost</label>
                                <input type="number" id="total-cost" name="total_cost" class="form-control" value="<?= htmlspecialchars($total_cost); ?>" >
                            </div>
                            <div class="col-3    mb-3">
                                <label class="form-label" style="font-weight: 500;">Inventory No.</label>
                                <input type="text" id="item-no" name="item_no" class="form-control" value="<?= htmlspecialchars($item_no); ?>">
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label" style="font-weight: 500;">Description</label>
                                <input type="text" id="description" name="description" class="form-control" value="<?= htmlspecialchars($description); ?>">
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label" style="font-weight: 500;">Estimated Life Used</label>
                                <input type="text" id="estimate" name="estimate" class="form-control" value="<?= htmlspecialchars($estimate); ?>">
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label" style="font-weight: 500;">Date File</label>
                                <input type="date" id="date-file" name="date_file" class="form-control" value="<?= htmlspecialchars($date_file); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" style="font-weight: 500;">Received By</label>
                                <input type="text" id="receive-by" name="receive_by" class="form-control" value="<?= htmlspecialchars($receive_by); ?>" >
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" style="font-weight: 500;">Position/Office</label>
                                <input type="text" id="role1" name="role1" class="form-control" value="<?= htmlspecialchars($role1); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" style="font-weight: 500;">Issued By</label>
                                <input type="text" id="issue-by" name="issue_by" class="form-control" value="<?= htmlspecialchars($issue_by); ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" style="font-weight: 500;">Position/Office</label>
                                <input type="text" id="role2" name="role2" class="form-control" value="<?= htmlspecialchars($role2); ?>">
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
