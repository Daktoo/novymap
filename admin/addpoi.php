<?php
include 'adm.phphidden';
$pagetitle="Add Poi";
pageView("Add POI :wrench::triangular_flag_on_post::pen_fountain:");
	echo(admin_head($pagetitle,'<script src="/js/admin_poi.js"></script>'));
	echo(admin_navbar());


?>
<body>
<div class="center">
    <div class="settings-container-top">
        <form action="" enctype="multipart/form-data" class="form" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="input" placeholder="Name" required>

            <label for="dial">Dial:</label>
            <input type="text" id="dial" name="dial" class="input" placeholder="Dial" required>

            <label for="x">X:</label>
            <input type="number" id="x" name="x" class="input" placeholder="X" required>

	 <label for="y">Y:</label>
            <input type="number" id="y" value="64" name="y" class="input" placeholder="X" required>


            <label for="z">Z:</label>
            <input type="number" id="z" name="z" class="input" placeholder="Z" required>

            <label for="marker">Marker:</label>
            <input type="number" id="marker" name="marker" class="input" hidden="" required=""></input>
            <div id="fake-marker" type="button" class="dropdown-fake input" onclick='document.getElementById("marker-dropdown").toggleAttribute("open")'> </div>
<details id="marker-dropdown" class="dropdown">
    <summary id="marker-dropdown-head" class="dropdown-head"></summary>

                <?php
                $sql = "SELECT `id`, `name`, `icon` FROM `marker`;";
                $result = mysqli_query($conn, $sql);
		$error='';

                while ($row = mysqli_fetch_assoc($result)) {
		$san=htmlsan([
                    'id' => $row['id'],
                    'name' => $row['name'],
		    'icon' => $row['icon']
		]);
    echo (dropdownbtu("marker",$san['name'],$san['id'],"https://map.novymap-qvh.top/hack/_markers_/".$san['icon'].".png")); 

                }
                ?>
</details>

            <label for="info">Info:<sup class="admin-notreq">*</sup></label>
            <textarea id="info" name="info" class="ta" placeholder="Info"></textarea>
            <label for="info">Screenshot:<sup class="admin-notreq">*</sup></label>
	    <input type="file" id="shot-upload" name="screenshot" <?php echo($shotallowfiletag); ?> class="input">

            <input type="submit" value="Add POI" id="submit-btn" class="input">
 <input type="button" value="Cancel and Return to Manage POI" id="submit-btn" class="input" onclick='window.location.assign("/admin_poi")'>
<p class="admin-notreq">Not Required<sup class="admin-notreq">*</sup></p>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$shotid='No Screenshot';

$rawstatus=shothandler($_FILES["screenshot"]); 
$uploaded=$rawstatus[0];
$uploadfailed=$rawstatus[1];
$shotid=$rawstatus[2];
$error=$rawstatus[3];

	$sen=sqlsan(['name' =>   $_POST['name'], 
           'dial' =>   $_POST['dial'], 
           'x' =>      $_POST['x'],
           'y' =>      $_POST['y'],
           'z' =>      $_POST['z'],
           'marker' => $_POST['marker'],
           'info' =>   $_POST['info'],
	   'admin' =>  $fuckinguserinfo['name']],$conn);


            if ($sen['x'] > 20001 || $sen['x'] < -20001 || $sen['z'] > 20001 || $sen['z'] < -20001) {
                $error="The cordiantes are outside of the map";
	    } elseif($uploadfailed){}else {

                          $query = "INSERT INTO `novy`( `id`, `name`, `dial`, `x`,`y`, `z`, `marker`, `info`,`admin`,`shot`) VALUES (NULL, '$sen[name]', '$sen[dial]', $sen[x],$sen[y], $sen[z], $sen[marker], '$sen[info]','$sen[admin]','$shotid')";
                $result = mysqli_query($conn, $query);
	    $newid=mysqli_insert_id($conn);

                if ($result) {
                    $error="POI added successfully!";
                    sqlEdit("added poi :wrench::triangular_flag_on_post::pen_fountain: ```sql\n".$query."````$result`");
                } else {
                    $error="Failed to add POI!";
                }
            }

        }
        
echo ("<p class='error'>".$error."</p>"); 

        ?>
    </div>
</div>    <?php include '../shared/footer.php'; ?>
</body>

