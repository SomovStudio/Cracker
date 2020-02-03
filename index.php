<?php include_once './core/constants.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="SHORTCUT ICON" href="./img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="./styles/body.css" media="screen">
        <link rel="stylesheet" type="text/css" href="./styles/auth.css" media="screen">
        <title><?php echo Constants::PROJECT_NAME ?></title>
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <?php require_once './auth/auth.php'; ?>
            </div>
            <div class="Clear"></div>
        </div>
    </body>
</html>
