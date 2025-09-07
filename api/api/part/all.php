<?php
function api_all($conn,$d=0) { 

// Get and sanitize 'dial' parameter
if ($d===0 or $d===1){
$dial = intval($d);
}else {
	$dial=0;
}
// Initialize response array
$response = [
    'request'=>['dial' => $dial]
];

// Build SQL query
$query = "
    SELECT n.id,n.admin, n.name, n.dial, n.x, n.y,n.shot , n.z, m.name AS marker_name, n.info
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
    return($response);
    
    // Log the API usage even if query fails

    exit();
}

// Fetch results
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
// Close DB connection
mysqli_close($conn);

// Return JSON response
return($response);
}

?>
