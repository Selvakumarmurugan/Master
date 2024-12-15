<?php
// tasks.php
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];
$isEmployer = ($role === 'employer') ? true : false;

// Handle Add, Edit, Delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $taskName = $_POST['task_name'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        $query = "INSERT INTO tasks (user_id, task_name, start_time, end_time) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("isss", $userId, $taskName, $startTime, $endTime);
        if($stmt->execute()){
            $_SESSION['success_message'] = "Task added successfully!";
            header("Location: tasks.php");
            exit;
        }else{
            $_SESSION['error_message'] = "Failed to add the task.";
            header("Location: tasks.php");
            exit;
        }
    } elseif ($action === 'edit') {
        $taskId = $_POST['task_id'];
        $taskName = $_POST['task_name'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        $query = "UPDATE tasks SET task_name = ?, start_time = ?, end_time = ? WHERE id = ? AND user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssii", $taskName, $startTime, $endTime, $taskId, $userId);
        $stmt->execute();
    } elseif ($action === 'delete') {
        $taskId = $_POST['task_id'];
        $query = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $taskId, $userId);

        if($stmt->execute()){
            $_SESSION['success_message'] = "Task deleted successfully!";
            header("Location: tasks.php");
            exit;
        }else{
            $_SESSION['error_message'] = "Failed to delete the task.";
            header("Location: tasks.php");
            exit;
        }

    }
}

// Fetch tasks
    $query = "
    SELECT *, TIMEDIFF(tasks.end_time, tasks.start_time) AS hours_worked 
    FROM tasks 
    WHERE user_id = ?
    ";


$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>


<?php include 'header.php' ?>

    <h2 class="mb-4">Manage Tasks</h2>

    <!-- Add Task Form -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="action" value="add">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="task_name" class="form-control" placeholder="Task Name" required>
            </div>
            <div class="col-md-3">
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="time" name="end_time" class="form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success">Add Task</button>
            </div>
        </div>
    </form>

    <!-- Tasks Table -->
    <table id="timeSheetTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Task Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Turnarround Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo $task['id']; ?></td>
                <td><?php echo $task['task_name']; ?></td>
                <td><?php echo $task['start_time']; ?></td>
                <td><?php echo $task['end_time']; ?></td>
                <td>
                <?php 
                    if ($task['end_time'] != "00:00:00") {
                        echo $task['hours_worked'];
                    } else {
                        echo "00:00:00"; // Or any other placeholder text
                    }
                    ?>
                </td>
                <td>
                    <form method="POST" action="update_task.php" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="Yet to Start" <?php echo $task['status'] == 'Yet to Start' ? 'selected' : ''; ?>>Yet to Start</option>
                            <option value="In Progress" <?php echo $task['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="Completed" <?php echo $task['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </form>
                </td>
                <td>
                    <!-- Edit Form -->
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Delete Form -->
                    <form method="POST" style="display:inline-block;" onsubmit="return confirmDelete();">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>

<?php include("footer.php");  ?>



</body>
</html>
