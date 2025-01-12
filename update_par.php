<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $entity_name        = $_POST['entity_name'];
    $fund_cluster       = $_POST['fund_cluster'];
    $par_no             = $_POST['par_no'];
    $qty                = $_POST['qty'];
    $unit               = $_POST['unit'];
    $descriptions       = implode(',', $_POST['description']); // Convert description array to a comma-separated string
    $property_number    = $_POST['property_number'];
    $date_acquired      = $_POST['date_acquired'];
    $amount             = $_POST['amount'];
    $received_by        = $_POST['received_by'];
    $issued_by          = $_POST['issued_by'];
    $date_file          = $_POST['date_file'];

    $sql = "UPDATE par_tb SET 
                entity_name='$entity_name',
                fund_cluster='$fund_cluster',
                par_no='$par_no',
                qty='$qty',
                unit='$unit',
                description='$descriptions',  // Update the description as a comma-separated string
                property_number='$property_number',
                date_acquired='$date_acquired',
                amount='$amount',
                received_by='$received_by',
                issued_by='$issued_by',
                date_file='$date_file'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Update successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
