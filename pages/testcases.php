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
        <h3>Тест-кейсы</h3>
        <div class="content-left">
            <?php
                $query = "SELECT * FROM cycles WHERE(project_id=$projectID) ORDER BY name ASC";
                $dataCycles = DB::getDataArrayKeyValue($query, 'id', 'name');

                if (isset($_POST['event'])) {
                    if ($_POST['event'] === Constants::EVENT_FILTER && isset($_POST['cycle'])) {
                        $cycleID = $_POST['cycle'];
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                    }elseif ($_POST['event'] === Constants::EVENT_SEARCH){
                        $cycleID = $_POST['cycleID'];
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(summary LIKE '%".$_POST['search']."%' AND cycle_id=".$cycleID.") ORDER BY summary ASC");
                    }elseif ($_POST['event'] === Constants::EVENT_ADD){
                        $cycleID = $_POST['cycle_id'];
                        $dataTable = DB::setData("INSERT INTO test_cases (summary, cycle_id, author, description) VALUES (" .
                            "'" . $_POST['summary'] . "', "
                            . $_POST['cycle_id'] . ", "
                            . "'', "
                            . "'" . $_POST['description'] . "'" .")");
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                    }elseif ($_POST['event'] === Constants::EVENT_EDIT){
                        $cycleID = $_POST['cycleID'];
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(id=".$_POST['id'].") ORDER BY summary ASC");
                    }elseif ($_POST['event'] === Constants::EVENT_UPDATE){
                        $cycleID = $_POST['cycle_id'];
                        $dataTable = DB::setData("UPDATE test_cases SET " .
                            "summary = '" . $_POST['summary'] . "', " .
                            "cycle_id = ". $_POST['cycle_id'] . ", " .
                            "description = '" . $_POST['description'] . "' " .
                            "WHERE(id=" . $_POST['id'] . ")");
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                    }elseif ($_POST['event'] === Constants::EVENT_DELETE){
                        $cycleID = $_POST['cycleID'];
                        $dataTable = DB::setData("DELETE FROM test_cases WHERE (id=".$_POST['id'].")");
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                    }else{
                        $cycleID = -1;
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                    }
                }else {
                    if(isset($_GET['cycleID'])){
                        $cycleID = $_GET['cycleID'];
                        $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                    }else{
                        if(count($dataCycles)>0){
                            $keys = array_keys($dataCycles);
                            if(count($keys) > 0){
                                $key = $keys[0];
                                $cycleID = $dataCycles[$key]['key'];
                                $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                            }else{
                                $cycleID = -1;
                                $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=".$cycleID.") ORDER BY summary ASC");
                            }
                        }else{
                            $cycleID = -1;
                            $dataTable = DB::getData("SELECT * FROM test_cases WHERE(cycle_id=$cycleID) ORDER BY summary ASC");
                        }
                    }
                }

                // фильтр циклов
                $panel = new Panel();
                $filter = new ComboBox('cycle', 'Цикл', 'Выберите цикл',
                    "./testcases.php?projectID=$projectID", 'Выбрать', $dataCycles, $cycleID);
                $filter->addHiddenInput('projectID', $projectID);
                $filter->addHiddenInput('event', Constants::EVENT_FILTER);
                $panel->addContent($filter->getContent());
                $panel->render();

                // панель поиска
                $panel = new Panel();
                $buttonAdd = new Button("./testcases.php?projectID=$projectID&cycleID=$cycleID", 'Новый тест-кейс', 30, 145);
                $panel->addContent($buttonAdd->getContent());
                $search = new Search("./testcases.php?projectID=$projectID", 'Введите значение для поиска', 'Поиск');
                $search->addHiddenInput('projectID', $projectID);
                $search->addHiddenInput('cycleID', $cycleID);
                $panel->addContent($search->getContent());
                $buttonBack = new Button("./testcases.php?projectID=$projectID&cycleID=$cycleID", 'Назад', 30, 65);
                $panel->addContent($buttonBack->getContent());
                $panel->render();

                // таблица тест-кейсов
                $table = new Table(58);
                $table->addNumberColunm('num', '№п/п', 50);
                $table->addButtonEdit('testcases.php', ['id']);
                $table->addButtonDelete('testcases.php', ['id']);
                $table->addButtonSteps('steps.php', ['id']);
                $table->addColunm('summary', 'Наименование', 450);
                $table->addHiddenInput('projectID', $projectID);
                $table->addHiddenInput('cycleID', $cycleID);
                $table->setData($dataTable);
                $table->render();

            ?>
        </div>
        <div class="content-right">
            <div class="edit-box">
                <?php
                if (isset($_POST['event']))
                {
                    if ($_POST['event'] === Constants::EVENT_EDIT) {
                        $row = DB::getRow($dataTable);
                        $form = new Form('Цикл', './testcases.php', Constants::EVENT_UPDATE, 75);
                        $form->addTextBox('id', 'ID:', 'ID назначается автоматически', $row['id'], true);
                        $form->addTextBox('summary', 'Наименование:', 'Введите наименование', $row['summary']);
                        $form->addComboBox('cycle_id', "Цикл", "Выберите цикл", $dataCycles, $cycleID);
                        $form->addMemoBox('description', 'Описание', 'Введите описание', $row['description']);
                        $form->addHiddenInput('projectID', $projectID);
                    }else{
                        $form = new Form('Цикл', './testcases.php', Constants::EVENT_ADD, 75);
                        $form->addTextBox('id', 'ID:', 'ID назначается автоматически', '', true);
                        $form->addTextBox('summary', 'Наименование:', 'Введите наименование', '');
                        $form->addComboBox('cycle_id', "Цикл", "Выберите цикл", $dataCycles, $cycleID);
                        $form->addMemoBox('description', 'Описание', 'Введите описание', '');
                        $form->addHiddenInput('projectID', $projectID);
                    }
                }else {
                    $form = new Form('Цикл', './testcases.php', Constants::EVENT_ADD, 75);
                    $form->addTextBox('id', 'ID:', 'ID назначается автоматически', '', true);
                    $form->addTextBox('summary', 'Наименование:', 'Введите наименование', '');
                    $form->addComboBox('cycle_id', "Цикл", "Выберите цикл", $dataCycles, $cycleID);
                    $form->addMemoBox('description', 'Описание', 'Введите описание', '');
                    $form->addHiddenInput('projectID', $projectID);
                }
                if (isset($form)) $form->render();
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