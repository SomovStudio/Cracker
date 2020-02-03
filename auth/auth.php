<?php
error_reporting(0);
session_start();

$_SESSION['login'] = null;
$_SESSION['authorization'] = false;

if (isset($_GET["event"]))
    $event = $_GET["event"];
else
    $event = null;
?>

<?php if ($event == 'check') { ?>

    <?php
    require_once "../core/config.php";

    $mysqli = mysqli_connect(Config::$Server, Config::$RootUserName, Config::$RootUserPass, Config::$Database);
    if (mysqli_connect_errno()) {
        header("Location: ../pages/error.php?message=" . mysqli_connect_error());
        exit();
    }
    mysqli_query($mysqli, "SET NAMES 'UTF8'");
    $queryText = "SELECT * FROM users WHERE (name = '" . $_POST['login'] . "' AND pass = '" . $_POST['pass'] . "')";
    $result = mysqli_query($mysqli, $queryText);
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['authorization'] = true;

        header("Location: ../pages/main.php");
    } else {
        header("Location: ../pages/error.php?message=Incorrect username or password");
        exit();
    }
    ?>

<?php } elseif ($event == null) { ?>

    <div id="authorization">
        <h2><?= Constants::PROJECT_NAME ?></h2>
        <img src="./img/logo.png">
        <form action="./auth/auth.php?event=check" method="post">
            <br>
            <label for="login">Имя:</label>
            <br>
            <input type="text" name="login" id="login" placeholder="Введите ваш логин">
            <br><br>
            <label for="pass">Пароль:</label>
            <br>
            <input type="password" name="pass" id="pass" placeholder="Введите ваш пароль">
            <br><br>
            <input type="submit" value="Вход" id="bottonOk">
        </form>
    </div>

<?php } ?>
