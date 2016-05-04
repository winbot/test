$(document).ready(function(){

    $("#add").click(function(){
        //Клонируем последнюю строку и добавляем в конец таблицы
        $('#MTable tbody>tr:last').clone(true).insertAfter('#MTable tbody>tr:last');
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
        var num = 0;

        var i = 0;
        var k = 0;
        for(i = 1; i < rows ; i++)//Пропускаем 0 строку с заголовками
        {
            for(k = 0; k < 3; k++) {//Обрабатываем три колонки
                var result = $("table tr:eq(" + i + ") td:eq(" + k + ")").html();
                //alert(result);
                if(k == 0){
                    //Первая ячейка в строке, по id="name?" получаем поряковый номер элементов в строке
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

        //alert(name);
        $.ajax({
            type: "POST",
            url: path,
            dataType: "json",
            data:{name: name, composition: composition, portion: portion, cost: cost, nametab: nametab},
            success: function(response){
                //$(".mess").text("Получен ответ: " + response.message + " " + response.code + " " + response.success);
                alert( "Прибыли данные: " + response.message + " " + response.code + " " + response.success + " " + response.info);
                var temp = response.info;
                console.log(temp);
            }
        });
    });
});





function HtmltoExcel(namefile){
    var data_type = 'data:application/vnd.ms-excel,\uFEFF';
    var html = "<html xmlns='http://www.w3.org/1999/xhtml' lang='el-GR' lang='el-GR'>";
    html += '<?php Response.AddHeader("Content-Disposition", "inline;filename=filename.xls") ?>';
    html += "<meta http-equiv='content-type' content='text/plain; charset=UTF-8'/>";
    html += "<table border='2px'><tr bgcolor='#87AFC6'>";
    var i = 0;
    var tab = document.getElementById("MTable");
    //Пересобираем таблицу
    for(i = 0 ; i < tab.rows.length ; i++)
    {
        html=html+tab.rows[i].innerHTML+"</tr>";
    }
    //Очищаем таблицу от лишних элементов
/*    html= html.replace(/<A[^>]*>|<\/A>/g, "");
    html= html.replace(/<img[^>]*>/gi,"");
    html= html.replace(/<input[^>]*>|<\/input>/gi, "");
    html= html.replace(/<button[^>]*>|<\/button>/gi, "");
    html= html.replace(/<h2>/gi, "");
    html= html.replace(/<\/h2>/gi, "");*/

    //Находим элемент с id=shadow
    document.getElementById("shadow").href = data_type + encodeURIComponent(html);
    //Присваиваем имя файла
    document.getElementById("shadow").download = namefile +'.xls';
    //Выполняем click для элемента с id=shadow
    document.getElementById("shadow").click();
}

