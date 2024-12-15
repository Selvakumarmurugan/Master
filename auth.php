<?php
include("config.php");

$username = $_POST['username'] ?? null; // Only for signup
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
$action = $_POST['action'];


if ($action == "signup") {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (user_name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
    if ($stmt->execute()) {
        echo "Sign Up Successful. Please Sign In.";
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif ($action == "signin") {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "No user found.";
    }
    $stmt->close();
}
?>
