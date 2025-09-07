<?php
function api_cords($conn,$rawx,$rawz,$rawr,$rawa,$rawd) {
// Sanitize input parameters
$x =  is_numeric($rawx) ? intval($rawx) : 0  ;
$z =  is_numeric($rawz) ? intval($rawz) : 0  ;
$r =  is_numeric($rawr) ? intval($rawr) : 256;
$a =  is_numeric($rawa) ? intval($rawa) : 10 ;
$d =  is_numeric($rawd) ? intval($rawd) : 10 ;

// Check coordinate bounds
if ($x < -20000 || $x > 20000 || $z < -20000 || $z > 20000) {
    http_response_code(400);
    return(['error' => 'Coordinates out of range (-20000 to 20000).']);
    
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
    SELECT n.admin,n.shot,n.id, n.name, n.dial, n.x,n.y, n.z, m.name AS marker_name, n.info,
           (POWER(n.x - $x, 2) + POWER(n.z - $z, 2)) AS distance
    FROM novy n
    JOIN marker m ON n.marker = m.id
    WHERE ABS(n.x - $x) <= $r AND ABS(n.z - $z) <= $r
";

if ($d === 1) {
    $query .= " AND n.dial != 'N/A'";
}

$query .= " ORDER BY distance DESC" ;
if ($a > 0){
	$query .=" LIMIT $a";
}
// Execute query
$result = mysqli_query($conn, $query);
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

if (!$result) {
    http_response_code(500);
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    header('Content-Type: application/json');
    return($response);

    exit();
}



// Return JSON
    return($response);
}

?>
