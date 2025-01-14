<?php
// Include your database connection here
// Example using PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=suptrackfnl_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['serial_id'])) {
        $serial_id = $_GET['serial_id'];
        $stmt = $pdo->prepare("SELECT * FROM qr_tb WHERE serial_id = :serial_id");
        $stmt->bindParam(':serial_id', $serial_id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No data found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Serial ID is required']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
