<?php
include("config.php");
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Handle POST request to add a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $db->real_escape_string($_POST['user_name']);
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);
   
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $role = $db->real_escape_string($_POST['role']);


    // Insert query
    $query = "INSERT INTO users (user_name, email,password, role) VALUES ('$userName', '$email','$hashedPassword', '$role')";
    if ($db->query($query)) {
        $_SESSION['success_message'] = "User added successfully!";
        header("Location: users.php");
        exit;
    } else {
        $error = "Error: " . $db->error;
        $_SESSION['error_message'] = $error;
       
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <?php include 'sidebar.php'; ?>
    <div class="container mt-4">
        <h3>Add New User</h3>

        <!-- Display error message if any -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form action="add_user.php" method="POST">
            <div class="mb-3">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" id="user_name" name="user_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="employee">Employee</option>
                    <option value="employer">Employer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add User</button>
        </form>
    </div>
</div>
</body>
</html>
