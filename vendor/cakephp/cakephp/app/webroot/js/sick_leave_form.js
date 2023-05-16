$(() => {
    //Dates validation
    $('#startDate').change(function() {
        if (new Date($(this).val()) > new Date($('#endDate').val())) {
            $(this).val($('#endDate').val());
        }
    }); 

    $('#endDate').change(function() {
        if (new Date($(this).val()) < new Date($('#startDate').val())) {
            $(this).val($('#startDate').val());
        }
    });
});