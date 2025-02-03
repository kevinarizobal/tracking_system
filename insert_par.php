<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entity_name = $_POST['entity'];
    $fund_cluster = $_POST['fund-cluster'];
    $par_no = $_POST['par-no'];
    $received_by = $_POST['received-by'];
    $issued_by = $_POST['issued-by'];
    $date_file = date('Y-m-d'); // Current date
    $position = $_POST['position'];
    $position2 = $_POST['position2'];
    $receive_date = $_POST['receive-date'];
    $issue_date = $_POST['issue-date'];

    // Check if par_no already exists
    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM par_tb WHERE par_no = ?");
    $check_stmt->bind_param("s", $par_no);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        echo "<script>alert('Error: PAR No already exists!'); window.history.back();</script>";
        exit;
    }

    // Prepare SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO par_tb (entity_name, fund_cluster, par_no, qty, unit, description, property_number, date_acquired, amount, received_by, position, issued_by, date_file, position2, receive_date, issue_date)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssssssssssssssss", $entity_name, $fund_cluster, $par_no, $qty, $unit, $description, $property_number, $date_acquired, $amount, $received_by, $position, $issued_by, $date_file, $position2, $receive_date, $issue_date);

    // Loop through dynamic fields and insert each item
    $quantities = $_POST['quantity'];
    $units = $_POST['unit'];
    $descriptions = $_POST['description'];
    $amounts = $_POST['amount'];
    $date_acquired = $_POST['date-acquired'];
    $property_numbers = $_POST['property-number'];

    for ($i = 0; $i < count($quantities); $i++) {
        $qty = $quantities[$i];
        $unit = $units[$i];
        $description = $descriptions[$i];
        $property_number = $property_numbers[$i];
        $date_acquired = $date_acquired[$i];
        $amount = $amounts[$i];

        // Execute the prepared statement
        if (!$stmt->execute()) {
            echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
            exit; // Stop script execution on error
        }
    }

    echo "<script>alert('Data inserted successfully!'); window.location.href='success_page.php';</script>";
    
    // Close the statement
    $stmt->close();
}
?>
