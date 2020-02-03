<?php
include_once "../core/config.php";
include_once "../core/elements/combobox.php";
include_once "../core/db.php";

if(isset($_POST['projectID'])) $projectID = $_POST['projectID'];
elseif(isset($_GET['projectID'])) $projectID = $_GET['projectID'];
else {
    $query = 'SELECT * FROM projects ORDER BY name ASC';
    $dataProjects = DB::getDataArrayKeyValue($query, 'id', 'name');
    $keys = array_keys($dataProjects);
    if(count($keys) > 0) $projectID = $dataProjects[$keys[0]]["key"];
    else $projectID = '';
}
if($projectID ==='') $projectID = '0';
?>
<div id="header">
    <div id="header-top-menu">
        <div id="header-content-menu">
            <ul>
                <li><a href="./main.php?projectID=<?php echo $projectID ?>">Домашняя страница</a></li>
                <li>|</li>
                <li><a href="./projects.php?projectID=<?php echo $projectID ?>">Проекты</a></li>
                <li><a href="./cycles.php?projectID=<?php echo $projectID ?>">Циклы</a></li>
                <li><a href="./testcases.php?projectID=<?php echo $projectID ?>">Тест-кейсы</a></li>
                <li>|</li>
                <li><a href="./main.php?projectID=<?php echo $projectID ?>">Тест-планы</a></li>
                <li><a href="./main.php?projectID=<?php echo $projectID ?>">Тестирование</a></li>
                <li>|</li>
                <li><a href="./main.php?projectID=<?php echo $projectID ?>">Отчеты</a></li>
            </ul>
        </div>
        <div id="header-account">
            <ul>
                <li><label>Пользователь: </label><a href=""><?php echo $_SESSION['login'] ?></a></li>
                <li><a href="../">Выйти</a></li>
            </ul>
        </div>
    </div>
    <div id="header-title-logo">
        <h2><?php echo Constants::PROJECT_NAME ?></h2>
        <?php
            $query = 'SELECT * FROM projects ORDER BY name ASC';
            $dataProjects = DB::getDataArrayKeyValue($query, 'id', 'name');

            echo "<div class='combobox-project'>";
            $comboBoxProjects = new ComboBox('projectID', 'Проект:', 'Выберите проект', $_SERVER['REQUEST_URI'], 'Выбрать', $dataProjects, $projectID);
            $comboBoxProjects->render();
            echo "</div>";
        ?>
    </div>
</div>