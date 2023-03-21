$(() => {
    let months = '';

    let userId = $("#userId").val();

    for (let i = 0; i < 12; i++) {
        months += `<option value='${String(i + 1).padStart(2, '0')}' ${new Date().getMonth() == i ? 'selected=\'selected\'' : ''}'>${new Date(`2022-${String(i + 1).padStart(2, '0')}-01`).toLocaleString('default', { month: 'long' })}</option>`;
    }

    $("#months").append(months);

    $('#hours').html(`<h3>Suma godzin: ${generateCalendar($("#months").val())}</h3>`);

    $("#months").change(function() {
        $('#hours').html(`<h3>Suma godzin: ${generateCalendar($(this).val())}</h3>`);
    });

    function generateCalendar(month) {
        let date = new Date(`${new Date().getFullYear()}-${month}-01`);
        let firstDay = new Date(date.getFullYear(), date.getMonth());
        let lastDay = new Date(new Date(date.getFullYear(), (date.getMonth() + 1) % 12).setDate(new Date(date.getFullYear(), (date.getMonth() + 1) % 12).getDate() - 1));
        let html = '';
        firstDay = new Date(firstDay.setDate(firstDay.getDate() - (!firstDay.getDay() ? 7 : firstDay.getDay()) + 1));
        lastDay = new Date(date.setDate(lastDay.getDate() + 7 - lastDay.getDay()));
        let weeks = getWeeksBetween(firstDay, lastDay);
        let days;

        $.ajax({
            url: 'http://localhost/Shop/vendor/cakephp/cakephp/get-employee-timeshifts'+
                `?start_date=${firstDay.getFullYear()}-${String(firstDay.getMonth() + 1).padStart(2, '0')}-${String(firstDay.getDate()).padStart(2, '0')}`+
                `&end_date=${lastDay.getFullYear()}-${String(lastDay.getMonth() + 1).padStart(2, '0')}-${String(lastDay.getDate()).padStart(2, '0')}`+
                `&user_id=${userId}`,
            async: false,
            success: (res) => {
                days = JSON.parse(res);
            }
        });

		let sum = 0;

        for (let i = 0; i < weeks.length; i++) {
            html += '<tr>';
            for (let j = 0; j < weeks[i].length; j++) {
                let timeshift_date = days.find(x => x.Timeshift.date == weeks[i][j].date);
                let hours = timeshift_date?.Timeshift.hours;
                let start = String(new Date(+timeshift_date?.Timeshift.start * 1000).getHours()).padStart(2, '0')+":"+String(new Date(+timeshift_date?.Timeshift.start * 1000).getMinutes()).padStart(2, '0');
                let end = String(new Date(+timeshift_date?.Timeshift.end * 1000).getHours()).padStart(2, '0')+":"+String(new Date(+timeshift_date?.Timeshift.end * 1000).getMinutes()).padStart(2, '0');
                if (timeshift_date && new Date(timeshift_date.Timeshift.date).getMonth() + 1 == month) {
					sum += +timeshift_date.Timeshift.hours;
				}
				html += `<td class='border align-baseline text-center ${timeshift_date ? 'event' : ''} ${new Date(weeks[i][j].date).getMonth() != month - 1 ? 'other-month' : 'bg-white'} ${new Date(weeks[i][j].date).getDay() == 6 || new Date(weeks[i][j].date).getDay() == 0 ? 'text-danger' : ''}'>${weeks[i][j].date}<br/>${timeshift_date ? '<h2>'+~~(+hours / 60 / 60)+'h '+new Date(+hours * 1000).getMinutes()+'m</h2><h6>'+start+' - '+end+'</h6>' : ''}</td>`;
            }
            html += '</tr>';
        }

        $("#calendar tbody").html(html);

        $("#calendar td").click(function() {
            let date = $(this).text();
            Swal.fire({
                title: 'Multiple inputs',
                html: '<input id="startHour" class="swal2-input" placeholder="Shift start(hh:mm)"><input id="endHour" class="swal2-input" placeholder="Shift end(hh:mm)">',
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        resolve({
                            "start": $('#startHour').val(),
                            "end": $('#endHour').val()
                        })
                    })
                },
                didOpen: function () {
                    $('#startHour').focus()
                }
            }).then(function (result) {
				let [startHour, startMinute] = result.value.start.split(':');
				let [endHour, endMinute] = result.value.end.split(':');
				let timeRegex = /^[0-9]{1,2}:[0-9]{2}$/g;
				if (startHour > 24 || endHour > 24 || startMinute > 60 || endMinute > 60 ||
					timeToUnix(result.value.start) < 0 || timeToUnix(result.value.end) < 0 ||
					timeToUnix(result.value.start) > timeToUnix(result.value.end) ||
					!result.value.start.match(timeRegex) || !result.value.end.match(timeRegex)
				) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Please input valid hours.'
					});
				} else {
					$.ajax({
					    url: `http://localhost/Shop/vendor/cakephp/cakephp/add-timeshift?date=${date}&user_id=${$("#userId").val()}&start=${result.value.start}&end=${result.value.end}`,
						success: (res) => {
							location.reload();
						}
					});
				}
            }).catch(swal.noop)
        });

		return `${~~(sum / 60 / 60)}h ${(sum - ~~(sum / 60 / 60) * 3600) / 60}m`;
    }

	const timeToUnix = (s) => {
		return moment(`${moment().format('YYYY-MM-DD')} ${s.replaceAll('-', '').padStart(5, '0')}:00`).format("X")
	}

    function getWeeksBetween(start, end) {
        let weeks = [];
        let dates = [];
        let i = 0;
        const curDate = new Date(start.getTime());
        while (curDate <= end) {
            const dayOfWeek = curDate.getDay();
            dates.push({
                date: `${curDate.getFullYear()}-${String(curDate.getMonth() + 1).padStart(2, '0')}-${String(curDate.getDate()).padStart(2, '0')}`,
                weekend: !(dayOfWeek !== 0 && dayOfWeek !== 6)
            })
            curDate.setDate(curDate.getDate() + 1);
            if ((i + 1) % 7 == 0 || i + 1 == Math.ceil((end - start) / 1000 / 60 / 60 / 24) + 1) {
                weeks.push(dates);
                dates = [];
            }
            i++;
        }
        return weeks;
    }
});
