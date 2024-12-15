<?php
// user.php
include("config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .hover-info {
    position: relative;
}

.hover-info::after {
    content: attr(data-in-time) " - " attr(data-out-time);
    position: absolute;
    top: -20px;
    left: 0;
    background-color: #333;
    color: white;
    padding: 5px;
    border-radius: 3px;
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.3s;
    white-space: nowrap;
}

.hover-info:hover::after {
    visibility: visible;
    opacity: 1;
}

    </style>
</head>
<body>
<div class="d-flex">
<?php include 'sidebar.php' ?>
<div class="container py-5">
<div class="d-flex justify-content-between align-items-center">

    <h2 class="mb-3">User Working Hours</h2> 
    </div>
    <table id="user_table" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sl.no</th>
            <th>Name</th>
            <th>Role</th>
            <th>Date</th>
            <!-- <th>Turnarrount time</th> -->
            <th>Hours worked</th>
        </tr>
    </thead>
    <tbody>
    <?php
//     $query = "
//     SELECT 
//         users.id AS user_id,
//         users.user_name AS user_name,
//         users.email AS user_email,
//         users.role AS user_role,
//         tasks.id AS task_id,
//         tasks.task_name AS task_name,
//         tasks.start_time AS start_time,
//         tasks.end_time AS end_time,
//         tasks.status AS task_status,
//         timesheets.id AS timesheet_id,
//         timesheets.in_time AS in_time,
//         timesheets.out_time AS out_time,
//         TIMEDIFF(timesheets.out_time, timesheets.in_time) AS hours_worked
//     FROM 
//         users
//     JOIN 
//         tasks ON users.id = tasks.user_id
//     JOIN 
//         timesheets ON users.id = timesheets.employee_id
//     WHERE 
//         users.id = $id
// ";

$query = "
SELECT 
    users.id AS user_id,
    users.user_name AS user_name,
    users.email AS user_email,
    users.role AS user_role,
    timesheets.id AS timesheet_id,
    timesheets.in_time AS in_time,
    timesheets.out_time AS out_time,
    TIMEDIFF(timesheets.out_time, timesheets.in_time) AS hours_worked
FROM 
    users
JOIN 
    timesheets ON users.id = timesheets.employee_id
WHERE 
    users.id = $id
";

    $result = $db->query($query);



    while ($row = $result->fetch_assoc()) {
       
        $datetime = $row['in_time'];
        list($date, $time) = explode(' ', $datetime);
        
        if($row['hours_worked'] !=''){
        echo "<tr>
                <td>{$id}</td>
                <td>{$row['user_name']}</td>
                <td>{$row['user_role']}</td>
                <td class='hover-info' data-in-time='in_time:{$row['in_time']}' data-out-time='out_time:{$row['out_time']}'>{$date}</td>
                <td>{$row['hours_worked']}</td>
                
               
              </tr>";
        }
    }
    ?>
    </tbody>
</table>

        </div>
    </div>

   


                        </body>
                        </html>