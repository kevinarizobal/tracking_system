<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
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

    // Insert into the database
    $sql = "INSERT INTO item_db (article, property_no, serial_no, serviceable, unit_quantity, acquisition_cost, date_acquired, date_counted, coa_representative, property_custodian)
            VALUES ('$article', '$property_no', '$serial_no', '$serviceable', '$unit_quantity', '$acquisition_cost', '$date_acquired', '$date_counted', '$coa_representative', '$property_custodian')";

    if ($conn->query($sql) === TRUE) {
        echo "New item added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
