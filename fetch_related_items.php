<?php
include('config.php');

if (isset($_GET['par_no'])) {
    $par_no = $_GET['par_no'];
    $sql = "SELECT * FROM par_tb WHERE par_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $par_no);
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
