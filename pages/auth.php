<?php
error_reporting(0);
session_start();

$_SESSION['login'] = null;
$_SESSION['authorization'] = false;

if (isset($_POST["event"]))
    $event = $_POST["event"];
else
    $event = null;
?>

<?php if ($event == 'check-authorization') { ?>

<?php } elseif ($event == null) { ?>

	<div id="authorization">
        <h2><?= Constants::PROJECT_NAME ?></h2>
        <img src="./img/logo.png">
        <form action="./pages/auth.php" method="post">
            <br>
            <label for="login">Имя:</label>
            <br>
            <input type="text" name="login" id="login" placeholder="Введите ваш логин">
            <br><br>
            <label for="pass">Пароль:</label>
            <br>
            <input type="password" name="pass" id="pass" placeholder="Введите ваш пароль">
            <br><br>
            <input type="submit" id="bottonOk" value="Вход">
            <input type="hidden" name="event" id="event" value="check-authorization">
        </form>
    </div>

<?php } ?>