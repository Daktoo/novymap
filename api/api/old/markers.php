<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include('../../shared/db.php');

// Initialize response array
$response = [];

// Build SQL query to fetch markers
$query = "SELECT id, name, icon FROM marker WHERE 1";

// Execute query
$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
    
    // Log API usage even on failure

    exit();
}

// Fetch results
$response['markers'] = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close DB connection
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>

<?php

// Discord-style API usage logging
?>
