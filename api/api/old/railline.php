<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection
include('../../shared/db.php');

// Initialize the response array
$response = [];

// Build the SQL query to select data
$query = "
    SELECT 
        l.id AS line_id, 
        l.name AS line_name, 
        l.color AS line_color, 
        lc.seq, 
        lc.x, 
        lc.y, 
        lc.z
    FROM `lines` l
    JOIN line_coords lc ON l.id = lc.line_id
    ORDER BY l.id, lc.seq
";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    // If query fails, return an error message and stop further execution
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    echo json_encode($response);
    exit();
}

// Fetch all results as an associative array

// Format train/lines data
$trains = [];
while ($trainRow = mysqli_fetch_assoc($result)) {
    $lineId = $trainRow['line_id'];
    if (!isset($trains[$lineId])) {
        $trains[$lineId] = [
            "color" => $trainRow['line_color'],
            "markup" => false,
            "x" => [],
            "y" => [],
            "z" => [],
            "label" => $trainRow['line_name'],
            "opacity" => 0.80,
            "weight" => 3
        ];
    }
    $trains[$lineId]["x"][] = $trainRow['x'];
    $trains[$lineId]["y"][] = $trainRow['y'];
    $trains[$lineId]["z"][] = $trainRow['z'];
}



// Close the database connection
mysqli_close($conn);

// Add the data to the response
$response['data'] = $trains;

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>


<?php

?>
