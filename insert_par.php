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
    $property_number = $_POST['property-number'];

    for ($i = 0; $i < count($quantities); $i++) {
        $qty = $quantities[$i];
        $unit = $units[$i];
        $description = $descriptions[$i];
        $property_number = $property_number[$i];
        $date_acquired = $date_acquired[$i];
        $amount = $amounts[$i];

        // Execute the prepared statement
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit; // Stop script execution on error
        }
    }

    echo "Data inserted successfully!";
    
    // Close the statement
    $stmt->close();
}
?>
