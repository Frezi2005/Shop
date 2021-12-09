$(() => {
    $("#grantAdmin").click(function() {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/grant-admin-privileges?id="+$("select#usersSelect").val()+"&admin=1",
            success: function(result) {
                console.log("essing w chuj")
            }
        });
    });
});