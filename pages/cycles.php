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
        <h3>Циклы тест-кейсов</h3>
        <div class="content-left">
            <?php
                $panel = new Panel();
                $buttonAdd = new Button("./cycles.php?projectID=$projectID", 'Новый цикл', 30, 145);
                $panel->addContent($buttonAdd->getContent());
                $search = new Search("./cycles.php?projectID=$projectID", 'Введите значение для поиска', 'Поиск');
                $search->addHiddenInput('projectID', $projectID);
                $panel->addContent($search->getContent());
                $buttonBack = new Button("./cycles.php?projectID=$projectID", 'Назад', 30, 65);
                $panel->addContent($buttonBack->getContent());
                $panel->render();

                if (isset($_POST['event'])) {
                    if ($_POST['event'] === Constants::EVENT_SEARCH) {
                        $dataTable = DB::getData("SELECT * FROM cycles WHERE(name LIKE '%" . $_POST['search'] . "%' AND project_id=" . $projectID . ") ORDER BY name ASC");
                    } elseif ($_POST['event'] === Constants::EVENT_EDIT){
                        $dataTable = DB::getData("SELECT * FROM cycles WHERE(id=" . $_POST['id'] . " AND project_id=" . $projectID . ") ORDER BY name ASC");
                    } elseif ($_POST['event'] === Constants::EVENT_ADD){
                        $dataTable = DB::setData("INSERT INTO cycles (name, project_id, description) VALUES (" .
                            "'" . $_POST['name'] . "', ". $_POST['project_id'] . ", " ."'" . $_POST['description'] . "'" .")");
                        $dataTable = DB::getData("SELECT * FROM cycles WHERE(project_id=" . $projectID . ") ORDER BY name ASC");
                    } elseif ($_POST['event'] === Constants::EVENT_UPDATE) {
                        $dataTable = DB::setData("UPDATE cycles SET " .
                            "name = '" . $_POST['name'] . "', " .
                            "project_id = ". $_POST['project_id'] . ", " .
                            "description = '" . $_POST['description'] . "' " .
                            "WHERE(id=" . $_POST['id'] . ")");
                        $dataTable = DB::getData("SELECT * FROM cycles WHERE(project_id=" . $projectID . ") ORDER BY name ASC");
                    } elseif ($_POST['event'] === Constants::EVENT_DELETE) {
                        $dataTable = DB::setData("DELETE FROM cycles WHERE (id=" . $_POST['id'] . ")");
                        $dataTable = DB::getData("SELECT * FROM cycles WHERE(project_id=" . $projectID . ") ORDER BY name ASC");
                    } else {
                        $dataTable = DB::getData("SELECT * FROM cycles WHERE(project_id=" . $projectID . ") ORDER BY name ASC");
                    }
                }else{
                    $dataTable = DB::getData("SELECT * FROM cycles WHERE(project_id=" . $projectID . ") ORDER BY name ASC");
                }

                $table = new Table(58);
                $table->addNumberColunm('num', '№п/п', 50);
                $table->addButtonEdit('cycles.php', ['id']);
                $table->addButtonDelete('cycles.php', ['id']);
                $table->addColunm('name', 'Наименование', 450);
                $table->addHiddenInput('projectID', $projectID);
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
                            $form = new Form('Цикл', './cycles.php', Constants::EVENT_UPDATE, 75);
                            $form->addTextBox('id', 'ID:', 'ID назначается автоматически', $row['id'], true);
                            $form->addTextBox('name', 'Наименование:', 'Введите наименование', $row['name']);
                            $form->addComboBox('project_id', "Проект", "Выберите проект", $dataProjects, $projectID);
                            $form->addMemoBox('description', 'Описание', 'Введите описание', $row['description']);
                            $form->addHiddenInput('projectID', $projectID);
                        }else{
                            $form = new Form('Цикл', './cycles.php', Constants::EVENT_ADD, 75);
                            $form->addTextBox('id', 'ID:', 'ID назначается автоматически', '', true);
                            $form->addTextBox('name', 'Наименование:', 'Введите наименование', '');
                            $form->addComboBox('project_id', "Проект", "Выберите проект", $dataProjects, $projectID);
                            $form->addMemoBox('description', 'Описание', 'Введите описание', '');
                            $form->addHiddenInput('projectID', $projectID);
                        }
                    }else {
                        $form = new Form('Цикл', './cycles.php', Constants::EVENT_ADD, 75);
                        $form->addTextBox('id', 'ID:', 'ID назначается автоматически', '', true);
                        $form->addTextBox('name', 'Наименование:', 'Введите наименование', '');
                        $form->addComboBox('project_id', "Проект", "Выберите проект", $dataProjects, $projectID);
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