<?php
include_once '../shared/san.php';
include 'adm.phphidden';
$line_id = isset($_GET['line_id']) ? intval($_GET['line_id']) : 0;
$coord_id = isset($_GET['coord_id']) ? intval($_GET['coord_id']) : 0;
$customhead="";
if ($_SERVER['PATH_INFO']==="/add"){
$pagetitle="Manage Lines";
$action="add";
} elseif ($_SERVER['PATH_INFO']==="/deline") {
$action="deline";
} elseif ($_SERVER['PATH_INFO']==="/edit") {
$pagetitle="Manage Lines";
$action="edit";
} elseif ($_SERVER['PATH_INFO']==="/delcoord") {
$action="delcoord";
} elseif ($_SERVER['PATH_INFO']==="/upcoord") {
$action="upcoord";
} elseif ($_SERVER['PATH_INFO']==="/coord") {
$pagetitle="Manage Line Coords";
$action="coord";
		$customhead='<script src="/js/admin_lines_rail_coord_editor.js"></script>';
} else {
        header("Location: /admin_lines/add");
}
        if ($action === 'add' or $action === 'edit' ) {
		$customhead='<script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>';
		$customhead.='<script src="/js/admin_lines_rail_line_editor.js"></script>';
		$customhead.='<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css">';
	}




// Handle form submissions
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    // Create or update a line
    if ($action==="edit" or $action==="add") {
$sanlineinfo=sqlsan([
        "id"    => intval($_GET['line_id'] ?? 0),
        "name"  => $_POST['name'],
        "color" => $_POST['color'],
        "info"  => $_POST['info'],
        "admin" => $fuckinguserinfo['name']
],$conn);
        if ($action==="edit") {
            $sql = "UPDATE `lines` SET info='$sanlineinfo[info]',name='$sanlineinfo[name]', color='$sanlineinfo[color]' WHERE id=$sanlineinfo[id]";
        } else {
            $sql = "INSERT INTO `lines` (name, color,admin,info) VALUES ('$sanlineinfo[name]', '$sanlineinfo[color]','$sanlineinfo[admin]','$sanlineinfo[info]')";
        }
	$result=mysqli_query($conn, $sql);
		if ($result){
        if ($action==="edit") {
			sqlEdit("Updated rail line name/color :wrench::checkered_flag::wastebasket: ```sql\n".$sql."````$result`");
        } else {
			sqlEdit("Added rail line :wrench::checkered_flag::wastebasket: ```sql\n".$sql."````$result`");
        }
		} else {
			die(mysqli_error($conn));
		}


        header("Location: /admin_lines");
    }
        // Add a coordinate at beginning, end, or middle
        if ($action === 'coord') {
        $x = intval($_POST['x']);
        $y = intval($_POST['y']);
        $z = intval($_POST['z']);
        $pos = $_POST['position']; // 'start', 'end', or 'middle'
        $seq = isset($_POST['seq']) ? intval($_POST['seq']) : null;
        // Compute new seq
        if ($pos === 'start' || $pos === 'end') {
            $res = mysqli_query($conn, "SELECT MIN(seq) AS minseq, MAX(seq) AS maxseq FROM line_coords WHERE line_id=$line_id");
            $row = mysqli_fetch_assoc($res);
            $new_seq = ($pos === 'start') ? $row['minseq'] - 1 : $row['maxseq'] + 1;
        } elseif ($pos === 'middle' && $seq !== null) {
            $new_seq = $seq;
        } else {
            die("Invalid position or sequence for middle.");
        }
        $sql = "INSERT INTO line_coords (line_id, seq, x, y, z) VALUES ($line_id, $new_seq, $x, $y, $z)";
	$result=mysqli_query($conn, $sql);
		if ($result){
			sqlEdit("Updated rail line coord :wrench::checkered_flag::wastebasket: ```sql\n".$sql."````$result`");
		} else {
			die(mysqli_error($conn));
		}


        header("Location: /admin_lines/coord?line_id=$line_id");
    }
   }
