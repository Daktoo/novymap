    <?php 
    include '../adm.phphidden';
  include 'st.phphidden';
 
function statsanitiser ($arry,$aaaa){
$back="";
    foreach ($arry as $value){ 
	if ($value[0]===$aaaa){
	$back=$aaaa;
	}
    }
if (empty($back)){
	return $arry[0][0];
} else {

	return $back;
}
} 

$viewtoggle=[
["bar","Bar Chart"],
["bubble","Bubble Chart"],
["doughnut","Doughnut Chart"],
["pie","Pie Chart"],
["line","Lie Chart"],
["polarArea","Polar Area Chart"],
["radar","Radar Chart"],
["scatter","Scatter Chart"],
["table","Table"]
];
$aggregation=[
[0=>"day",1=>"Daily"],
[0=>"week",1=>"Weekly"],
[0=>"month",1=>"Monthly"]
];
 
$san=htmlsan([                  
'fromDate' => $_GET['from'] ?? '',
'toDate' => $_GET['to'] ?? '',               
]);

$san['aggregation']=statsanitiser($aggregation,$_GET['aggregation'] ?? $aggregation[0][0] );
$san['viewtoggle']=statsanitiser($viewtoggle,$_GET['viewtoggle'] ?? $viewtoggle[0][0]  );

$datalist=fatchstats($san['fromDate'],$san['toDate'],$san['aggregation'],$conn,true);
$san['tabid']=statsanitiser($datalist,$_GET['tabid'] ?? $datalist[0][0] );



 $customhead="<link rel=\"stylesheet\" href=\"css/stuff.css\">";
    $customhead.="<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";
  
$customhead.="<script src=\"js/wtf.js/";
	$customhead.="?";


	$customhead.="from=".$san['fromDate'];
$customhead.="&to=".$san['toDate'];
$customhead.="&aggregation=".$san['aggregation'];
$customhead.="\"></script>";
$pagetitle="Stats";



pageView("Stats :wrench::triangular_flag_on_post::book:");
echo(admin_head($pagetitle,$customhead));
	echo(admin_navbar());


?>

<body>
<div class="center">
<div class="settings-container-top">
    <h1 class="qvhtile">📊 Stats</h1>
    <form id="stats-from" class="form" method="get">
  <label for="fromdate">From:</label>
        <input class="input" type="date" id="fromdate" name="from" value="<?php echo($san['fromDate']); ?>">
  <label for="todate">To:</label>
        <input class="input" type="date" name="to" id="todate" value="<?php echo($san['toDate']); ?>">
  <label for="aggregation">Aggregation:</label>
                <select class="input" id="aggregation" name="aggregation">
<?php
foreach ($aggregation as $ah) {
	$result='<option value="';
	$result.=$ah[0];
	$result.='" ';
	$result.= $san['aggregation'] === $ah[0] ? 'selected="" ' : '' ;
	$result.='> ';
	$result.=$ah[1];
	$result.='</option>';
	echo $result;
}
?>
        </select>
  <label for="viewtoggle">Bar type:</label>
        <select id="viewtoggle" name="viewtoggle" class="input">
<?php
foreach ($viewtoggle as $ah) {
	$result='<option value="';
	$result.=$ah[0];
	$result.='" ';
	$result.= $san['viewtoggle'] === $ah[0] ? 'selected="" ' : '' ;
	$result.='> ';
	$result.=$ah[1];
	$result.='</option>';
	echo $result;
}
?>
        </select>
        <input id="tabid-input" name="tabid" hidden="">
    </form>
    </div>

<div>
<div class="settings-container-top ">
<?php
$eh='<div class="tabar">';
foreach ($datalist as $ha) {
	$eh.='<button';
	$eh.= $san['tabid'] === $ha[0] ? ' data-tabselected="" ' : '' ;
	$eh.=' id="'. $ha[0] .'tabtu" data-tabid="'.$ha[0].'"';
	$eh.= 'class="tabtu" >';
	$eh.='<span data-tabid="'.$ha[0].'"' . ' class="tabar-text">'.$ha[1].'</span>';
	$eh.='<span data-tabid="'.$ha[0].'"'. ' class="tabar-smalltext">'.$ha[4]. '</span>'.'</button>';
}
$eh.='</div>';
foreach ($datalist as $ah) {
$eh.=' <details class="tabpage" data-tabid="'.$ah[0].'" name="admin-stats-tab" id="'. $ah[0] .'tab"';
	$eh.= $san['tabid'] === $ah[0] ? 'open="" ' : '' ;
	$eh.= '>' ;

$eh.='<summary class="dropdown-head"></summary>';
$eh.='<h1  class="qvhtile">'.$ah[3] . ' Distribution </h1>';
$eh.='<h1 class="qvhtilesmall">'.$ah[4] . '</h1>';
    $eh.='<div class="stats-chart-container">';
        $eh.='<canvas class="stats-canvas" id="'. $ah[0] .'Chart"></canvas>';
        $eh.='<table id="'.$ah[0].'Table" style="display: none;">';
       $eh.=' </table>';
   $eh.=' </div>';
$eh.='</details>';
}
echo($eh);



?>
</div>

             


</div>
</div>
<?php
 foreach ($datalist as $value){ 
	if ($value[0]==='oss'){
	 echo $value[0];}
 }

 include '../../shared/footer.php'; ?>
</body>
</html>
