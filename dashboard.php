<?php
// dashboard.php
include("config.php");
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
$user = $users->fetch_assoc();



$query = "SELECT * FROM tasks WHERE user_id = ?";
$query_employer = "SELECT * FROM tasks";
if($role=="employee"){
$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$tasks = $stmt->get_result();
}else{
    $stmt = $db->prepare($query_employer);
    $stmt->execute();
    $tasks = $stmt->get_result();
}


// Check in-time status for current day
 $query = "SELECT * FROM timesheets WHERE employee_id = ? AND DATE(in_time) = CURDATE() ";
// $query = "SELECT * FROM timesheets WHERE employee_id = 1 AND out_time IS NULL";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();


$hasInTime = $result->num_rows > 0;
$timesheet = $result->fetch_assoc();


$activeDay = $hasInTime && empty($timesheet['out_time']);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .timer {
            font-size: 1.5rem;
            color: green;
        }
        .top-bar {
            width : 75%;    
        }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Section -->
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
            <div class="d-flex justify-content-between align-items-center" style="gap: 20px; padding: 10px;">
                <!-- User Image -->
                <img src="assets/img/user.jpg" alt="User Image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">

                <!-- User Details -->
                <div  class="top-bar">
                    <h5 class="mb-1"><?php echo ucfirst($user['user_name']); ?></h5>
                    <p class="mb-1 text-muted"><?php echo ucfirst($user['role']); ?></p>
                    <p class="mb-0 text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <!-- In-Time and Out-Time Buttons -->
                <form action="timesheet.php" method="POST">
                    <?php if (!$hasInTime) { ?>
                        <button type="submit" name="action" value="in_time" class="btn btn-primary">In-Time</button>
                    <?php } elseif ($activeDay) { ?>
                        <span id="clock" class="timer">Day Active...</span>
                        <button type="submit" name="action" value="out_time" class="btn btn-danger">Out-Time</button>
                    <?php } else { ?>
                        <button type="submit" name="action" value="in_time" class="btn btn-primary">In-Time</button>
                    <?php } ?>
                </form>
            </div>
            <div class="card p-4 shadow-sm">
                   
                    
                    <div class="d-flex justify-content-between align-items-center">

                    <h2 class="mb-4">My tasks</h2>
                    <a href="tasks.php" class="btn btn-primary">Add Task</a>

                        </div>
            <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Task</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                            <?php 
                            $n=0;
                            if ($tasks->num_rows != 0) { 
                                while ($task = $tasks->fetch_assoc()) { 
                                    $n++;
                                    echo "<tr>
                                            <td>{$n}</td>
                                            <td>{$task['task_name']}</td>
                                            <td>{$task['start_time']}</td>
                                            <td>{$task['end_time']}</td>
                                            <td>{$task['status']}</td>
                                            
                                        </tr>";
                                }
                            } else {
                                // If no tasks are found, display a single row indicating no data
                                echo "<tr>
                                        <td colspan='5' class='text-center'>No tasks found</td>
                                    </tr>";
                            }
                            ?>
                            </tbody>
                        </table>



            </div>
        </div>
    </div>

    <!-- JavaScript to Auto-Hide Messages -->
<script>
    // Auto-hide success message after 5 seconds
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000); // 5000ms = 5 seconds

    // Auto-hide error message after 5 seconds (if needed)
    setTimeout(() => {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 5000); // Adjust time if needed




    function updateClock() {
            // Get the current date and time
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Add leading zero if needed
            hours = (hours < 10 ? "0" : "") + hours;
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            // Format the time as HH:MM:SS
            var timeString = hours + ":" + minutes + ":" + seconds;

            // Display the time on the page
            document.getElementById("clock").textContent = timeString;
        }

        // Call the function once to display the initial time
        updateClock();

        // Update the clock every 1000 milliseconds (1 second)
        setInterval(updateClock, 1000);
</script>
</body>
</html>
