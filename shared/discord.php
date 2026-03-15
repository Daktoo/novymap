<?php
$pagetitle = $pagetitle ?? 'Novymap';
$pagdesc = $pagedesc ?? 'A map of the entirety of novylen with a few extras';
$pageimage = $pageimage ?? 'https://novy.pigwin.eu/old/banner.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pagetitle); ?></title>
    <link rel="stylesheet" href="/shared/nav.css">
    <link rel="stylesheet" href="/shared/sitewide.css">
    <link rel="icon" type="image/png" href="/novymap-qvh.png">
    <meta property="og:title" content="<?php echo htmlspecialchars($pagetitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pagedesc); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($pageimage); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <?php echo $extrahead ?? ''; ?>
</head>
