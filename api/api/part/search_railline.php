<?php
function api_search_railline($conn,$rawq,$rawa) {

$q = mysqli_real_escape_string($conn, $rawq);
$a = is_numeric($rawa) ? (int)$rawa : 0;
$w = mysqli_real_escape_string($conn, $raww);
if (! ((!empty($w)) || $w == 'dial' || $w == 'name' || $w == 'both')){
          $w="both";
          }

// Debugging: Initialize the response array with the query parameters
$response = [
    'request'=> ['q' => $q,
    'a' => $a]
];

// Start building the SQL query
$query = "select * from `lines`";

// Prepare the WHERE clause based on the filters
$whereClauses = [];
$whereClauses[] = "name LIKE '%$q%'";
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
    return $response;
    exit();
}


// Close the database connection

// Add the data to the response
$response['data'] = [];
  while ($row = mysqli_fetch_assoc($result)) {
		  $response['data'][$row['id']]=$row;
if (!(empty($row['admin'])||$row['admin']==="???")){

		$response['data'][$row['id']]['addedby'] = $response['data'][$row['id']]['admin'] ;
		  }else{
		$response['data'][$row['id']]['addedby'] = "Who?";
		  }

		  }

// Return the results as JSON
header('Content-Type: application/json');
return $response;
}
?>
