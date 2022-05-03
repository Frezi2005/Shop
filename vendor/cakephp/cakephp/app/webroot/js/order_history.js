$(function() {

    $(".order").each(function() {
        var ids = JSON.parse($(this).find("input[type=hidden]").val());
        var html = '';
        for (var i = 0; i < ids.length; i++) {
            html += `<img src='app/webroot/img/${checkImage(ids[i])}.jpg'/>`;
        }
        $(this).find("span.images").append(html);
    });

    function checkImage(id) {
        var img = new Image();
        img.src = `http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/${id}.jpg`;
        return (img.height != 0) ? id : 'noimg';
    }

});