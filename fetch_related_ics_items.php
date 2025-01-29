<?php
include('config.php');
$item_no = $_GET['item_no'];
$sql = "SELECT * FROM ics_tb WHERE item_no = '$item_no'";
$result = $conn->query($sql);
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
echo json_encode($items);
?>