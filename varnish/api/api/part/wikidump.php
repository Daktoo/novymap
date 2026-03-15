<?php
function api_wikidump($conn) { 
$conn=reconnectdb($conn);

// Initialize response array
$response = [
    'request'=>['dial' => $dial]
];

// Build SQL query
$query = "
    SELECT n.wiki,n.id,n.admin, n.name, n.dial, n.x, n.y,n.shot , n.z, m.name AS marker_name, n.info
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
    
    exit();
}

// Fetch results
$response= <<< AAAA
{|border=1
|-
| '''Location'''
| '''Stargate Name'''
| '''Built By'''
| '''Date'''
| '''Description'''
|-
AAAA;

  while ($row = mysqli_fetch_assoc($result)) {
if (empty($row['wiki']) or parse_url($row['wiki'], PHP_URL_HOST) === "wiki.minecraft.novylen.net" ){
$name='[['.$row['name'].']]';
$name='[['.$row['name'].']]';
} else {
$name='['.$row['wiki'].' '.$row['name'].']';
}

$response .= <<< AAAA

| $name
| $row[dial]
| Unknown
| Unknown
| $row[info]
|-
AAAA;

  }
  $response.='}';
// Close DB connection

mysqli_close($conn);
// Return JSON response
return($response);
}

?>
