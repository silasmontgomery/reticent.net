<?php 
session_start();
require_once __DIR__ . '/../auto_loader.php';
if (!isset($title)) {
    $title = 'Shirking in the shadows';
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
    <title><?php echo $title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        <?php include __DIR__ . '/style.css'; ?>
    </style>
</head>
<body>
    <div class="center-content">
        <div>
            <div class="title">Reticent.net</div>
            <p class="subtitle"><i><?php echo $title; ?></i></p>
        </div>
    </div>
    <div class="divider"></div>
    <?php if($page !== 'home.php'): ?>
        <?php include __DIR__ . '/../components/nav-menu.php'; ?>
    <?php endif; ?>
    <div class="center-content">
        <?php echo $body; ?>
    </div>
    <div class="divider"></div>
    <?php if($page !== 'home.php'): ?>
        <?php include __DIR__ . '/../components/nav-menu.php'; ?>
    <?php endif; ?>
    <div class="center-content">
        <p class="footer">Copyright &copy; 2026 Silas Montgomery. All rights reserved.</p>
    </div>
</body>
</html>