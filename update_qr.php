<?php
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['serial-no'])) {
        // Fetch form data
        $serial_id = $_POST['serial-no'];
        $property_id = $_POST['property-no'];
        $article = $_POST['article'];
        $service_status = isset($_POST['serviceable']) ? 'Serviceable' : (isset($_POST['unserviceable']) ? 'Unserviceable' : '');
        $unit = $_POST['unit'];
        $cost = $_POST['cost'];
        $date_acquired = $_POST['date-acquired'];
        $date_counted = $_POST['date-counted'];
        $coa_rep = $_POST['coa-representative'];
        $property_cus = $_POST['property-custodian'];

        $stmt = $conn->prepare("UPDATE `qr_tb` SET `serial_id` = ?, `property_id` = ?, `article` = ?, 
                                `service_status` = ?, `unit` = ?, `cost` = ?, 
                                `date_acquired` = ?, `date_counted` = ?, 
                                `coa_rep` = ?, `property_cus` = ? WHERE `serial_id` = ?");
        $stmt->bind_param("sssssssssss", $serial_id, $property_id, $article, $service_status, $unit, $cost, $date_acquired, 
                          $date_counted, $coa_rep, $property_cus, $serial_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the record']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing serial number']);
    }
}

$conn->close();
?>
