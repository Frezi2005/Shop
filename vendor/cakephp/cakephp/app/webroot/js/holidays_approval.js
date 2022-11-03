$(() => {
    var pending = JSON.parse($("#pending").val().replaceAll("'", "\""));
    var html = '';

    for (const [key, value] of Object.entries(pending)) {
        value.Holiday.name = value.User.name;
        value.Holiday.surname = value.User.surname;
        value.Holiday.email = value.User.email;
        delete value.User;
    }

    pending = Object.values(pending);
    var holiday;

    for (let i = 0; i < pending.length; i++) {
        holiday = pending[i].Holiday;
        html += `
            <tr>
                <td>${holiday.name} ${holiday.surname}</td>
                <td>${holiday.email}</td>
                <td>${getBusinessDatesCount(new Date(holiday.start), new Date(holiday.end))}</td>
                <td>${holiday.status}</td>
                <td>${holiday.type}</td>
                <td><button class="btn btn-primary" data-method="approve">Zatwierdź</button></td>
                <td><button class="btn btn-danger" data-method="reject">Odrzuć</button></td>
                <td class="d-none"><span id="holiday">${holiday.id}</span><span id="user">${holiday.user_id}</span></td>
            </tr>
        `;
    }

    $("#holidays tbody").html(html);

    $("#table button").click(function() {
        var ids = $(this).parent().siblings().last().children();
        var holidayId = ids.first().text();
        var userId = ids.last().text();
        var method = $(this).data("method");
        console.log(`${method}:${holidayId}:${userId}`);
    })

    function getBusinessDatesCount(startDate, endDate) {
        let count = 0;
        const curDate = new Date(startDate.getTime());
        while (curDate <= endDate) {
            const dayOfWeek = curDate.getDay();
            if(dayOfWeek !== 0 && dayOfWeek !== 6) count++;
            curDate.setDate(curDate.getDate() + 1);
        }
        return count;
    }

});