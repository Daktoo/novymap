<?php
function api_search($conn,$rawq,$rawa,$raww,$rawd) {
$conn=reconnectdb($conn);

$q = mysqli_real_escape_string($conn, $rawq);
$a = intval($rawa);
$w = mysqli_real_escape_string($conn, $raww);
$d = intval($rawd);
if (! ((!empty($w)) || $w == 'dial' || $w == 'name' || $w == 'both')){
          $w="both";
          }

// Debugging: Initialize the response array with the query parameters
$response = [
    'request'=> ['q' => $q,
    'a' => $a,
    'w' => $w,
    'd' => $d]
];

// Start building the SQL query
$query = "SELECT n.id,n.admin, n.name, n.dial, n.x,n.y, n.z,n.shot, m.name AS marker_name, n.info
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
if ($a > 0){
$query .= " LIMIT $a";
}
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
		  unset($response['data'][$row['id']]['admin']);

		if (!(empty($row['shot'])||$row['shot']==="No Screenshot"))
		{
		$response['data'][$row['id']]['screenshot'] = 'https://api.novymap-qvh.top/api/staging/shot?id='.$row['id'] ;
		  		} else{
		  
			$response['data'][$row['id']]['screenshot'] = 'No Screenshot';
		  		}
		  unset($response['data'][$row['id']]['shot']);
  }

mysqli_close($conn);
return $response;
}
?>
