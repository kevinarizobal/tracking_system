<?php
include('config.php'); // Include database connection details

// Check if form data is posted
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $role = $_POST['role'];
    $status = $_POST['status'];

    // Prepare SQL query
    if ($password) {
        $password = md5($password); // Encrypt password if changed
        $sql = "UPDATE `user_tb` SET `email` = ?, `username` = ?, `fullname` = ?, `password` = ?, `role` = ?, `status` = ? WHERE `userid` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $email, $username, $fullname, $password, $role, $status, $userId);
    } else {
        $sql = "UPDATE `user_tb` SET `email` = ?, `username` = ?, `fullname` = ?, `role` = ?, `status` = ? WHERE `userid` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $email, $username, $fullname, $role, $status, $userId);
    }

    // Execute query
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Missing data"]);
}
?>
