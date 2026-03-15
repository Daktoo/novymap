<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include('../../shared/db.php');

// Get and sanitize 'dial' parameter
$dial = isset($_GET['dial']) ? intval($_GET['dial']) : 0;

// Initialize response array
$response = [
    'request'=>['dial_param' => $dial]
];

// Build SQL query
$query = "
    SELECT n.id, n.name, n.dial, n.x, n.y,n.shot , n.z, m.name AS marker_name, n.info
    FROM novy n
    JOIN marker m ON n.marker = m.id
";

if ($dial === 1) {
    $query .= " WHERE n.dial != 'N/A'";
}

// Execute query
$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
    
    // Log the API usage even if query fails

    exit();
}

// Fetch results
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
// Close DB connection
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>

<?php
// Discord-style API usage logging

?>

