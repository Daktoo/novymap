<?php
$admpagetitle="Server Info";
include 'adm.phphidden';
include '../shared/neofetch.php';
$EMJ=":wrench::triangular_flag_on_post::book:";
$MSG="Server Info ";
 if ( $_SERVER['HTTP_X_FORWARDED_USER'] === "qvh" ) {
	 pageView($MSG . "(QVH Special Edition) " . $EMJ);
 } else {

	 pageView($MSG . $EMJ);
 }
$outputA=null;
$useless=null;
	echo(admin_head("Server Info"));
	echo(admin_navbar());

 echo '<div class="center">';
 echo '<div class="settings-container ">';
 echo(neofetch(false,$conn));
echo '</div>';

 if ( $_SERVER['HTTP_X_FORWARDED_USER'] === "qvh" ) {
 echo '<div class="settings-container ">';
	echo '<iframe id="phpwhy" class="whatqvhisdoing" >';
	echo '</iframe>';
	 echo '<script>';
	echo 'let FUCK = `';
	 phpinfo();
	echo '`;';
	echo 'document.getElementById("phpwhy").srcdoc=FUCK; '; 
	echo '</script>';
 echo '</div>';
echo '<div class="settings-container ">';
echo '<iframe class="whatqvhisdoing" srcdoc="'.htmlspecialchars(file_get_contents('/var/log/novydiscordbot/log')).'">';
echo '</iframe>';
echo '</div>';

 }
 echo '<div class="settings-container ">';
 echo '<pre class="inxioutput">';
exec('inxi -Fxz | aha --no-header', $outputA, $useless);
echo(loopoutput($outputA));
 echo '</pre>';
 echo '</div>';

 echo '<div class="settings-container ">';
	echo '<iframe class="whatqvhisdoing" src="https://wttr.in/@exkc.moe" >';

	echo '</iframe>';

 echo '</div>';

 echo '</div>';

include '../shared/footer.php';

?>
