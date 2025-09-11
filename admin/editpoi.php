<?php
include 'adm.phphidden';
$pagetitle="Edit Poi";
pageView("Edit POI :wrench::triangular_flag_on_post::paintbrush:");
	echo(admin_head($pagetitle,'<script src="/js/admin_poi.js"></script>'));
	echo(admin_navbar());
?>
<body>
<div class="center">
    <div class="settings-container-top">
        <form action=""  enctype="multipart/form-data" class="form" method="post">
            <label for="id">ID:</label>
	    <input type="number" id="id" name="id" class="input" placeholder="ID" value="<?php
                $daid = intval($_GET['id']) ?? '';
 if (!empty($daid)){echo ($daid);} ?>" required>

            <?php
$error='';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $san=sqlsan([
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'dial' => $_POST['dial'],
                'x' => $_POST['x'],
                'z' => $_POST['z'],
                'y' => $_POST['y'],
                'marker' => $_POST['marker'],
                'info' => $_POST['info']],$conn);
                    
$rawstatus=shothandler($_FILES["screenshot"]); 
$uploaded=$rawstatus[0];
$uploadfailed=$rawstatus[1];
	$shotid=$rawstatus[2];

$error=$rawstatus[3];


                if ($san['x'] > 20001 || $san['x'] < -20001 || $san['z'] > 20001 || $san['z'] < -20001) {
                    $error="The cordiantes are outside of the map";
                } elseif($uploadfailed){} else {
if ($shotid==="No Screenshot"){
	$shotsql="";
}else {
        $query = "SELECT `shot` FROM novy WHERE id = $daid;";
                    $result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($result)) {
		$removeshot=$row['shot'];
		}
if (!($removeshot === "No Screenshot")) {
	unlink("/srv/http/novy/shot2/".$removeshot.".png");
}
	$shotsql=",`shot`='$shotid'";
}
                    $query = "UPDATE `novy` SET `name`='$san[name]',`dial`='$san[dial]',`x`='$san[x]',`y`='$san[y]',`z`='$san[z]',`marker`='$san[marker]',`info`='$san[info]' $shotsql WHERE `id` = $san[id];";
                    $result = mysqli_query($conn, $query);
                    sqlEdit("edited poi :wrench::triangular_flag_on_post::paintbrush: ```sql\n".$query."````$result`");
    
                    if ($result) {
                        $error="POI updated successfully!";
                        header('Location: admin_poi');
                    } else {
                        $error="Failed to edit POI!";
                    }
                }
            }
            if (isset($_GET['id'])){
                $sql = "SELECT novy.shot, novy.id, novy.name, novy.dial, novy.info, novy.x, novy.z,novy.y, marker.icon AS marker_icon , marker.id AS marker_id, marker.name AS marker_name FROM novy JOIN marker ON novy.marker = marker.id WHERE novy.id = $daid;";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
			$san=htmlsan([
                    'id' =>       $row['id'],
                    'name' =>     $row['name'],
                    'dial' =>     $row['dial'],
                    'info' =>     $row['info'],
                    'x' =>        $row['x'],
                    'z' =>        $row['z'],
                    'y' =>        $row['y'],
                    'markerid' => $row['marker_id'],
                    'category' => $row['marker_name'],
                    'shot' =>     $row['shot'],
                    'icon' =>     $row['marker_icon']]);
                }
            }
            ?>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="input" placeholder="Name" value="<?php if (isset($_GET['id'])){echo $san['name'];}?>" required>

            <label for="dial">Dial:</label>
            <input type="text" id="dial" name="dial" class="input" placeholder="Dial" value="<?php if (isset($_GET['id'])){echo $san['dial'];}?>" required>

            <label for="x">X:</label>
            <input type="number" id="x" name="x" class="input" placeholder="X" value="<?php if (isset($_GET['id'])){echo $san['x'];}?>" required>

   <label for="y">Y:</label>
	    <input type="number" id="y" name="y" class="input" placeholder="Y" value="<?php if (isset($_GET['id'])){echo $san['y'];}?>" required>

            <label for="z">Z:</label>
            <input type="number" id="z" name="z" class="input" placeholder="Z" value="<?php if (isset($_GET['id'])){echo $san['z'];}?>" required>

            <label for="marker">Marker:</label>
            <input type="number" id="marker" name="marker" class="input" placeholder="marker" value="<?php if (isset($_GET['id'])){echo $san['markerid'];}?>" hidden required>
<div id="fake-marker" type="button" class="dropdown-fake input" onclick="document.getElementById(&quot;marker-dropdown&quot;).toggleAttribute(&quot;open&quot;)">
<img class="drowdrop-fake-img" src="https://map.novymap-qvh.top/hack/_markers_/
<?php if (isset($_GET['id'])){echo $san['icon'];}?>.png">
<p class="drowdrop-fake-text">
<?php if (isset($_GET['id'])){echo $san['category'];}?>
</p>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="dropdown-fake-arrow"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M7 10l5 5 5-5H7z"></path>
</svg>
</div>
<details id="marker-dropdown" class="dropdown">
    <summary id="marker-dropdown-head" class="dropdown-head"></summary>
                <?php
                $sql = "SELECT `id`, `name`, `icon` FROM `marker`;";
                $result = mysqli_query($conn, $sql);
		
                while ($row = mysqli_fetch_assoc($result)) {
			$saan=htmlsan([
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'icon' => $row['icon']]);
            echo (dropdownbtu("marker",$saan['name'],$saan['id'],"https://map.novymap-qvh.top/hack/_markers_/".$saan['icon'].".png")); 

		}
                ?>
            </details>

            <label for="info">Info:</label>
            <textarea id="info" name="info" class="ta" placeholder="Info"><?php if (isset($_GET['id'])){echo $san['info'];}?></textarea>
            <label >New Screenshot:</label>
<input type="file" id="shot-upload" <?php echo($shotallowfiletag); ?>  name="screenshot" class="input">

            <label>Current Screenshot:</label>

<?php
		if (!(empty($san['shot'])||$san['shot']==="No Screenshot"))
		{
			echo '<img id="shot-img" class="screeshot input" src="https://api.novymap-qvh.top/api/staging/shot?id='.$san['id'].'">';
			echo '<a id="submit-btn" class="input" onclick="rufksure(&quot;deleteshot?id='.intval($_GET['id']).'&quot;,&quot;Screeshot&quot;)">Delete Screenshot</a>';
		} else {
			echo '<p>No Screenshot</p>';
		
		}
?>
            <input type="submit" value="Update POI" id="submit-btn" onclick="return shotrufksure();" class="input">
	    <input type="button" value="Delete POI" id="submit-btn" class="input" onclick="rufksure(&quot;deletepoi?id=<?php echo($daid);?>&quot;,&quot;poi&quot;)">
 <input type="button" value="Cancel and Return to Manage POI" id="submit-btn" class="input" onclick='window.location.assign("/admin_poi")'>

        </form>
<?php echo ("<p class='error'>".$error."</p>"); ?>
    </div>
</div>    <?php include '../shared/footer.php'; ?>
</body>

