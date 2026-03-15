<?php
include_once "credential.php";
// db.php

// Create a database connection
$conn = "";

function reconnectdb($conn){
global $conn ;
global $db_host ;
global $db_username ;
global $db_password ;
global $db_database ;

if (!empty($conn->server_info)) {
	$conn->close();
}

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);

// Check the connection
if (empty($conn->server_info)) {
    die("connection failed: " . mysqli_connect_error());
} else {
mysqli_set_charset($conn, "utf8mb4");

}
return $conn;

}

?>
