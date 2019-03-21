$(document).ready(function() {
    $(".radio-categoria").change(function() {
        var categoria = $('input[name=categoria]:checked').val();      
        $.ajax({
            type: "post",
            url: "catalogoTes.php",
            dataType: "json",
            data: {
                "categoria" : "granel"
            },
            success: function(result, textStatus, xhr) {
                //result = escapeSpecialChars(result);
                //console.log(JSON.parse(result));
                /*$.each(catalogo, function(i, val) {
                    console.log(val+" "+i);
                });*/
            },
            
            error: function(request, status, error) {
                //console.log(error);
            }
        });
    });
});

function escapeSpecialChars(jsonString) {
    return jsonString.replace(/\n/g, "\\n")
        .replace(/\r/g, "\\r")
        .replace(/\t/g, "\\t")
        .replace(/\f/g, "\\f");
}


