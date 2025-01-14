<?php
include('config.php');

$sql = "SELECT * FROM par_tb";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
$conn->close();

?>
