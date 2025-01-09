<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $id = $_POST['id'];
    $article = $_POST['article'];
    $property_no = $_POST['property_no'];
    $serial_no = $_POST['serial_no'];
    $serviceable = $_POST['serviceable'];
    $unit_quantity = $_POST['unit_quantity'];
    $acquisition_cost = $_POST['acquisition_cost'];
    $date_acquired = $_POST['date_acquired'];
    $date_counted = $_POST['date_counted'];
    $coa_representative = $_POST['coa_representative'];
    $property_custodian = $_POST['property_custodian'];

    // Update the item in the database
    $sql = "UPDATE item_db SET article='$article', property_no='$property_no', serial_no='$serial_no', serviceable='$serviceable', unit_quantity='$unit_quantity', acquisition_cost='$acquisition_cost', date_acquired='$date_acquired', date_counted='$date_counted', coa_representative='$coa_representative', property_custodian='$property_custodian' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Item updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