//non post api
        if ($action === 'upcoord') {
        $x = isset($_GET['x']) ? intval($_GET['x']): 0;
        $y =isset($_GET['y']) ? intval($_GET['y']) : 0;
        $z =isset($_GET['z']) ? intval($_GET['z']) : 0;
        $sql = "UPDATE line_coords SET x=$x, y=$y, z=$z WHERE id=$coord_id";
	$result=mysqli_query($conn, $sql);
		if ($result){
        header("Sqlst: ok");
			sqlEdit("Updated rail line coord :wrench::checkered_flag::wastebasket: ```sql\n".$sql."````$result`");
		} else {
        header("Sqlst: error");
			die(mysqli_error($conn));
		}
if (!($_GET['noredrect']  ==="yes")){
	header("Location: /admin_lines/add");
}else {
	echo(":3");
}
	die();
    }
        if ($action === 'delcoord') {
        $sql = "DELETE FROM line_coords WHERE id=$coord_id";
		$result=mysqli_query($conn, $sql);
		if ($result){
			sqlEdit("Updated rail line coord :wrench::checkered_flag::wastebasket: ```sql\n".$sql."````$result`");
		} else {
			die(mysqli_error($conn));
		}
        header("Location: /admin_lines/coord?line_id=$line_id");
    }
    if ($action==="deline") {
        $sql = "DELETE FROM `lines` WHERE id=$line_id";
	$result=mysqli_query($conn, $sql);
		if ($result){
			sqlEdit("Deleted Rail name/color :wrench::checkered_flag::wastebasket: ```sql\n".$sql."````$result`");
		} else {
			die(mysqli_error($conn));
		}

        header("Location: /admin_lines/add");
    }
	echo(admin_head($pagetitle,$customhead));
	echo(admin_navbar());

?>
<body>
    <div class="center">

	<?php
    if ($action !== 'coord'): 
pageView("Manage Lines :straight_ruler:");
?>

            <!-- Add/Edit Line Form -->
            <div class="settings-container">
                <h1 class="qvhtile"><?php echo ($action === 'edit') ? 'Edit Line' : 'Add New Line'; ?></h1>
                <?php
                $raweditLine = ['id'=>0, 'name'=>'', 'color'=>'','info'=>''];
                if ($action === 'edit' && $line_id > 0) {
                    $res = mysqli_query($conn, "SELECT * FROM `lines` WHERE id=$line_id");
                    $raweditLine = mysqli_fetch_assoc($res);
                }
                $editLine =htmlsan($raweditLine);

                ?>
                <form method="post" class="form">
                    <label>Name: </label><input type="text" name="name" class="input" value="<?php echo($editLine['name']); ?>" required>
		    <label>Color: </label>
<div class="input colorpick-outside"><input type="text" name="color" class="colorpicker" value="<?php  $HAHA=$editLine['color'];if(empty($HAHA)){echo("#ff00fb");} else {echo $HAHA;} ?>" required></div>
		    <label>Info: </label>
<textarea type="text" name="info" class="input" value="<?php echo $editLine['info']; ?>" >
</textarea>
                    <button type="submit" id="submit-btn"><?php echo ($editLine['id']>0)? 'Save' : 'Add Lines'; ?> </button>
 <?php echo ($editLine['id']>0)? '<button type="button" id="submit-btn" onclick="window.location.assign(&quot;/admin_lines&quot;)" >Cancel</button>' : ''; ?> 
                </form>
            </div>
	        <?php endif; ?>

	<?php if ($action === 'coord'): 
