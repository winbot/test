/**
 * Created by winbot.vl on 29.04.2016.
 */
function func() {
    var name = $("#_username").val();
    var word = $("#_password").val();
    var path = $("#_path").val();
    var text = "user: " + name + " password: " + word + " path: " + path;
    alert(text);

    $.ajax({
        type: "POST",
        url: "http://www.edu:8080/app_dev.php/login_ajax",
        dataType: "json",
        data: {username: name, password: word},
        success: function (data) {
            alert("Прибыли данные: " + data);
        }
    });
}