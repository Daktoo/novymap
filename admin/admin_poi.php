<?php
include 'adm.phphidden';
$pagetitle="Manage POI";
pageView("Manage Pois :wrench::triangular_flag_on_post::book:");
	echo(admin_head($pagetitle));
	echo(admin_navbar());


?>
<body>
<div class="center">
    <div class="settings-container-top ">
<a class="button" id="submit-btn" href="/addpoi" >Add</a>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Dial</th>
                <th>Info</th>
                <th>X</th>
                <th>Y</th>
                <th>Z</th>
                <th>Add by</th>
                <th>Markers</th>
                <th>Screenshot</th>
                <th>Actions</th>
            </tr>


        <?php
       
    
        $sql = "SELECT novy.shot,novy.admin,novy.id, novy.name, novy.dial, novy.info, novy.x,novy.y, novy.z, marker.icon, marker.name AS marker_name  FROM novy  JOIN marker ON novy.marker = marker.id ";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
		$san=htmlsan([
            'id' => $row['id'],
            'name' => $row['name'],
            'dial' => $row['dial'],
            'info' => $row['info'],
            'x' => $row['x'],
            'y' => $row['y'],
            'z' => $row['z'],
            'icon' => $row['icon'],
            'category' => $row['marker_name'],
	    'admin' => $row['admin'],
	    'shot' => $row['shot']
		]);
	    if (empty($san['admin'])){
	    $san['admin']="???";
	    }

            echo "<tr>";
	    echo "<td>$san[id]</td>";
            echo "<td>$san[name]</td>";
            echo "<td>$san[dial]</td>";
            echo "<td>$san[info]</td>";
            echo "<td>$san[x]</td>";
            echo "<td>$san[y]</td>";
            echo "<td>$san[z]</td>";
			$shotres='<td>';

            echo "<td>$san[admin]</td>";
	            echo "<td><div class=\"admin-action\"><img class='admin-tablet-icon' src='https://map.novymap-qvh.top/hack/_markers_/$san[icon].png'><p>$san[category]</p><div></td>";

		if (!(empty($san['shot'])||$san['shot']==="No Screenshot"))
	{

			$shotres.='<div class="shot-posbox">';
			$shotres.='<details class="shot-clickbox">';
		$shotres.='<summary class="shot-head">';
		$shotres.='<div class="shot-img-box">';
			$shotres.='<div class="shot-titlebar">';
			$shotres.='<p class="shot-titletext">'.$san['name'].'</p>';
			$shotres.='<p class="shot-titlewindowscontroll">⎯ ❐ ⤬</p>';
			$shotres.='</div>';

		$shotres.='<img class="shot-img" src="https://api.novymap-qvh.top/api/shot?id='.$row['id'].'">';
			$shotres.='</div>';
			$shotres.='</summary>';
			$shotres.='</details>';
			$shotres.='<p class="shot-text">(Click to zoom)</p>';
			$shotres.='</div>';
	} else {
	
			$shotres.='No Screeshot';
	}
			$shotres.='</td>';
			echo $shotres;

            echo "<td><div class=\"admin-action\"><a class=\"button\" href='editpoi?id=$san[id]'>Edit</a><div class=\"admin-table-bar\"></div><a class=\"button\" onclick=\"rufksure(&quot;deletepoi?id=$san[id]&quot;,&quot;poi&quot;)\">Delete</a><div></td>";
            echo "</tr>";
        }
        ?>
        </table>
    </div>
</div>    <?php include '../shared/footer.php'; ?>

</body>

