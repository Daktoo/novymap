<?php
include_once "credential.php";
// db.php

// Create a database connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);

// Check the connection
if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}
if ($conn) {
mysqli_set_charset($conn, "utf8mb4");

}


?>
