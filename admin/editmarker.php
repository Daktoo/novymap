<?php
include 'adm.phphidden';
$pagetitle="Edit Marker";
pageView("edit poi :wrench::triangular_flag_on_post::paintbrush:");
	echo(admin_head($pagetitle,'<script src="/js/admin_poi.js"></script>'));
	echo(admin_navbar());
?>
<body>
<div class="center">
    <div class="settings-container-top">
        <form action="" class="form" method="post">
            <label for="id">ID:</label>
	    <input type="number" id="id" name="id" class="input" placeholder="ID" value="<?php
                $daid =  intval($_GET['id']);
 if (isset($_GET['id'])){echo $_GET['id'];}?>" required>

            <?php
	$error="";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$san=sqlsan([
                  'id' =>  $daid,
                'name' => $_POST['name'],
                'icon' => $_POST['icon']],$conn);
                    $query = "UPDATE `marker` SET `name`='$san[name]',`icon`='$san[icon]' WHERE `id` = $san[id];";
                    $result = mysqli_query($conn, $query);
                    sqlEdit("Edited marker :wrench::triangular_flag_on_post::paintbrush: ```sql\n".$query."````$result`");
    
                    if ($result) {
                        $error="<p class='success'>Marker updated successfully!</p>";
                        header('Location: admin_marker');
                    } else {
                        $error="<p class='error'>Failed to edit Marker!</p>";
                    }
            }
            if (isset($_GET['id'])){
                $sql = "SELECT icon,id,name FROM marker WHERE id = $daid;";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
		$san=htmlsan([       
			'id'   => $row['id'],
                    'name' => $row['name'],
		'icon' => $row['icon']
		]);
                }
            }
            ?>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="input" placeholder="Name" value="<?php if (isset($_GET['id'])){echo $san['name'];}?>" required>

            <label for="icon">Icon:</label>
            <input type="icon" id="icon" name="icon" class="input" placeholder="Icon" value="<?php if (isset($_GET['id'])){echo $san['icon'];}?>" hidden required>
	    <div id="fake-icon" class="dropdown-fake input" onclick='document.getElementById("icon-dropdown").toggleAttribute("open")'>
<img class="drowdrop-fake-img" src="https://map.novymap-qvh.top/hack/_markers_/
<?php if (isset($_GET['id'])){echo $san['icon'];}?>
.png">
<p class="drowdrop-fake-text">
<?php if (isset($_GET['id'])){echo $san['icon'];}?>
</p>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="dropdown-fake-arrow"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M7 10l5 5 5-5H7z"></path></svg>
</div>
<details id="icon-dropdown" class="dropdown">
    <summary id="icon-dropdown-head" class="dropdown-head"></summary>
<?php


	$RAW=array_diff(scandir("/etc/novy/map/markers/"), array('..', '.'));
	$PRO=str_replace(".png","",$RAW);
foreach ($PRO as $value) {


    echo (dropdownbtu("icon",$value,$value,"https://map.novymap-qvh.top/hack/_markers_/".$value.".png")); 
   }

?>
</details>


                      <input type="submit" value="Update Marker" id="submit-btn" class="input">
		      <input type="button" value="Delete Marker" id="submit-btn" class="input" onclick="rufksure(&quot;deletemarker?id=<?php echo($daid);?>&quot;,&quot;marker&quot;)">
<a id="submit-btn" class="input" href="/admin_marker">Cancel and Return to Manage Marker</a>
        </form>
<?php
echo ("<p class='error'>".$error."</p>"); 
?>

    </div>
</div>    <?php include '../shared/footer.php'; ?>
</body>

