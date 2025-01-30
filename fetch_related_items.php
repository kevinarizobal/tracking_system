<?php
include('config.php');

if (isset($_GET['property_number'])) {
    $property_number = $_GET['property_number'];
    $sql = "SELECT id, qty, unit, description, property_number, date_acquired, amount FROM par_tb WHERE property_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $property_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $relatedItems = [];
    while ($row = $result->fetch_assoc()) {
        $relatedItems[] = $row;
    }
    echo json_encode($relatedItems);
    $stmt->close();
}
$conn->close();
?>
