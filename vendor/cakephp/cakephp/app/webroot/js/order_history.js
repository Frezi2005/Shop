$(function() {

    $(".order").each(function() {
        // var ids = JSON.parse($(this).find("input[type=hidden]").val());
        // var html = "";
        // for (var i = 0; i < ids.length; i++) {
        //     html += `<img src="app/webroot/img/${checkImage(ids[i])}.jpg"/>`;
        // }
        // $(this).find("span.images").append(html);
        $(this).find(".fa-search").each(function() {
            $(this).click(function() {
                var fields = $(this).parent().parent().find(".fields").val();
                Swal.fire({
                    text: fields,
                    showConfirmButton: true
                });
            });
        });
    });

    // function checkImage(id) {
    //     var img = new File(`app/webroot/img/${id}.jpg`);
    //     console.log(img);
    //     // var returnSrc;
    //     // img.onload = (returnSrc) => { returnSrc = id; };
    //     // img.onerror = (returnSrc) => { returnSrc = "noimg"; };
    //     // img.src = `http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/${id}.jpg`;
    //     // console.log(returnSrc);
    //     // return returnSrc;
    // }

});