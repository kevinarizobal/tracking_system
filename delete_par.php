<?php
include('config.php');

$id = $_GET['id'];
$sql = "DELETE FROM par_tb WHERE id = $id";

if ($conn->query($sql)) {
    echo "<script>alert('Deleted Successfully!!');</script>";
    header("Location: par.php"); 
} else {
    echo "Error: " . $conn->error;
}

?>
