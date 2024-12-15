<?php
// config.php
$db = new mysqli("localhost", "root", "", "timesheet_app");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

session_start();
?>