pageView("Manage Line Coords :straight_ruler:");
?>
            <?php
                // Fetch line
                $lineRes = mysqli_query($conn, "SELECT * FROM `lines` WHERE id=$line_id");
                $line = mysqli_fetch_assoc($lineRes);
            ?>
            <div id="add-coord" class="settings-container">
                <h1 class="qvhtile">Coordinates for <span id="line_id"> <?php echo htmlspecialchars($line['name'] ?? "(Error : Line Not Found)"); ?></span></h1>

                <!-- Add Coordinate Form -->
               <h1 class="qvhtilesmall"> Add New Coordinate</h1>
                <form method="post" class="form">
                    <label>X:</label><input type="number" name="x" class="input" required>
                    <label>Y:</label><input type="number" name="y" class="input" value="64" required>
                    <label>Z:</label><input type="number" name="z" class="input" required>
                    <label>Position:</label>
                        <select name="position" class="input">
                            <option value="end">End</option>
                            <option value="start">Start</option>
                        </select>
                    <button type="submit"   id="submit-btn">Add</button>
                <button href="admin_lines" type="button" onclick='window.location.assign("/admin_lines");'  id="submit-btn">&larr; Back to Lines</button>
                </form>
            </div>

            <div class="settings-container">
            <table class="table">
                <tr><th>Seq</th><th>X</th><th>Y</th><th>Z</th><th>Actions</th></tr>
                <?php
                $coordsRes = mysqli_query($conn, "SELECT * FROM line_coords WHERE line_id=$line_id ORDER BY seq ASC");
                while ($rawcoord = mysqli_fetch_assoc($coordsRes)):
                $coord =htmlsan($rawcoord);
                ?>
                <tr>
                    <td><?php echo $coord['seq']; ?></td>
                    <td><?php echo $coord['x']; ?></td>
                    <td><?php echo $coord['y']; ?></td>
                    <td><?php echo $coord['z']; ?></td>
                    <td>
                        <form method="post" class="admin-action">
                            <input type="hidden" name="coord_id" value="<?php echo $coord['id']; ?>">
			    <button type="button" class="button" onclick="showEdit(this)">Edit</button>
<div class="admin-table-bar"></div>
<button type="button" class="button" onclick='rufksure("admin_lines/delcoord?line_id=<?php echo($line_id."&coord_id=".$coord['id']); ?>","this coords")'>Delete</button>

                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
</div>
        <?php else: ?>
            <div class="settings-container ">
		<h1 class="qvhtile">Lines</h1>
<h1 class="qvhtilesmall">Tips:click the color in the table to copy it
</h1>
                <table class="table">
                    <tr><th>ID</th><th>Name</th><th>Info</th><th>Color</th><th>Added by</th><th>Actions</th></tr>
                    <?php

                    $linesRes = mysqli_query($conn, "SELECT * FROM `lines` ORDER BY id ASC");
                    while ($rawline = mysqli_fetch_assoc($linesRes)):
                $line =htmlsan($rawline);
                    ?>
                    <tr>
                        <td><?php echo $line['id']; ?></td>
                        <td><?php echo $line['name']; ?></td>
                        <td><?php echo $line['info']; ?></td>
			<td>
<?php 
	    $COLORHT='<div class="button colorblock" style="';
	    $COLORHT.='color: '.  $line['color'].' !important;' ;
	    $COLORHT.='background: '.  $line['color'].' !important;';
	    $COLORHT.='" ';
		   $COLORHT.= "onclick='navigator.clipboard.writeText(\"";
		   $COLORHT.=   $line['color'];
		   $COLORHT.= "\");";
		   $COLORHT.= 'prompt("The color at below have been copyed into your clipboard", "';
		   $COLORHT.=   $line['color'];
		   $COLORHT.= "\");'>";
		   $COLORHT.= '</div>';
			    echo  $COLORHT ; 
?>
                        <td><?php echo htmlspecialchars($line['admin']); ?></td>


</td>
                        <td>
                            <div class="admin-action">
			    <a href="/admin_lines/coord?line_id=<?php echo $line['id']; ?>" class="button">Coords</a> 
<div class="admin-table-bar"></div>
			    <a href="/admin_lines/edit?line_id=<?php echo $line['id']; ?>" class="button">Edit</a> 
<div class="admin-table-bar"></div>

                                <button type="submit" class="button" onclick='return rufksure("admin_lines/deline?line_id=<?php echo $line['id']; ?>","this line and all its coords")'>Delete</button>
                            </div>
                       </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
    <?php include '../shared/footer.php'; ?>

