<?php
//error_reporting(0);
session_start();

include_once "../core/constants.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="SHORTCUT ICON" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/body.css" media="screen">
    <link rel="stylesheet" type="text/css" href="../styles/view.css" media="screen">
    <link rel="stylesheet" type="text/css" href="../styles/default.css" media="screen">
    <link rel="stylesheet" type="text/css" href="../core/elements/elements.css" media="screen">
    <title><?php echo Constants::PROJECT_NAME ?></title>
</head>
<body>
<div id="wrapper">
    <?php if ($_SESSION['authorization'] == false) header("Location: ./error.php?message=You are not authorized"); ?>

    <!-- HEADER -->
    <?php require_once "../view/header.php"; ?>

    <!-- CONTENT -->
    <div id="content">
        <h3>Домашняя страница</h3><br>
        <div class="content-left">
            <?php require_once "../view/userbox.php"; ?>
        </div>
        <div class="content-right">
            <?php if(mb_strtolower($_SESSION['login']) === 'admin') require_once "../view/adminbox.php"; ?>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require_once "../view/footer.php"; ?>
</div>

<!-- SCRIPTS -->
<script src="../scripts/script.js"></script>
</body>
</html>