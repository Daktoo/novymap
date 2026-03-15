<?php
include 'adm.phphidden';
$pagetitle="Manage Markers";
pageView("Manage Markers :wrench::triangular_flag_on_post::book:");
	echo(admin_head($pagetitle));
	echo(admin_navbar());

?>
<body>
<div class="center">
    <div class="settings-container-top ">
<a id="submit-btn" href="addmarker">Add</a>
        <table>
            <tr>
                              <th>id</th>
                <th>Name</th>
                <th>Added By</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>
        <?php
       
        $sql = "SELECT name,id,icon,admin  FROM marker ;";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
		$san=htmlsan([
           'id' => $row['id'],
           'name' => $row['name'],
           'icon' => $row['icon'],
           'admin' => $row['admin']
		]);
            echo "<tr>";
            echo "<td>$san[id]</td>";
            echo "<td>$san[name]</td>";
            echo "<td>$san[admin]</td>";

            echo "<td><div class=\"admin-action\"><img class=\"admin-tablet-icon\" src='https://map.novymap-qvh.top/hack/_markers_/".$san['icon'].".png'><p>".$san['icon']."</p></div></td>";
	     echo "<td><div class=\"admin-action\"><a class=\"button\" href=\"editmarker?id=".$san['id']."\">Edit</a> <div class=\"admin-table-bar\"></div><a class=\"button\" onclick=\"rufksure(&quot;deletemarker?id=".$san['id']."&quot;,&quot;marker&quot;)\">Delete</a> </div> </td>";
        }
        ?>

        </table>
    </div>
</div>
    <?php include '../shared/footer.php'; ?>
</body>

