<?php
include 'adm.phphidden';
$pagetitle="Add Marker";
pageView("Add Marker :wrench::star::pen_fountain:");
	echo(admin_head($pagetitle,'<script src="/js/admin_poi.js"></script>'));
	echo(admin_navbar());

?>
<body>
<div class="center">
    <div class="settings-container-top">
        <form action="" class="form" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="input" placeholder="Name" required>

            <label for="dial">Icons:</label>
            <input type="text" id="icon" name="icon" class="input" placeholder="Icon" hidden="" required="" >
            <div id="fake-icon" class="dropdown-fake input" onclick='document.getElementById("icon-dropdown").toggleAttribute("open")'> </div>
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

            <input type="submit" value="Add Marker" id="submit-btn" class="input">
            <input type="button" value="Cancel and Return to Manage Marker" id="submit-btn" class="input" onclick='window.location.assign("/admin_marker")'>
        </form>
        <?php
	$error="";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$san=sqlsan([	
            'name'  => $_POST['name'],
	    'icon'  => $_POST['icon'],
            'admin' => $fuckinguserinfo['name'] 
	],$conn);
            $query = "INSERT INTO `marker`(`id`, `name`, `icon`,`admin`) VALUES (NULL,'$san[name]','$san[icon]','$san[admin]');";
            $result = mysqli_query($conn, $query);

            if ($result) {
        $error="Marker added successfully!";
                sqlEdit("added marker :wrench::star::pen_fountain: ```sql\n".$query."````$result`");
            } else {
                $error="Failed to add marker!";
                }
	}
echo ("<p class='error'>".$error."</p>"); 

        ?>
    </div>
</div>
</body>
    <?php include '../shared/footer.php'; ?>

