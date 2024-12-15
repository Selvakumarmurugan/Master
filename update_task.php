<?php
include("config.php");
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'];
    $status = $_POST['status'];
    $userId = $_SESSION['user_id'];

    if ($status === 'Completed') {
        $endTime = date("Y-m-d H:i:s");
        $query = "UPDATE tasks SET status = ?, end_time = ? WHERE id = ? AND user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssii", $status, $endTime, $taskId, $userId);
    } else {
        $query = "UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sii", $status, $taskId, $userId);
    }

    $stmt->execute();
    header("Location: tasks.php");
    exit;
}
?>
