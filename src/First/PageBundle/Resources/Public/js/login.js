$(document).ready(function(){
	alert('ready');
	$("form").submit(function(){
		var user=$("#_username").val();
		var word=$("#_password").val();
		var path=$("#_path").val();
		var text = "user: " + user + " password: " + word + " path: " + path;
    alert(text);
    });

});

function newfunc(name) {
	//
	//$("#press1").hide();
	/*var el = document.getElementById("press").id;
	 var user = document.getElementById("user").id;*/

	alert("5");
	return false;
}