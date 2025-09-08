<?php
include_once("san.php");
include_once("credential.php");
$gitea_auth_header=['Authorization: token '.$gitea_autkey];      
$gitea_based_url='https://auth.novymap-qvh.top/api/v1/';   

function gitea_userinfo($name) {
global $gitea_auth_header, $gitea_based_url;
$ch = curl_init($gitea_based_url . "users/" . $name);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$gitea_auth_header );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$rawjson = curl_exec($ch);
$fucked = [
	"pfp" => "https://cdn.discordapp.com/embed/avatars/0.png",	
	"name" => $name	
	];

if (curl_errno($ch)) {           
	return  $fucked;	

}           

$decodejson=json_decode($rawjson,true);
if (curl_getinfo($ch, CURLINFO_HTTP_CODE)===200) {
	return gitea_userinfo_parser($decodejson);
}
	return  $fucked;	

}

function gitea_userinfo_parser($decodejson){
	$name= empty($decodejson['full_name']) ? $decodejson['username'] : $decodejson['full_name'] ;
	$pro= empty($decodejson['pronouns']) ? "" : " (" . $decodejson['pronouns'] . ")";
	return [
	"pfp" => $decodejson['avatar_url'],	
	"name" => $name . $pro,
	"rawname" => $decodejson['username'],
	"desc" => $decodejson['description'],
	"website" => $decodejson['website']
	] ;
		
}


function gitea_gencredit() {

global $gitea_auth_header, $gitea_based_url;

$gitea_org_name="novymap-qvh";
$res="";

$ch = curl_init($gitea_based_url . "orgs/" . $gitea_org_name .  "/teams?page=1&limit=-1");
    curl_setopt($ch, CURLOPT_HTTPHEADER,$gitea_auth_header );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$rawteamjson = curl_exec($ch);
$fucked = '<h1 class="qvhtile"> The credits page crashed ouch!!! No credits for our members ig ;-; </h1>';
	
if (curl_errno($ch)) {
        return  $fucked;

}
if (curl_getinfo($ch, CURLINFO_HTTP_CODE)===200) {

$decodeteamjson=json_decode($rawteamjson,true);
$biguserar=[];
foreach ($decodeteamjson as $teaminfo){

$chh = curl_init($gitea_based_url . "teams/" . $teaminfo['id'] .  "/members?page=1&limit=-1");
    curl_setopt($chh, CURLOPT_HTTPHEADER,$gitea_auth_header );
curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
$rawuserjson = curl_exec($chh);
	
if (curl_errno($chh)) {
        return  $fucked;

}

$decodeuserjson=json_decode($rawuserjson,true);
foreach ($decodeuserjson as $rawinfo){
	$memberinfowo=htmlsan(gitea_userinfo_parser($rawinfo,true));
	$rauwuname=$memberinfowo['rawname'];
	if (empty($teaminfo['description'])){
		$teamname= $teaminfo['name'];
	} else {
		$teamname= $teaminfo['description'];
	}
	if (isset($biguserar[$rauwuname])){
		$biguserar[$rauwuname]['team'].=" & " . $teamname;
	}else{
	$biguserar[$rauwuname]=$memberinfowo;
		$biguserar[$rauwuname]['team']=$teamname;
	}
}
}
foreach ($biguserar as $memberinfo){

$res .= '<div class="staff-member">';
$res .= "<img src=\"$memberinfo[pfp]\" alt=\"$memberinfo[name]\" class=\"staff-image\">";
if (empty($memberinfo['website'])) {
	$res .= "<h3 class=\"staff-name\">$memberinfo[name]</h3>";
} else {

	$res .= "<p class=\"staff-name\"><a href=\"$memberinfo[website]\" >$memberinfo[name]</a></p>";
}

	$res .= "<h3 class=\"staff-role\">". $memberinfo['team'] ."</h3>";
if (empty($memberinfo['desc'])) {
	$res .= "<p class=\"staff-desc\">\"This member has forgot to put the description of themselves.\"</p>";
} else {

	$res .= "<p class=\"staff-desc\">\"$memberinfo[desc]\"</p>";
}

$res .= '</div>';

}


}
 return $res;


        return $fucked;


}




?>

