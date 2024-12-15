<?php
include("config.php");

$id = $_GET['id'];
$query = "DELETE FROM users WHERE id = $id";
if ($db->query($query)) {
    $_SESSION['success_message'] = "User Deleted successfully!";
    header("Location: users.php");
    exit;  
} else {
    $_SESSION['success_message'] = "Failed to Deleted.";
    header("Location: users.php");
    exit;
}
?>
