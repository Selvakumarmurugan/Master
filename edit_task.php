<?php
include("config.php");
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: tasks.php");
    exit;
}

$taskId = $_GET['id'];
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];


// Fetch Task Data
$query = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ii", $taskId, $userId);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskName = $_POST['task'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    $updateQuery = "UPDATE tasks SET task = ?, start_time = ?, end_time = ? WHERE id = ? AND employee_id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param("sssii", $taskName, $startTime, $endTime, $taskId, $userId);
    $stmt->execute();

    header("Location: tasks.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
<?php include 'sidebar.php' ?>
<div class="container py-5">
    <h2>Edit Task</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="task" class="form-label">Task Name</label>
            <input type="text" id="task" name="task" class="form-control" value="<?php echo $task['task_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="form-control" value="<?php echo $task['start_time']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" id="end_time" name="end_time" class="form-control" value="<?php echo $task['end_time']; ?>">
        </div>
        <button type="submit" class="btn btn-success">Update Task</button>
        <a href="tasks.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</div>
</body>
</html>
