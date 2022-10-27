$(() => {
    var pending = JSON.parse($("#pending").val().replaceAll("'", "\""));
    var html = '';

    for (const [key, value] of Object.entries(pending)) {
        console.log(value.Holiday);
        html += `<div>`;
    }

});