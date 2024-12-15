<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $userName = $_POST['user_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "UPDATE users SET user_name = '$userName', email = '$email', role = '$role' WHERE id = $id";
    if ($db->query($query)) {
        $_SESSION['success_message'] = "User updated successfully!";
        header("Location: users.php");
        exit;
    } else {
        $_SESSION['success_message'] = "Failed to update.";
        header("Location: users.php");
        exit;
    }
}
?>
