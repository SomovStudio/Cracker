'use strict';

function onTableRowDelete() {
    var answer = confirm("Удалить данные из таблицы?");
    if(answer === false)event.preventDefault();
};