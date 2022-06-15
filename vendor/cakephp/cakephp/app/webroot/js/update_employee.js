$(function() {
    function generateInputs(id, employee) {
        let html = '';
        delete employee.id;
        for(const value in employee) {
            html += `${value}: <input type="text" value="${employee[value]}"/>`;
        }
        html += '<button id="updateEmployee">Save</button>';
        $("div#inputs").html(html);
    }
    generateInputs($("#employeesSelect").val(), $("#employeesSelect").find(":selected").data("employee"));
    $("#employeesSelect").change(function() {
        generateInputs($(this).val(), $(this).find(":selected").data("employee"));
    });

    $("#updateEmployee").click(function() {
        const inputs = $("#inputs input");
        $.ajax({
            type: "GET",
            url: `http://localhost/Shop/vendor/cakephp/cakephp/update-employee?
            name=${inputs[0].value}&
            surname=${inputs[1].value}&
            email=${inputs[2].value}&
            salary=${inputs[3].value}&
            internship_length=${inputs[4].value}&
            bonus_amount=${inputs[5].value}&
            holiday_amount=${inputs[6].value}`,
            success: function(data) {
                console.log(data);
            }
        });
    });

});