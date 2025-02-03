<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form values
    $entity_name = $_POST['entity'];
    $fund_cluster = $_POST['fund-cluster'];
    $ics_no = $_POST['par-no'];
    $date_acquired = date('Y-m-d');
    $receive_by = $_POST['received-by'];
    $role1 = $_POST['role1'];
    $issue_by = $_POST['issued-by'];
    $role2 = $_POST['role2'];
    $issue_date = $_POST['issue-date'];
    $receive_date = $_POST['receive-date'];

    // Check if ics_no already exists
    $check_sql = "SELECT ics_no FROM ics_tb WHERE ics_no = '" . $conn->real_escape_string($ics_no) . "'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Error: ICS No already exists. Please use a different ICS No.'); window.history.back();</script>";
        exit;
    }

    // Item data arrays
    $quantities = $_POST['quantity'];
    $units = $_POST['unit'];
    $descriptions = $_POST['description'];
    $costs = $_POST['cost'];
    $amounts = $_POST['amount'];
    $estimates = $_POST['estimate'];
    $item_numbers = $_POST['item-number'];

    // Prepare SQL base
    $sql = "INSERT INTO ics_tb (entity_name, fund_cluster, ics_no, qty, unit, unit_cost, total_cost, description, item_no, estimate, receive_by, role1, issue_by, role2, date_file, receivefrom_date, receiveby_date) VALUES ";

    $values = [];
    
    // Loop over all the items
    for ($i = 0; $i < count($quantities); $i++) {
        $values[] = "(
            '" . $conn->real_escape_string($entity_name) . "',
            '" . $conn->real_escape_string($fund_cluster) . "',
            '" . $conn->real_escape_string($ics_no) . "',
            '" . $conn->real_escape_string($quantities[$i]) . "',
            '" . $conn->real_escape_string($units[$i]) . "',
            '" . $conn->real_escape_string($costs[$i]) . "',
            '" . $conn->real_escape_string($amounts[$i]) . "',
            '" . $conn->real_escape_string($descriptions[$i]) . "',
            '" . $conn->real_escape_string($item_numbers[$i]) . "',
            '" . $conn->real_escape_string($estimates[$i]) . "',
            '" . $conn->real_escape_string($receive_by) . "',
            '" . $conn->real_escape_string($role1) . "',
            '" . $conn->real_escape_string($issue_by) . "',
            '" . $conn->real_escape_string($role2) . "',
            '" . $conn->real_escape_string($date_acquired) . "',
            '" . $conn->real_escape_string($receive_date) . "',
            '" . $conn->real_escape_string($issue_date) . "'
        )";
    }

    // Finalize SQL
    $sql .= implode(", ", $values);

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data inserted successfully.'); window.location.href = 'ics.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }

    // Close connection
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
