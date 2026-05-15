<?php 
session_start();
require_once __DIR__ . '/../auto_loader.php';
if(!isset($title)) {
    $title = $config['general']['site_title'] ?? 'reticent.net';
}
if (!isset($subtitle)) {
    $subtitle = $config['general']['site_subtitle'] ?? 'shirking in the shadows';
}
if (!isset($body)) {
    $body = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title . ' | ' . $subtitle; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sansation:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
    <a name="top"></a>
    <div class="center-content ">
        <div id="header" class="flex-container middle">
            <div id="header-logo">
                <img src="/logo.png" alt="Logo">
            </div>
            <div id="header-title">
                <div class="title"><?php echo $title; ?></div>
                <div class="subtitle"><?php echo $subtitle; ?></div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <?php if($page !== 'home.php'): ?>
        <?php include __DIR__ . '/../components/nav-menu.php'; ?>
    <?php endif; ?>
    <div class="center-content">
        <div id="main">
            <?php echo $body; ?>
        </div>
    </div>
    <?php if($page !== 'home.php'): ?>
        <?php include __DIR__ . '/../components/nav-menu.php'; ?>
    <?php endif; ?>
    <div class="divider"></div>
    <div class="center-content">
        <div id="footer" class="flex-container">
            <div>Copyright &copy; <?php echo date("Y") ?> <?php echo $config['general']['admin_name'] ?? 'Silas Montgomery'; ?>.</div>
            <div>All rights reserved.</div>
            <div><a href="contact.php">Contact Me</a></div>
        </div>
    </div>
</body>
</html>