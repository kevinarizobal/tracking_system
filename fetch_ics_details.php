<?php
include('config.php');
$id = $_GET['id'];
$sql = "SELECT * FROM ics_tb WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode([]);
}
?>