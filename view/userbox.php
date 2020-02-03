<div class="user-box">
    <h4>Общее</h4>
    <ul>
        <li><a href="./projects.php?projectID=<?php echo $projectID ?>">Проекты</a> (раздер управление проектами)</li>
        <li><a href="./cycles.php?projectID=<?php echo $projectID ?>">Циклы</a> (раздел управления шаблонами циклов тест-кейсов)</li>
        <li><a href="./testcases.php?projectID=<?php echo $projectID ?>">Тест-кейсы</a> (раздел управления шаблонами тест-кейсов)</li>
    </ul>
    <p>
        В данных разделах доступна возможность создавать, редактировать и удалять записи в циклах и тест-кейсах.
        <br>Ограничение: удаление проектов запрещено.
    </p>
</div>
<br>
<div class="user-box">
    <h4>Процессы</h4>
    <ul>
        <li><a href="./main.php?projectID=<?php echo $projectID ?>">Тест-планы</a> (раздел планирования циклов тест-кейсов)</li>
        <li><a href="./main.php?projectID=<?php echo $projectID ?>">Тестирование</a> (раздел непосредственного выполнения тест-планов)</li>
        <li><a href="./main.php?projectID=<?php echo $projectID ?>">Отчеты</a> (раздел отчетов о выполненном тестировании)</li>
    </ul>
    <p>
        Перечень основных разделов всех процесса тестирования.
    </p>
</div>