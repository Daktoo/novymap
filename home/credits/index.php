<<<<<<< HEAD
<?php 
    $customhead = '<link rel="stylesheet" href="css/stuff.css">
                   <link rel="icon" type="image/png" href="novymap-qvh.png">';
    include '../../shared/navbar.php';
    echo(htmlhead("Novymap Credits", $customhead));
    echo(navbar());
?>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novymap Credits</title>
    <link rel="stylesheet" href="/shared/nav.css">
    <link rel="stylesheet" href="css/stuff.css">
    <link rel="icon" type="image/png" href="novymap-qvh.png">
</head>
<?php include '../../shared/navbar.php'; ?>
>>>>>>> refs/remotes/origin/master
<body>
    <div class="center">
        <div class="settings-container-top">
            <h1 class="qvhtile">Thank You to Our Amazing Selfs as below.</h1>
            <div class="staff-list">
                <?php 
                include '../../shared/gitea.php';
                echo(gitea_gencredit());
                ?>
            </div>
            <div class="staff-member-you">
                <img src="img/you.png" alt="you" class="staff-image">
                <h3 class="staff-name">You</h3>
                <p class="staff-desc">"Thank you for telling us what dial we have missed!"</p>
            </div>
        </div>
        <div class="settings-container-top">
            <h1 class="qvhtile"> Thank for Original Novymap Project.</h1>
            <h1 class="qvhtilesmall"> also ex-member (as below) of Novymap Project.</h1>
            <div class="staff-list">
                <div class="staff-member">
                    <img src="img/oldstuffs/pigwin.png" alt="Cocreator" class="staff-image">
                    <h3 class="staff-name">pigwin_</h3>
                    <h3 class="staff-role">Cocreator and web and api dev</h3>
                    <p class="staff-desc">"professional procrastinator"</p>
                </div>
                <div class="staff-member">
                    <img src="img/oldstuffs/tabdroid.png" alt="Cocreator" class="staff-image">
                    <h3 class="staff-name">tabdroid</h3>
                    <h3 class="staff-role">Cocreator and mod dev</h3>
                    <p class="staff-desc">"mew"</p>
                </div>
                <div class="staff-member">
                    <img src="img/oldstuffs/dakto1_.png" alt="Admin and Train Manager" class="staff-image">
                    <h3 class="staff-name">Dakto</h3>
                    <h3 class="staff-role">Admin and Train Manager</h3>
                    <p class="staff-desc">"idk why mine works ¯\_(ツ)_/¯"</p>
                </div>
                <div class="staff-member">
                    <img src="img/oldstuffs/lspiter.png" alt="Admin" class="staff-image">
                    <h3 class="staff-name">lspiter</h3>
                    <h3 class="staff-role">Admin</h3>
                    <p class="staff-desc">"hi"</p>
                </div>
                <div class="staff-member">
                    <img src="img/oldstuffs/red.png" alt="Admin" class="staff-image">
                    <h3 class="staff-name">RedJournal</h3>
                    <h3 class="staff-role">Admin</h3>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../shared/footer.php'; ?>
</body>
</html>
