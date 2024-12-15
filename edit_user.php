<?php
include("config.php");

$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = $id";
$result = $db->query($query);
$user = $result->fetch_assoc();
// 
?>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Edit User</h2>
    <form action="update_user.php" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="mb-3">
            <label for="user_name" class="form-label">Name</label>
            <input type="text" id="user_name" name="user_name" value="<?= $user['user_name'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="<?= $user['email'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" value="" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select" required>
                <option value="employee" <?= $user['role'] === 'employee' ? 'selected' : '' ?>>Employee</option>
                <option value="employer" <?= $user['role'] === 'employer' ? 'selected' : '' ?>>Employer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
</body>
</html>
