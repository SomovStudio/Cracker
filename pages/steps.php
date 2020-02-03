<?php
//error_reporting(0);
session_start();

include_once "../core/debug.php";
include_once "../core/constants.php";
include_once "../core/config.php";
include_once "../core/db.php";
include_once "../core/elements/panel.php";
include_once "../core/elements/button.php";
include_once "../core/elements/search.php";
include_once "../core/elements/table.php";
include_once "../core/elements/form.php";
include_once "../core/elements/combobox.php";
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
        <h3>Шаги в тест-кейсе: </h3>
        <div class="content-left">
            <?php
                if(isset($_POST["cycleID"])) $cycleID = $_POST["cycleID"];
                else $cycleID = 0;
                if(isset($_POST["id"])) $caseID = $_POST["id"];
                else $caseID = 0;

                if (isset($_POST['event'])) {
                    if ($_POST['event'] === Constants::EVENT_STEPS) {
                        $dataTable = DB::getData("SELECT * FROM steps_test_case WHERE(test_case_id=".$caseID.")");
                    }
                }else{
                    $dataTable = DB::getData("SELECT * FROM steps_test_case WHERE(test_case_id=".$caseID.")");
                }


                // панель поиска
                $panel = new Panel();
                $buttonAdd = new Button("./testcases.php?projectID=$projectID&cycleID=$cycleID", 'Новый тест-кейс', 30, 145);
                $panel->addContent($buttonAdd->getContent());
                $buttonBack = new Button("./testcases.php?projectID=$projectID&cycleID=$cycleID", 'Назад', 30, 65);
                $panel->addContent($buttonBack->getContent());
                $panel->render();

                // таблица тест-кейсов
                $query = "SELECT * FROM test_cases WHERE(cycle_id=$cycleID AND id=$caseID) ORDER BY summary ASC";
                $dataTestCases = DB::getData($query);

                $table = new Table(5);
                $table->addNumberColunm('num', '№п/п', 50);
                $table->addButtonEdit('testcases.php', ['id']);
                $table->addButtonDelete('testcases.php', ['id']);
                $table->addColunm('summary', 'Наименование', 450);
                $table->addHiddenInput('projectID', $projectID);
                $table->addHiddenInput('cycleID', $cycleID);
                $table->setData($dataTestCases);
                $table->render();

                // панель поиска
                $panel = new Panel();
                $buttonAdd = new Button("./steps.php?projectID=$projectID&cycleID=$cycleID", 'Добавить шаг', 30, 145);
                $panel->addContent($buttonAdd->getContent());
                $search = new Search("./steps.php?projectID=$projectID", 'Введите значение для поиска', 'Поиск');
                $search->addHiddenInput('projectID', $projectID);
                $search->addHiddenInput('cycleID', $cycleID);
                $panel->addContent($search->getContent());
                $buttonBack = new Button("./steps.php?projectID=$projectID&cycleID=$cycleID", 'Назад', 30, 65);
                $panel->addContent($buttonBack->getContent());
                $panel->render();

                // таблица шагов тест-кейса
                $table = new Table(48);
                $table->addNumberColunm('num', '№п/п', 50);
                $table->addButtonEdit('steps.php', ['id']);
                $table->addButtonDelete('steps.php', ['id']);
                $table->addColunm('step', 'Описание шага', 400);
                $table->addColunm('step_data', 'Данные', 200);
                $table->addColunm('step_expected_result', 'Ожидаемый результат', 250);
                $table->addHiddenInput('projectID', $projectID);
                $table->addHiddenInput('cycleID', $cycleID);
                $table->setData($dataTable);
                $table->render();
            ?>
        </div>
        <div class="content-right">
            <div class="edit-box">
                <?php

                ?>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require_once "../view/footer.php"; ?>
</div>

<!-- SCRIPTS -->
<script src="../scripts/script.js"></script>
</body>
</html>
