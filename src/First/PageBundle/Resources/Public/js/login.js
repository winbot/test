$(document).ready(function(){
	//alert('ready');
	//Событие submit 
	$("form").submit(function(){
		//Получаем данные из формы
		var name=$("#_username").val();
		var word=$("#_password").val();
		var path=$("#_path").val();
		var text = "user: " + name + " password: " + word + " path: " + path;
		alert(text);
		
		$.ajax({
			type: "POST",
			url: path,
			dataType: "json",
			data:{username: name, password: word},
			success: function(response){
				$(".mess").text("Получен ответ: " + response.message + " " + response.code + " " + response.success);
				//alert( "Прибыли данные: " + response.message + " " + response.code + " " + response.success);
			}
		});
	});

});

