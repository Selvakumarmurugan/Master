<?php
include("config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $query = "UPDATE users SET name = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $name, $userId);
    $stmt->execute();
    header("Location: profile.php");
}

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Function to toggle between views
        function toggleForm(formType) {
            document.getElementById('userProfileForm').style.display = formType === 'create' ? 'block' : 'none';
            document.getElementById('userProfileDisplay').style.display = formType === 'read' ? 'block' : 'none';
        }

        // Function to simulate reading user profile data
        function readProfile() {
            const username = document.getElementById('signup_username').value;
            const email = document.getElementById('signup_email').value;
            const role = document.getElementById('signup_role').value;

            // Display the user data on the profile page
            document.getElementById('display_username').innerText = username;
            document.getElementById('display_email').innerText = email;
            document.getElementById('display_role').innerText = role;
        }

        // Function to simulate updating the profile
        function updateProfile() {
            // Simulate updating the profile (in a real-world app, you'd send the updated data to a server)
            readProfile();
            alert('Profile Updated');
            toggleForm('read');
        }

        // Function to simulate deleting the profile
        function deleteProfile() {
            alert('Profile Deleted');
            toggleForm('create');
        }
    </script>
</head>
<body class="bg-light">

    <div class="container py-3">
        <h1 class="text-center mb-4">User Profile</h1>

        <!-- Navigation for toggling between forms -->
        <div class="text-center mb-4">
            <button class="btn btn-link" onclick="toggleForm('create')">Create Profile</button>
            <button class="btn btn-link" onclick="toggleForm('read')">View Profile</button>
        </div>

        <!-- User Profile Form (Create/Update) -->
        <div id="userProfileForm" class="card p-4 shadow-sm" style="display: block;">
            <form onsubmit="event.preventDefault(); readProfile();">
                <div class="mb-3">
                    <label for="signup_username" class="form-label">Username:</label>
                    <input type="text" id="signup_username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signup_email" class="form-label">Email:</label>
                    <input type="email" id="signup_email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signup_password" class="form-label">Password:</label>
                    <input type="password" id="signup_password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signup_role" class="form-label">Role:</label>
                    <select id="signup_role" name="role" class="form-select" required>
                        <option value="employee">Employee</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Create Profile</button>
            </form>
        </div>

        <!-- User Profile Display (Read/Update/Delete) -->
        <div id="userProfileDisplay" class="card p-4 shadow-sm" style="display: none;">
            <h3>User Profile</h3>
            <p><strong>Username:</strong> <span id="display_username"></span></p>
            <p><strong>Email:</strong> <span id="display_email"></span></p>
            <p><strong>Role:</strong> <span id="display_role"></span></p>
            <div class="d-flex justify-content-between">
                <button class="btn btn-warning" onclick="toggleForm('create')">Edit</button>
                <button class="btn btn-danger" onclick="deleteProfile()">Delete</button>
            </div>
        </div>
    </div>

</body>
</html>
