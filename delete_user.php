<?php

include ('config.php');

$userid = $_POST['userid'];

$sql = "DELETE FROM `user_tb` WHERE `userid` = $userid";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
