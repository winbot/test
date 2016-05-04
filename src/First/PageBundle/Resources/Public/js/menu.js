$(document).ready(function(){

    $("#add").click(function(){
        //Клонируем последнюю строку и добавляем в конец таблицы
        //$('#MTable tbody>tr:last').clone(true).insertAfter('#MTable tbody>tr:last');
        //Получаем количество строк в таблице
        var tab = document.getElementById("MTable");
        var rows = $("#MTable tr").length;
        var row_content = '<tr id = "tr"' + rows + '><td><input type="text" id = "name' + rows + '" name="name' + rows;
        row_content += '" value="" pattern = "^[A-Za-zА-Яа-яЁё0-9 -]+$"></br><h3><textarea  id = "composition'+rows;
        row_content += '" name="composition' + rows + '" pattern = "^[A-Za-zА-Яа-яЁё0-9 ]+$"></textarea></h3></td>';
        row_content += '<td><h2><input class = "col2" type="text" id = "portion'+rows+'" name="portion'+rows;
        row_content += '" value="" pattern = "^[0-9]+$"></h2></td><td><h2><input class = "col3" type="text" id = "cost';
        row_content += rows + '" name="cost{{ key }}" value="0.00" pattern = "^[0-9.]+$"></h2>';
        row_content += '</td><td><h2><input type="checkbox" name="id' + rows + '" value=' + rows + '></h2></td></tr></tr>';
        console.info(row_content);

        $(row_content).insertAfter($('#MTable tbody>tr:last'));
    });

    $('#myform').on('change', 'input[type=checkbox]', function(e) {
        //alert(this.name+' '+this.value+' '+this.checked);
        //Удаляем текущую строку
        $(this).closest('tr').remove();
     });

    $('#myform').submit(function(){

        //Получаем данные из формы
        var path = $("#_path").val();
        var nametab = $("#_nametab").val();

        //Получаем количество строк в таблице
        var tab = document.getElementById("MTable");
        var rows = $("#MTable tr").length;
        var name = [];
        var composition = [];
        var portion = [];
        var cost = [];

        var i = 0;
        var k = 0;
        for(i = 1; i < rows ; i++)//Пропускаем 0 строку с заголовками
        {
            for(k = 0; k < 3; k++) {//Обрабатываем три колонки
                var result = $("table tr:eq(" + i + ") td:eq(" + k + ")").html();
                //alert(result);
                if(k == 0){
                    //Первая ячейка в строке, по id="name?" получаем поряковый номер ? элементов в строке
                    var start = result.indexOf("id=\"name");
                    var pname = result.substring(start);
                    var end =  pname.indexOf("\"");
                    end =  pname.indexOf("\"",end+1);
                    pname = pname.substring(0,end+1);
                    var num = parseInt(pname.replace(/\D+/g,""));//поряковый номер элементов в строке
                    //Заносим в соответствующие массивы значения элементов
                    name[i-1] = $("#name"+num).val();
                    composition[i-1] = $("#composition"+num).val();
                    portion[i-1] = $("#portion"+num).val();
                    cost[i-1] = $("#cost"+num).val();
                }
            }
        }

        $.ajax({
            type: "POST",
            url: path,
            dataType: "json",
            data:{name: name, composition: composition, portion: portion, cost: cost, nametab: nametab},
            success: function(response){
                //$(".mess").text("Получен ответ: " + response.message + " " + response.code + " " + response.success);
                if(response.success){
                    alert( response.message);
                    console.info("Прибыли данные: " + response.message + " " + response.code + " " + response.success + " " + response.info);
                }
            }
        });
    });
});





function HtmltoExcel(namefile){
    var data_type = 'data:application/vnd.ms-excel,\uFEFF';
    var html = "<html xmlns='http://www.w3.org/1999/xhtml' lang='el-GR' lang='el-GR'>";
    html += '<?php Response.AddHeader("Content-Disposition", "inline;filename=filename.xls") ?>';
    html += "<meta http-equiv='content-type' content='text/plain; charset=UTF-8'/>";
    html += "<table border='2px'>";
    html += "<tr bgcolor='#87AFC6'><th>Название</th><th>Состав</th><th>Кол-во, гр.</th><th>Цена, грн.</th></tr>";//Строка с заголовками
    
    //Получаем количество строк в таблице
    var tab = document.getElementById("MTable");
    var rows = $("#MTable tr").length;
    var name = [];
    var composition = [];
    var portion = [];
    var cost = [];

    var i = 0;
    var k = 0;
    for(i = 1; i < rows ; i++)//Пропускаем 0 строку с заголовками
    {
        for(k = 0; k < 3; k++) {//Обрабатываем три колонки
            var result = $("table tr:eq(" + i + ") td:eq(" + k + ")").html();
            //alert(result);
            if(k == 0){
                //Первая ячейка в строке, по id="name?" получаем поряковый номер ? элементов в строке
                var start = result.indexOf("id=\"name");
                var pname = result.substring(start);
                var end =  pname.indexOf("\"");
                end =  pname.indexOf("\"",end+1);
                pname = pname.substring(0,end+1);
                var num = parseInt(pname.replace(/\D+/g,""));//поряковый номер элементов в строке
                //Заносим значения элементов в строку таблицы
                html += '<tr><td>' + $("#name"+num).val() + '</td><td>' + $("#composition"+num).val() +'</td>';
                html += '<td>' + $("#portion"+num).val() + '</td><td>' + $("#cost"+num).val() + '</td></tr>';
            }
        }
    }

    html += '</table>';
    //Находим элемент с id=shadow
    document.getElementById("shadow").href = data_type + encodeURIComponent(html);
    //Присваиваем имя файла
    document.getElementById("shadow").download = namefile +'.xls';
    //Выполняем click для элемента с id=shadow
    document.getElementById("shadow").click();
}

