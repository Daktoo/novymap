<?php    
header('Content-Type: application/json');
include "../../../adm.phphidden";
include "../../st.phphidden";
$san=htmlsan([
'fromDate' => $_GET['from'] ?? '',
'toDate' => $_GET['to'] ?? '',
'aggregation' => $_GET['aggregation'] ?? 'all',
]);
$datalist=fatchstats($san['fromDate'],$san['toDate'],$san['aggregation'],$conn,false);
$san['tabid']=htmlspecialchars($_GET['tabid'] ?? $datalist[0][0]);


	 $wtf=json_encode($datalist,JSON_PRETTY_PRINT);

echo($wtf."\n" );


?>
