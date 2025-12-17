<?php
function api_info_railline($conn,$rawid=0) { 
	$conn=reconnectdb($conn);

	// Initialize response array
$id=intval($rawid);
$response = [
    'request'=>['id' => $id]
];

// Build SQL query
$query = "
    SELECT *  From `lines` where id=$id
";


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
		  $response['data']=$row;
if (!(empty($row['admin'])||$row['admin']==="???")){

		$response['data']['addedby'] = $response['data']['admin'] ;
		  }else{
		$response['data']['addedby'] = "Who?";
		  }
		  unset($response['data']['admin']);


if (empty($response['data']['wiki']) ){
$response['data']['wiki']="Not On Wiki";
}
	  }

mysqli_close($conn);
// Return JSON response
return($response);
}

?>
