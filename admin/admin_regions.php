<?php
include_once '../shared/san.php';
include 'adm.phphidden';
$region_id = isset($_GET['region_id']) ? intval($_GET['region_id']) : 0;
$coord_id = isset($_GET['coord_id']) ? intval($_GET['coord_id']) : 0;
$customhead = "";
if ($_SERVER['PATH_INFO'] === "/add") {
    $pagetitle = "Manage Town Borders";
    $action = "add";
} elseif ($_SERVER['PATH_INFO'] === "/deregion") {
    $action = "deregion";
} elseif ($_SERVER['PATH_INFO'] === "/edit") {
    $pagetitle = "Manage Town Borders";
    $action = "edit";
} elseif ($_SERVER['PATH_INFO'] === "/delcoord") {
    $action = "delcoord";
} elseif ($_SERVER['PATH_INFO'] === "/upcoord") {
    $action = "upcoord";
} elseif ($_SERVER['PATH_INFO'] === "/coord") {
    $pagetitle = "Manage Town Border Coords";
    $action = "coord";
    $customhead = '<script src="/js/admin_regions_coord_editor.js"></script>';
} else {
    header("Location: /admin_regions/add");
}
if ($action === 'add' || $action === 'edit') {
    $customhead = '<script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>';
    $customhead .= '<script src="/js/admin_lines_rail_line_editor.js"></script>';
    $customhead .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css">';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === "edit" || $action === "add") {
        $saninfo = sqlsan([
            "id"        => intval($_GET['region_id'] ?? 0),
            "name"      => $_POST['name'],
            "color"     => $_POST['color'],
            "info"      => $_POST['info'],
            "wiki"      => $_POST['wiki'],
            "main_dial" => $_POST['main_dial'],
            "owners"    => $_POST['owners'],
            "members"   => $_POST['members'],
            "railways"  => $_POST['railways'],
            "admin"     => $fuckinguserinfo['name']
        ], $conn);
        if ($action === "edit") {
            $sql = "UPDATE `regions` SET `name`='$saninfo[name]', `color`='$saninfo[color]', `info`='$saninfo[info]', `wiki`='$saninfo[wiki]', `main_dial`='$saninfo[main_dial]', `owners`='$saninfo[owners]', `members`='$saninfo[members]', `railways`='$saninfo[railways]' WHERE id=$saninfo[id]";
        } else {
            $sql = "INSERT INTO `regions` (name, color, admin, info, wiki, main_dial, owners, members, railways) VALUES ('$saninfo[name]', '$saninfo[color]', '$saninfo[admin]', '$saninfo[info]', '$saninfo[wiki]', '$saninfo[main_dial]', '$saninfo[owners]', '$saninfo[members]', '$saninfo[railways]')";
        }
        $result = mysqli_query($conn, $sql);
        if ($result) {
            sqlEdit(($action === "edit" ? "Updated" : "Added") . " region :map: ```sql\n" . $sql . "````$result`");
            auditlog($action === "edit" ? 'edit' : 'add', 'Town Border', [
                'name'      => $saninfo['name'],
                'color'     => $saninfo['color'],
                'info'      => $saninfo['info'],
                'main_dial' => $saninfo['main_dial'],
                'owners'    => $saninfo['owners'],
                'members'   => $saninfo['members'],
                'railways'  => $saninfo['railways'],
                'wiki'      => $saninfo['wiki']
            ]);
        } else {
            die(mysqli_error($conn));
        }
        header("Location: /admin_regions/add");
    }
    if ($action === 'coord') {
        $x = intval($_POST['x']);
        $y = intval($_POST['y']);
        $z = intval($_POST['z']);
        $pos = $_POST['position'];
        $res = mysqli_query($conn, "SELECT MIN(seq) AS minseq, MAX(seq) AS maxseq FROM region_coords WHERE region_id=$region_id");
        $row = mysqli_fetch_assoc($res);
        $new_seq = ($pos === 'start') ? ($row['minseq'] - 1) : ($row['maxseq'] + 1);
        $sql = "INSERT INTO region_coords (region_id, seq, x, y, z) VALUES ($region_id, $new_seq, $x, $y, $z)";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            sqlEdit("Added region coord :map: ```sql\n" . $sql . "````$result`");
        } else {
            die(mysqli_error($conn));
        }
        header("Location: /admin_regions/coord?region_id=$region_id");
    }
}

