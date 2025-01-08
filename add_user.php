<?php
include ('config.php');

$email = $_POST['email'];
$username = $_POST['username'];
$fullname = $_POST['fullname'];
$password = $_POST['password']; // Already MD5 encrypted in frontend
$role = $_POST['role'];
$status = $_POST['status'];

$sql = "INSERT INTO `user_tb` (`email`, `username`, `fullname`, `password`, `role`, `status`) 
        VALUES ('$email', '$username', '$fullname', '$password', '$role', '$status')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
