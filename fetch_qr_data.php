<?php
include 'config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['serial_no'])) {
    $serial_no = $conn->real_escape_string($data['serial_no']);
    $stmt = $conn->prepare("SELECT `id`, `serial_id`, `property_id`, `article`, `service_status`, 
                                   `unit`, `cost`, `date_acquired`, `date_counted`, 
                                   `coa_rep`, `property_cus` 
                            FROM `qr_tb` WHERE `serial_id` = ?");
    $stmt->bind_param("s", $serial_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true] + $row);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found for this QR code.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$conn->close();
?>
