$(document).ready(function(){
    show();
    setInterval('show()',5000);
});

function show()
{
    $.ajax({
        url: "time.php",
        cache: false,
        success: function(html){
            $("#content").html(html);
        }
    });
}
