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
//     $query = "
//     SELECT tasks.*, 
//            users.*, 
//            TIMEDIFF(tasks.end_time, tasks.start_time) AS hours_worked
//     FROM tasks
//     JOIN users ON tasks.user_id = users.id
//     WHERE tasks.user_id = ?
// ";
$query_employer = "SELECT *,TIMEDIFF(tasks.end_time, tasks.start_time) AS hours_worked FROM tasks";
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



?>

<?php include 'header.php' ?>
  


            
                 <div class="d-flex justify-content-between align-items-center">

                    <h2 class="mb-4">My tasks</h2>
                    <a href="tasks.php" class="btn btn-primary">Add Task</a>

                        </div>
            <table id="timeSheetTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Task</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Turnarround Time</th>
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
                                            <td>{$task['user_id']}</td>
                                            <td>{$task['task_name']}</td>
                                            <td>{$task['start_time']}</td>
                                            <td>{$task['end_time']}</td>
                                            <td>{$task['hours_worked']}</td>
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
    <?php include("footer.php");  ?>
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
