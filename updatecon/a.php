<?php
$serverlist=[
["creative","cmp"],
["smp","smp"]
];
while (true) {
foreach ($serverlist as $server){
echo("updatecon:updating ".$server[0].PHP_EOL); 
$ch=curl_init('https://minecraft.novylen.net/map/'.$server[0].'/standalone/MySQL_configuration.php');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0' );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res=curl_exec($ch);
if ((!curl_errno($ch))&&curl_getinfo($ch, CURLINFO_HTTP_CODE)===200) {           
file_put_contents('/srv/http/novy/config/'.$server[1].'.json',$res);
echo("updatecon:update ".$server[0]." successfully".PHP_EOL); 
} else {
echo("updatecon:update ".$server[0]."not successfully".PHP_EOL); 
} 
}
sleep(60*60*24*10);
}
?>
