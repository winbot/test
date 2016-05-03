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
        var pname = "";
        var composition = "";
        var portion = "";
        var cost = "";
        var num = 0;
        var rows = $("#MTable tr").length;
        //alert(rows);
        var cols = $("#MTable td").length;
        //alert(cols);
        var s = $('#myform').serializeArray();
        //alert(s);
        var i = 0;
        var k = 0;
        for(i = 1; i < rows ; i++)//Пропускаем 0 строку с заголовками
        {
            for(k = 0; k < 3; k++) {
                var result = $("table tr:eq(" + i + ") td:eq(" + k + ")").html();
                //alert(result);
                if(k == 0){//Первая ячейка name и composition
                    var start = result.indexOf("id=\"name");
                    var name = result.substring(start);
                    var end =  name.indexOf("\"");
                    end =  name.indexOf("\"",end+1);
                    name = name.substring(0,end+1);
                    var num = parseInt(name.replace(/\D+/g,""));//Получаем поряковый индекс элементов в строке
                    pname += "name"+i+":";
                    pname += $("#name"+num).val();
                    composition = $("#composition"+num).val();
                    portion = $("#portion"+num).val();
                    cost = $("#cost"+num).val();
                    //alert("Строка: " + i + " name: " + name + " composition: " + composition + " portion: " + portion + " cost: " + cost);
                }
            }
            if(i != rows-1)pname += ", ";
        }
        //alert(path);
       //var data = $("#myform").serialize();
       //alert(pname);
        //var name = "name";
        var word = "word";
         var obj = [];
        obj[0]='name1';
        obj[1]='name2';
        $.ajax({
            type: "POST",
            url: path,
            dataType: "json",
            data:{name:obj,password:word},
            success: function(response){
                //$(".mess").text("Получен ответ: " + response.message + " " + response.code + " " + response.success);
                alert( "Прибыли данные: " + response.message + " " + response.code + " " + response.success + " " + response.info);
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

