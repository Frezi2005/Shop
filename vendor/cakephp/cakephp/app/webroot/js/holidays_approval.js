$(() => {
    var pending = JSON.parse($("#pending").val().replaceAll("'", "\""));
    var html = '';

    for (const [key, value] of Object.entries(pending)) {
        value.Holiday.name = value.User.name;
        value.Holiday.surname = value.User.surname;
        value.Holiday.email = value.User.email;
        value.Holiday.amount = value.User.holiday_amount;
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
                <td>
                	(${holiday.start} - ${holiday.end})
                	<b>${getBusinessDatesCount(new Date(holiday.start), new Date(holiday.end))}</b>
                </td>
                <td>${holiday.status}</td>
                <td>${holiday.type}</td>
                <td>${holiday.amount}</td>
                <td><button class="btn btn-success" data-method="approve">${lang.confirm}</button></td>
                <td><button class="btn btn-primary" data-method="reject">${lang.deny}</button></td>
                <td class="d-none"><span id="holiday">${holiday.id}</span><span id="user">${holiday.user_id}</span></td>
            </tr>
        `;
    }

    $("#holidays").html(`
        <tbody>
            <tr>
                <th>${lang.name}</th>
                <th>Email</th>
                <th>${lang.holiday_length}</th>
                <th>Status</th>
                <th>${lang.type}</th>
                <th>${lang.days_left_holiday}</th>
                <th></th>
                <th></th>
            </tr>
            ${html}
        </tbody>
    `);

    $("#table button").click(function() {
        var ids = $(this).parent().siblings().last().children();
        var holidayId = ids.first().text();
        var userId = ids.last().text();
        var method = $(this).data("method");
        var amount = +$(this).parent().parent().find('td:nth-of-type(3) b').text();
        $.ajax({
            url: `http://localhost/Shop/vendor/cakephp/cakephp/${method}-holidays?
				userId=${userId}&
				holidayId=${holidayId}&
				amount=${amount}
            `,
            success: function(result) {
                Swal.fire({
                    icon: result ? 'success' : 'error',
                    text: result ?
						`${lang.holiday_was} ${method == 'approve' ?
							lang.approved :
							lang.rejected
						} ${lang.successfully}!` :
						`${lang.holiday_couldnt_be} ${method == 'approve' ? lang.approved : lang.rejected}!`
                });
                setTimeout(() => {
                    location.reload();
                }, 2000)
            }
        });
    })
});
