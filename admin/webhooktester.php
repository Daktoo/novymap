<?php
include 'adm.phphidden';
$admpagetitle="Server Info";
$MSG="WebHook Tester :wrench::triangular_flag_on_post::book:";
	 pageView($MSG);
	echo(admin_head($admpagetitle));
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

 </div>
<?php
include '../shared/footer.php';

?>
