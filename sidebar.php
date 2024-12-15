
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white flex-column p-3" style="width: 250px; height: 100vh;">
            <h2 class="text-center mb-4"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></h2>
            <ul class="navbar-nav flex-column">
                <li class="nav-item mb-2">
                    <a href="profile.php" class="nav-link text-white">Profile</a>
                 </li>
                <li class="nav-item mb-2">
                    <a href="tasks.php" class="nav-link text-white">Tasks</a>
                </li>
                <?php if($role =='employer'){?>
                <li class="nav-item mb-2">
                    <a href="users.php" class="nav-link text-white">Users</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
        </nav>