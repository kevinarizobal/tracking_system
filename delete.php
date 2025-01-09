<?php
include('config.php');

$id = $_GET['id'];

$sql = "DELETE FROM qr_tb WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Deleted Successfully!!');</script>";
    header("Location: test_qr.php"); 
} else {
    echo "Error: " . $conn->error;
}
?>
