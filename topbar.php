<?php
// Check in-time status for current day
$query_timesheets = "SELECT * FROM timesheets WHERE employee_id = ? AND DATE(in_time) = CURDATE()";
// $query = "SELECT * FROM timesheets WHERE employee_id = 1 AND out_time IS NULL";
$stmt = $db->prepare($query_timesheets);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();


$hasInTime = $result->num_rows > 0;
$timesheet = $result->fetch_assoc();


$activeDay = $hasInTime && empty($timesheet['out_time']);
$stmt->close();
?>


<div class="d-flex justify-content-between align-items-center" style="gap: 0px; padding: 10px;">
                <!-- User Image -->
                <img src="assets/img/user.jpg" alt="User Image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">

                <!-- User Details -->
                <div  class="top-bar">
                    <h5 class="mb-1"><?php echo ucfirst($current_user['user_name']); ?></h5> 
                    <p class="mb-1 text-muted"><?php echo ucfirst($current_user['role']); ?></p>
                    <p class="mb-0 text-muted">                    
                    <?php echo htmlspecialchars($current_user['email']); ?>
                    <a href="edit_user.php?id=<?= $userId; ?>" title="Edit profile">
                        <i class="fa fa-pencil"></i>
                    </a>

                </p>
                </div>
                <!-- In-Time and Out-Time Buttons -->
                

                <form action="timesheet.php" method="POST">
                <?php if($role=="employee"){ ?>
                    <?php if (!$hasInTime) { ?>
                        <button type="submit" name="action" value="in_time" class="btn btn-primary">In-Time</button>
                    <?php } elseif ($activeDay) { ?>
                        <span id="clock" class="timer">Day Active...</span>
                        <button type="submit" name="action" value="out_time" class="btn btn-danger">Out-Time</button>
                    <?php } else { ?>
                        <button type="submit" name="action" value="in_time" class="btn btn-primary">In-Time</button>
                    <?php } ?>
                    <?php }   ?>
                </form>
                <!-- <button type="submit" name="action" value="in_time" class="btn btn-danger">logout</button> -->
                <button type="button" class="btn btn-danger" onclick="window.location.href='logout.php';">
    Logout
</button>

                <!-- <a href="logout.php" class="nav-link text-danger">Logout</a> -->


            </div>