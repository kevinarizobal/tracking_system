<?php

include ('config.php');

$userid = $_GET['userid'];

$sql = "SELECT `userid`, `email`, `username`, `fullname`, `role`, `status` FROM `user_tb` WHERE `userid` = $userid";
$result = $conn->query($sql);

$response = [];
if ($result->num_rows > 0) {
    $response['success'] = true;
    $response['data'] = $result->fetch_assoc();
} else {
    $response['success'] = false;
}

echo json_encode($response);

$conn->close();
?>
