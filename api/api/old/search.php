<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection
include('../../shared/db.php');

// Get and sanitize the 'q' (search query) parameter
$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

// Get and sanitize the 'a' (amount of results) parameter, default to 10
$a = isset($_GET['a']) && is_numeric($_GET['a']) ? (int)$_GET['a'] : 10;

// Get the 'w' (what to search in) parameter, default to 'both'
$w = isset($_GET['w']) ? mysqli_real_escape_string($conn, $_GET['w']) : 'both';

// Get the 'd' (dial filter) parameter, default to 0 (search all)
$d = isset($_GET['d']) ? (int)$_GET['d'] : 0;

// Debugging: Initialize the response array with the query parameters
$response = [
    'request'=> ['q' => $q,
    'a' => $a,
    'w' => $w,
    'd' => $d]
];

// Start building the SQL query
$query = "SELECT n.id, n.name, n.dial, n.x,n.y, n.z,n.shot, m.name AS marker_name, n.info
          FROM novy n
          JOIN marker m ON n.marker = m.id";

// Prepare the WHERE clause based on the filters
$whereClauses = [];

// If 'q' is provided, search in the specified columns (name, dial, or both)
if ($q) {
    if ($w == 'name' || $w == 'both') {
        $whereClauses[] = "n.name LIKE '%$q%'";
    }
    if ($w == 'dial' || $w == 'both') {
        $whereClauses[] = "n.dial LIKE '%$q%'";
    }
}

// If 'd' is 1, filter out 'N/A' values in the 'dial' column
if ($d == 1) {
    $whereClauses[] = "n.dial != 'N/A'";
}

// If there are any WHERE conditions, apply them to the query
if (!empty($whereClauses)) {
    $query .= " WHERE " . implode(' AND ', $whereClauses);
}

// Limit the number of results based on the 'a' parameter
$query .= " LIMIT $a";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    // If query fails, return an error message and stop further execution
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    echo json_encode($response);
    exit();
}


// Close the database connection

// Add the data to the response
$response['data'] = [];
  while ($row = mysqli_fetch_assoc($result)) {
		  $response['data'][$row['id']]=$row;
		if (!(empty($row['shot'])||$row['shot']==="No Screenshot"))
		{
		$response['data'][$row['id']]['screeshot'] = 'https://api.novymap-qvh.top/shot.php?id='.$row['id'] ;
		  		} else{
		  
			$response['data'][$row['id']]['screeshot'] = 'No Screeshot';
		  		}
		  unset($response['data'][$row['id']]['shot']);
  }

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

<?php

?>
