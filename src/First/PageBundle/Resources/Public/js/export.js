function HtmltoExcel(namefile){
    var data_type = 'data:application/vnd.ms-excel,\uFEFF';
    var html = "<html xmlns='http://www.w3.org/1999/xhtml' lang='el-GR' lang='el-GR'>";
    html += '<?php Response.AddHeader("Content-Disposition", "inline;filename=filename.xls") ?>';
    html += "<meta http-equiv='content-type' content='text/plain; charset=UTF-8'/>";
    html += "<table border='2px'><tr bgcolor='#87AFC6'>";
    var i = 0;
    var tab = document.getElementById("MTable"); // id таблицы
    //Пересобираем таблицу
    for(i = 0 ; i < tab.rows.length ; i++)
    {
        html=html+tab.rows[i].innerHTML+"</tr>";
    }
    //Очищаем данные
    html= html.replace(/<A[^>]*>|<\/A>/g, "");
    html= html.replace(/<img[^>]*>/gi,"");
    html= html.replace(/<input[^>]*>|<\/input>/gi, "");
    html= html.replace(/<button[^>]*>|<\/button>/gi, "");

    //Находим элемент с id=shadow
    document.getElementById("shadow").href = data_type + encodeURIComponent(html);
    //Присваиваем имя файла
    document.getElementById("shadow").download = namefile +'.xls';
    //Выполняем click для элемента с id=shadow
    document.getElementById("shadow").click();
}
