<?php
function api_markers($conn) {
	$conn=reconnectdb($conn);

// Initialize response array
$response = [];

// Build SQL query to fetch markers
$query = "SELECT id, name, icon FROM marker WHERE 1";

// Execute query
$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    return ($response);
    
    // Log API usage even on failure

    exit();
}

// Fetch results
$response['markers'] = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close DB connection
mysqli_close($conn);

// Return JSON response
return($response);
}
?>
