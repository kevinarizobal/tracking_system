<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity_name        = $_POST['entity_name']; // This will be an array
    $fund_claster       = $_POST['fund_claster']; // This will be an array   
    $par_no             = $_POST['par_no']; // This will be an array
    $qty                = $_POST['qty']; // This will be an array
    $unit               = $_POST['unit']; // This will be an array
    $descriptions       = $_POST['description']; // This will be an array
    $property_number    = $_POST['property_number']; // This will be an array
    $date_acquired      = $_POST['date_acquired']; // This will be an array
    $amount             = $_POST['amount']; // This will be an array
    $receive            = $_POST['received_by']; // This will be an array
    $issue              = $_POST['issue']; // This will be an array
    $date_file          = $_POST['date_file']; // This will be an array

    if (is_array($descriptions)) {
        foreach ($descriptions as $description) {
            $name = $conn->real_escape_string($description); // Prevent SQL injection
            $sql = "INSERT INTO `par_tb`(`entity_name`, `fund_cluster`, `par_no`, `qty`, `unit`, `description`, 
            `property_number`, `date_acquired`, 
            `amount`, `received_by`, `issued_by`, `date_file`)
             VALUES ('$entity_name','$fund_claster','$par_no','$qty','$unit','$description',
             '$property_number','$date_acquired','$amount','$receive','$issue','$date_file')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
$conn->close();
?>
