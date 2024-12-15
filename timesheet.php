<?php
// timesheet.php
include("config.php");
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$action = $_POST['action'];
$userId = $_SESSION['user_id'];

if ($action === 'in_time') {
    // Insert In-Time for the day
    $time = date("Y-m-d H:i:s");
    $query = "INSERT INTO timesheets (employee_id, in_time) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $userId, $time);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "In-Time recorded successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to record In-Time.";
    }
} elseif ($action === 'out_time') {
    // Update Out-Time for the day
    $time = date("Y-m-d H:i:s");
    $query = "UPDATE timesheets SET out_time = ? WHERE employee_id = ? AND DATE(in_time) = CURDATE()";
    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $time, $userId);
    $stmt->execute();
} elseif ($action === 'add_task') {
    // Add Task with Start and End Time
    $task = $_POST['task'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    $query = "INSERT INTO timesheets (employee_id, task, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("isss", $userId, $task, $startTime, $endTime);
    $stmt->execute();
}

header("Location: dashboard.php");
?>
