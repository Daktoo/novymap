<?php
header('Content-Type: application/json');
$MCSERVER=$_SERVER['MCSERVER'];
if ($MCSERVER==="smp"){
	$decodedraw=json_decode(file_get_contents("/srv/http/novy/config/smp.json"),true);
} else {
	$decodedraw=json_decode(file_get_contents("/srv/http/novy/config/cmp.json"),true);
}
$decodedraw["components"][]=[
      "text" => "",
      "linkurl"=> "https://novy.daktoinc.co.uk/",
      "position"=> "top-left",
      "type"=> "logo",
      "logourl" =>"images/novymap-qvh.png"
];
if ($MCSERVER="smp"){
$decodedraw["components"][]=[
    "allowurlname" => false,
      "type" => "chat"
];
$decodedraw["components"][]=[
      "focuschatballoons" => false,
      "type" => "chatballoon"
];
$decodedraw["components"][]=[
	 "showplayerfaces"  => true,
      "sendbutton" => false,
      "type"=> "chatbox",
      "messagettl" => 5
      ];

}
function comphijack($option,$key){
global $decodedraw;

	$setted=true;
$tmpcomp=[];
foreach ($decodedraw["components"] as $inarry) {
	if(isset($inarry[$option])){
		$inarry[$option]=$key;
		$setted=false;
	}
	$tmpcomp[]=$inarry;
}
if ($setted){
		$tmpcomp[]=[$option=>$key];

}


$decodedraw["components"]=$tmpcomp;
}



	$tempworlds=[];
foreach ($decodedraw["worlds"] as $world) {
if ($MCSERVER="smp"){
	if ($world["name"]==="world"){
		$world["title"]="Overworld";
	}
}
	
	$tempmap=[];
foreach ($world["maps"] as $map) {
	if ($map['name']=== "flat"){
$map['title']="2D";
	} elseif ($map['name']=== "surface"){
$map['title']="3D";
	}
	$map['mapzoomin']=9999;
$tempmap[]=$map;
}
$world["maps"]=$tempmap;
$tempworlds[]=$world;
}
$decodedraw["worlds"]=$tempworlds;


comphijack("show-mcr",true);
comphijack("show-chunk",true);
comphijack("hidey",true);
comphijack("showplayerbody",true);
$decodedraw['dynmapversion']=$decodedraw['dynmapversion']."-novymap";
$decodedraw['defaultmap']="flat";
$decodedraw['title']="Novymap";
$decodedraw['msg-maptypes']="Map Type";
unset($decodedraw['confighash']);
echo(json_encode($decodedraw));

//var_dump($decodedraw);
?>
