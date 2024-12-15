<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp/SignIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles to adjust the form width */
        .card {
            max-width: 400px; /* Set a max-width for the forms */
            margin: 0 auto; /* Center the form */
            width: 100%; /* Make sure it is responsive */
        }
    </style>
    
    <script>
        function toggleForm(formType) {
            document.getElementById('signupForm').style.display = formType === 'signup' ? 'block' : 'none';
            document.getElementById('signinForm').style.display = formType === 'signin' ? 'block' : 'none';
        }
    </script>
</head>
<body class="bg-light">
    <div class="container py-3">
        
        <h1 class="text-center mb-4">Welcome to Timesheet Management</h1>

        <!-- Navigation for toggling -->
        <div class="text-center mb-4">
            <button class="btn btn-link" onclick="toggleForm('signin')">Sign In</button>
            <button class="btn btn-link" onclick="toggleForm('signup')">Sign Up</button>
        </div>

        <!-- Sign In Form -->
        <div id="signinForm" class="card p-4 shadow-sm" style="display: block;">
            <form action="auth.php" method="POST">
                <div class="mb-3">
                    <label for="signin_email" class="form-label">Email:</label>
                    <input type="email" id="signin_email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signin_password" class="form-label">Password:</label>
                    <input type="password" id="signin_password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="action" value="signin" class="btn btn-success w-100">Sign In</button>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div id="signupForm" class="card p-4 shadow-sm" style="display: none;">
            <form action="auth.php" method="POST">
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
                <button type="submit" name="action" value="signup" class="btn btn-primary w-100">Sign Up</button>
            </form>
        </div>
    </div>

</body>
</html>
