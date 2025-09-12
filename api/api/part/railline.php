<?php
function api_railline($conn) {
$conn=reconnectdb($conn);
$response = [];

// Build the SQL query to select data
$query = "
    SELECT 
        l.id AS line_id, 
        l.name AS line_name, 
        l.color AS line_color, 
        l.info AS line_info, 
        l.admin AS line_admin, 
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
    return($response);
    exit();
}

// Fetch all results as an associative array

// Format train/lines data
$trains = [];
while ($trainRow = mysqli_fetch_assoc($result)) {
    $lineId = $trainRow['line_id'];
    if (!isset($trains[$lineId])) {
        $trains[$lineId] = [
            "id" => $trainRow['line_id'],
            "color" => $trainRow['line_color'],
            "x" => [],
            "y" => [],
            "z" => [],
            "label" => $trainRow['line_name'],
            "info" => $trainRow['line_info'] ?? ""
        ];
    }
    $trains[$lineId]["x"][] = $trainRow['x'];
    $trains[$lineId]["y"][] = $trainRow['y'];
    $trains[$lineId]["z"][] = $trainRow['z'];
if (!(empty($trainRow['line_admin'])||$trainRow['line_admin']==="???")){

		$trains[$lineId]['addedby'] = $trainRow['line_admin'] ;
		  }else{
		$trains[$lineId]['addedby'] = "Who?";
		  }

}



// Close the database connection
mysqli_close($conn);

// Add the data to the response
$response['data'] = $trains;

// Return the results as JSON
return ($response);
}

?>
