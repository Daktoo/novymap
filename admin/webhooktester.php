<?php
include 'adm.phphidden';
$admpagetitle="WebHook Tester and Scolling tester";
$MSG="WebHook Tester and Scolling tester :wrench::triangular_flag_on_post::book:";
	 pageView($MSG);
	echo(admin_head($admpagetitle,'<link rel="stylesheet" href="/css/scrollwtf.css">'));
	echo(admin_navbar());

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                webhookmsg_admin($_POST['msg']);
	}
?>
 
<div class="center">
<div class="settings-container ">
 <form action="" class="form" method="post">
            <label for="name">msg:</label>
	    <textarea type="text" id="msg" name="msg" class="input" placeholder="fuck" required>
</textarea>
                      <input type="submit" value="Send" id="submit-btn" class="input">

</form>
</div>
<div class="settings-container ">
  <div class="scroll-out"> 
<div class="scroll1-outrot"> 
<div>
<p class="scroll1-inrot">
This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.This is really long paragraph.
</p>
</div>
</div>
</div>
</div>
 </div>
<?php
include '../shared/footer.php';

?>
