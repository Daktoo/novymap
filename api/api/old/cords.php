<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include('../../shared/db.php');

// Sanitize input parameters
$x = isset($_GET['x']) && is_numeric($_GET['x']) ? (int)$_GET['x'] : 0;
$z = isset($_GET['z']) && is_numeric($_GET['z']) ? (int)$_GET['z'] : 0;
$r = isset($_GET['r']) && is_numeric($_GET['r']) ? (int)$_GET['r'] : 256;
$a = isset($_GET['a']) && is_numeric($_GET['a']) ? (int)$_GET['a'] : 10;
$d = isset($_GET['d']) ? (int)$_GET['d'] : 0;

// Check coordinate bounds
if ($x < -20000 || $x > 20000 || $z < -20000 || $z > 20000) {
    http_response_code(400);
    echo json_encode(['error' => 'Coordinates out of range (-20000 to 20000).']);
    
    // Log usage even on error
    exit();
}

// Prepare response structure
$response = [
   'request' => ['x' => $x,
    'z' => $z,
    'r' => $r,
    'a' => $a,
    'd' => $d]
];

// Build query
$query = "
    SELECT n.shot,n.id, n.name, n.dial, n.x,n.y, n.z, m.name AS marker_name, n.info,
           (POWER(n.x - $x, 2) + POWER(n.z - $z, 2)) AS distance
    FROM novy n
    JOIN marker m ON n.marker = m.id
    WHERE ABS(n.x - $x) <= $r AND ABS(n.z - $z) <= $r
";

if ($d === 1) {
    $query .= " AND n.dial != 'N/A'";
}

$query .= " ORDER BY distance DESC LIMIT $a";

// Execute query
$result = mysqli_query($conn, $query);
$response['data'] = [];
  while ($row = mysqli_fetch_assoc($result)) {
		  $response['data'][$row['id']]=$row;
		if (!(empty($row['shot'])||$row['shot']==="No Screenshot"))
		{
		$response['data'][$row['id']]['screeshot'] = 'https://novyapi.daktoinc.co.uk/shot.php?id='.$row['id'] ;
		  		} else{
		  
			$response['data'][$row['id']]['screeshot'] = 'No Screeshot';
		  		}
		  unset($response['data'][$row['id']]['shot']);
  }

if (!$result) {
    http_response_code(500);
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);

    exit();
}


// Close connection
mysqli_close($conn);

// Return JSON
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>

<?php
// Log API usage with Discord-style format
?>