if ($action === 'upcoord') {
    $x = isset($_GET['x']) ? intval($_GET['x']) : 0;
    $y = isset($_GET['y']) ? intval($_GET['y']) : 0;
    $z = isset($_GET['z']) ? intval($_GET['z']) : 0;
    $sql = "UPDATE region_coords SET x=$x, y=$y, z=$z WHERE id=$coord_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Sqlst: ok");
        sqlEdit("Updated region coord :map: ```sql\n" . $sql . "````$result`");
    } else {
        header("Sqlst: error");
        die(mysqli_error($conn));
    }
    if (!($_GET['noredrect'] === "yes")) {
        header("Location: /admin_regions/add");
    } else {
        echo(":3");
    }
    die();
}

if ($action === 'delcoord') {
    $sql = "DELETE FROM region_coords WHERE id=$coord_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        sqlEdit("Deleted region coord :map: ```sql\n" . $sql . "````$result`");
    } else {
        die(mysqli_error($conn));
    }
    header("Location: /admin_regions/coord?region_id=$region_id");
}

if ($action === "deregion") {
    $namerow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM `regions` WHERE id=$region_id"));
    $sql = "DELETE FROM `regions` WHERE id=$region_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        sqlEdit("Deleted region :map: ```sql\n" . $sql . "````$result`");
        auditlog('delete', 'Town Border', [
            'name' => $namerow['name'] ?? "ID $region_id",
            'id'   => $region_id
        ]);
    } else {
        die(mysqli_error($conn));
    }
    header("Location: /admin_regions/add");
}

