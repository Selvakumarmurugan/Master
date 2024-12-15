<?php
// user.php
include("config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
<?php include 'sidebar.php' ?>
<div class="container py-5">
    <h2 class="mb-3">Users</h2>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "SELECT * FROM users";
                            $result = $db->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['role']}</td>
                                    </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                        </div>
                        </div>