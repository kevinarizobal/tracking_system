<?php
include('config.php');
$ics_no = $_GET['ics_no'];
$sql = "SELECT * FROM ics_tb WHERE ics_no = '$ics_no'";
$result = $conn->query($sql);
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
echo json_encode($items);
?>
