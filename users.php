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
<?php include("header.php"); ?>


<div class="d-flex justify-content-between align-items-center">

    <h2 class="mb-3">Users</h2> 
    <a href="add_user.php" class='btn btn-sm btn-primary'>Add user</a>
    </div>
    <table id="timeSheetTable" class="table table-bordered table-striped">
    <thead>
        <tr> 
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM users";
    $result = $db->query($query);
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td><a href='user.php?id={$row['id']}'>{$row['user_name']}</a></td>
                <td>{$row['email']}</td>
                <td>{$row['role']}</td>
                <td>
                    <a href='edit_user.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                    <a href='delete_user.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                </td>
              </tr>";
    }
    ?>
    </tbody>
</table>

        </div>
    </div>

   
    <?php include("footer.php");  ?>


                        </body>
                        </html>