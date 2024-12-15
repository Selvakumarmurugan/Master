<?php 
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];
$query_user = "SELECT * FROM users WHERE id = ?";
$stmt_user = $db->prepare($query_user);
$stmt_user->bind_param("i", $userId);
$stmt_user->execute();
$users = $stmt_user->get_result();
$current_user = $users->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="public/style.css">

</head>
<body class="bg-light">
<div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Section -->
        <!-- <div class="container py-5"> -->

        <div class="container py-5">
        <?php
            if (isset($_SESSION['success_message'])) {
                echo '<div id="successMessage" class="alert alert-success" role="alert">' . 
                    $_SESSION['success_message'] . 
                    '</div>';
                unset($_SESSION['success_message']); // Clear the message
            }

            // Display error message, if any
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger" role="alert">' . 
                    $_SESSION['error_message'] . 
                    '</div>';
                unset($_SESSION['error_message']); // Clear the message
            }

            ?>
            <?php include 'topbar.php'; ?>
            <div class="card p-4 shadow-sm"> 