$(() => {

    let params = new URLSearchParams(window.location.search);

    $("select#sort").find("[value='" + params.get("sort_by") + "']").attr("selected", true);
    
    $("#sort").change(function() {
        params.set("sort_by", $(this).val());
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/invoices?" + params.toString());
    });
});