echo(admin_head($pagetitle, $customhead));
echo(admin_navbar());
?>
<body>
    <div class="center">
    <?php if ($action !== 'coord'): pageView("Manage Town Borders :map:"); ?>
        <div class="settings-container">
            <h1 class="qvhtile"><?php echo ($action === 'edit') ? 'Edit Town Border' : 'Add New Town Border'; ?></h1>
            <?php
            $rawedit = ['id' => 0, 'name' => '', 'color' => '', 'info' => '', 'wiki' => '', 'main_dial' => '', 'owners' => '', 'members' => '', 'railways' => ''];
            if ($action === 'edit' && $region_id > 0) {
                $res = mysqli_query($conn, "SELECT * FROM `regions` WHERE id=$region_id");
                $rawedit = mysqli_fetch_assoc($res);
            }
            $edit = htmlsan($rawedit);
            ?>
            <form method="post" class="form">
                <label>Name:</label>
                <input type="text" name="name" class="input" value="<?php echo $edit['name']; ?>" required>
                <label>Color:</label>
                <div class="input colorpick-outside">
                    <input type="text" name="color" class="colorpicker" value="<?php echo empty($edit['color']) ? '#7d5df4' : $edit['color']; ?>" required>
                </div>
                <label>Info:</label>
                <textarea name="info" class="input"><?php echo $edit['info']; ?></textarea>
                <label>Wiki:</label>
                <input type="url" name="wiki" class="input" value="<?php echo $edit['wiki']; ?>">
                <label>Main Dial:</label>
                <input type="text" name="main_dial" class="input" value="<?php echo $edit['main_dial']; ?>">
                <label>Owners:</label>
                <input type="text" name="owners" class="input" value="<?php echo $edit['owners']; ?>">
                <label>Members:</label>
                <input type="text" name="members" class="input" value="<?php echo $edit['members']; ?>">
                <label>Railways:</label>
                <input type="text" name="railways" class="input" value="<?php echo $edit['railways']; ?>">
                <button type="submit" id="submit-btn"><?php echo ($edit['id'] > 0) ? 'Save' : 'Add Town Border'; ?></button>
                <?php echo ($edit['id'] > 0) ? '<button type="button" id="submit-btn" onclick="window.location.assign(&quot;/admin_regions&quot;)">Cancel</button>' : ''; ?>
            </form>
        </div>

        <div class="settings-container">
            <h1 class="qvhtile">Town Borders</h1>
            <h1 class="qvhtilesmall">Click the color to copy it</h1>
            <table class="table">
                <tr><th>ID</th><th>Name</th><th>Info</th><th>Main Dial</th><th>Color</th><th>Added by</th><th>Actions</th></tr>
                <?php
                $regionsRes = mysqli_query($conn, "SELECT * FROM `regions` ORDER BY id ASC");
                while ($rawregion = mysqli_fetch_assoc($regionsRes)):
                    $region = htmlsan($rawregion);
                ?>
                <tr>
                    <td><?php echo $region['id']; ?></td>
                    <td><?php echo $region['name']; ?></td>
                    <td><?php echo $region['info']; ?></td>
                    <td><?php echo $region['main_dial']; ?></td>
                    <td>
                        <?php
                        $COLORHT = '<div class="button colorblock" style="color: ' . $region['color'] . ' !important; background: ' . $region['color'] . ' !important;" onclick=\'navigator.clipboard.writeText("' . $region['color'] . '"); prompt("Copied!", "' . $region['color'] . '");\'></div>';
                        echo $COLORHT;
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($region['admin']); ?></td>
                    <td>
                        <div class="admin-action">
                            <a href="/admin_regions/coord?region_id=<?php echo $region['id']; ?>" class="button">Coords</a>
                            <div class="admin-table-bar"></div>
                            <a href="/admin_regions/edit?region_id=<?php echo $region['id']; ?>" class="button">Edit</a>
                            <div class="admin-table-bar"></div>
                            <button type="button" class="button" onclick='return rufksure("admin_regions/deregion?region_id=<?php echo $region['id']; ?>","this region and all its coords")'>Delete</button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php endif; ?>

    <?php if ($action === 'coord'): pageView("Manage Town Border Coords :map:"); ?>
        <?php
        $regionRes = mysqli_query($conn, "SELECT * FROM `regions` WHERE id=$region_id");
        $region = mysqli_fetch_assoc($regionRes);
        ?>
        <div id="add-coord" class="settings-container">
            <h1 class="qvhtile">Coordinates for <span id="region_id"><?php echo htmlspecialchars($region['name'] ?? "(Error: Region Not Found)"); ?></span></h1>
            <h1 class="qvhtilesmall">First and last coordinates will be automatically connected to close the region border.</h1>
            <form method="post" class="form">
                <label>X:</label><input type="number" name="x" class="input" required>
                <label>Y:</label><input type="number" name="y" class="input" value="64" required>
                <label>Z:</label><input type="number" name="z" class="input" required>
                <label>Position:</label>
                <select name="position" class="input">
                    <option value="end">End</option>
                    <option value="start">Start</option>
                </select>
                <button type="submit" id="submit-btn">Add</button>
                <button type="button" onclick='window.location.assign("/admin_regions");' id="submit-btn">&larr; Back to Town Borders</button>
            </form>
        </div>
        <div class="settings-container">
            <table class="table">
                <tr><th>Seq</th><th>X</th><th>Y</th><th>Z</th><th>Actions</th></tr>
                <?php
                $coordsRes = mysqli_query($conn, "SELECT * FROM region_coords WHERE region_id=$region_id ORDER BY seq ASC");
                while ($rawcoord = mysqli_fetch_assoc($coordsRes)):
                    $coord = htmlsan($rawcoord);
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
                            <button type="button" class="button" onclick='rufksure("admin_regions/delcoord?region_id=<?php echo($region_id . "&coord_id=" . $coord['id']); ?>","this coord")'>Delete</button>
                        </form>
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
