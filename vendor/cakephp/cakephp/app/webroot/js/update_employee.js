$(function() {
    function generateInputs(id, employee) {
        let html = `<input type="hidden" value="${employee.id}"/>`;
        delete employee.id;
        for (const value in employee) {
            html += `${lang[value]}: <input type="text" value="${employee[value]}"/>`;
        }
        html += `<button id="updateEmployee">${lang.save}</button>`;
        $("div#inputs").html(html);
    }
    generateInputs($("#employeesSelect").val(), $("#employeesSelect").find(":selected").data("employee"));
    $("#employeesSelect").change(function() {
        generateInputs($(this).val(), $(this).find(":selected").data("employee"));
    });

    $("#updateEmployee").click(function() {
        const inputs = $("#inputs input");
        console.log(inputs);
        $.ajax({
            type: "GET",
            url: `http://localhost/Shop/vendor/cakephp/cakephp/update-employee?
            id=${inputs[0].value}&
            name=${inputs[1].value}&
            surname=${inputs[2].value}&
            email=${inputs[3].value}&
            salary=${inputs[4].value}&
            bonus_amount=${inputs[5].value}&
            holiday_amount=${inputs[6].value}`,
            success: function(data) {
                console.log(data);
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

});
