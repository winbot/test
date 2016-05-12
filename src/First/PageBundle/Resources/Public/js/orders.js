
$(document).ready(function(){
    //Инициализируем переменные
    var flag_request = true; //Разрешение отправлять запросы
    var id_order = 0; //Текущий номер ордера

    //Проверяем checkbox id=acc_order, если установлен
    //отправляем запрос на вывод обработаных заказов
    $("#acc_order").click (function(){
        if($("#acc_order").prop('checked')) {
            //Выключаем таймер ожиданияинеобработаных заказов
            $("#wake_order").prop('checked', false);
            var flag_request = false; //Запрещаем отправлять запросы
            //Получаем путь для запроса
            var path = $("#path").val();
            var req = [1,0,0,0];//1 элемент status, 2 элемент id_order, 3 элемент owner_order, 4 элемент дата и время заказа
            $.ajax({
                type: "POST",
                url: path,
                dataType: "json",
                data: {req: req},
                success: function (response) {
                    if (response.success) {//Есть обработанные заказы

                        //Получаем данные из ответа
                        var dt = response.dt;//Дата и время заказа
                        var id_order = response.id_order;//id заказа
                        var username = response.username;//Имя хозяина заказа
                        var col_item = response.col_item;//Количество заказов
                        var content = ' • ';
                        var i = 0;

                        //Формируем ссылки на заказы
                        for(i = 0; i < col_item; i++){
                            content += username[i] + ' ' + id_order[i] + '-' + dt[i] + ' • ';
                        }

                        //Скрываем имя, дату и номер заказа
                        $('#user').empty();
                        //$('#user').hide();

                        //Вносим новые данные
                        $("#user").append(content);

                    } else {
                    }
                }
            });
        }
    });

    //Устанавливаем таймер на 5 сек
    setInterval(function()
    {
        //Получаем путь для запроса
        var path = $("#path").val();

        //Проверяем checkbox id=wake_order, если установлен и flag_request=true
        //отправляем запрос на наличие необработаных заказов
        if($("#wake_order").prop('checked') && flag_request) {

            //Выключаем запрос обработаных заказов
            $("#acc_order").prop('checked', false);

            //Запрещаем отправку запросов пока не обработаем полученный ответ
            flag_request = false;
            //Формируем запрос на наличие не обработаных заказов
            var req = [0,0,0,0];//1 элемент status, 2 элемент id_order, 3 элемент owner_order, 4 элемент дата и время заказа
            $.ajax({
                type: "POST",
                url: path,
                dataType: "json",
                data:{req: req},
                success: function(response){
                    if(response.success){//Есть не обработанные заказы

                        //Получаем данные из ответа
                        var dt = response.dt;//Дата и время заказа
                        var col_item = response.col_item;//Количество элементов в заказе
                        var name_dishes = [];
                        name_dishes= response.name_dishes;
                        var portion = [];
                        portion = response.portion;
                        var cost = [];
                        var cost = response.cost;
                        var username = response.username;
                        //Если поступила информация с новым номером заказа
                        //Удаляем текущую таблицу и выводим показываем новую
                        if(id_order != response.id_order) {
                            console.info(response.id_order);
                            //Скрываем ссылку 'Показать обработаные заказы'
                            $('.ref').hide();
                            //Скрываем список посетителей оформивших заказ
                            $("#main_menu").hide();
                            
                            //Проверяем существование таблицы
                            //если существует, удаляем
                            if($("table").is("#MTable") == true) $("#MTable").empty();

                            //Выводим таблицу в документе
                            //Заголовок в таблице
                            var table = '<table id="MTable"><tr><th><h1>Название</h1></th><th><h1>Кол-во, гр.</h1></th><th><h1>Цена, грн.</h1></th></tr>';
                            //Данные в таблице
                            var i = 0;
                            var total_cost = 0.00;
                            for (i = 0; i < col_item; i++) {
                                table += '<tr><td><h2>' + name_dishes[i] + '<h2></td>';
                                table += '<td><h2>' + portion[i] + '</h2></td>';
                                table += '<td><h2>' + cost[i] + '</h2></td></tr></tr>';
                                if(i == 0){
                                    total_cost = cost[i];
                                }else {
                                    total_cost += cost[i];
                                }
                            }
                            table += '<tr><td><h2><h2></td>';
                            table += '<td><h2></h2></td>';
                            table += '<td><h2>Всего: ' + total_cost + ' грн.</h2></td></tr></tr>';
                            table += '</table>';
                            $("#detail").append(table);

                            //Изменяем текущий номер заказа
                            id_order = response.id_order;

                            
                            //Показываем имя пользователя, номер заказа и дату заказа
                            $("#new_order").append("<p><h5>Заказ №" + id_order + " для: " + username + " - " + dt + "<h5>");

                        }
                        //Разрешаем отправлять запросы
                        flag_request = true;

                     }else{
                        //Проверяем существование таблицы
                        //если существует, удаляем
                        if($("table").is("#MTable") == true)$("#MTable").empty();

                        //Скрываем имя , дату и номер заказа
                        $('#new_order').empty();
                        $('#new_order').hide();

                        //Разрешаем отправлять запросы
                        flag_request = true;
                    }
                }
            });//запрос на наличие не обработаных заказов
        }
    }, 5000);//Таймер 5 сек
});
