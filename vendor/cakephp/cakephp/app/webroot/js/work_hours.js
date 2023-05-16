$(() => {
    let months = '';
	let years = '';

    let userId = $("#userId").val();

	//Generating month and year selects
    for (let i = 0; i < 12; i++) {
        months += `
			<option value='${String(i + 1).padStart(2, '0')}' ${new Date().getMonth() == i ?
				'selected=\'selected\'' : ''}'>
				${new Date(`2022-${String(i + 1).padStart(2, '0')}-01`).toLocaleString('default', { month: 'long' })}
			</option>
		`;
    }

	var language = $('#lang').val();
	var weekDaysArr = {
		'eng': [
			'Mon.',
			'Tue.',
			'Wed.',
			'Thu.',
			'Fri.',
			'Sat.',
			'Sun.'
		],
		'pol': [
			'Pon.',
			'Wt.',
			'Śr.',
			'Czw.',
			'Pt.',
			'Sob.',
			'Niedz.'
		]
	}
	for (let i = new Date().getFullYear() - 5; i <= new Date().getFullYear() + 5; i++) {
		years += `<option value='${i}' ${new Date().getFullYear() == i ? 'selected=\'selected\'' : ''}'>${i}</option>`;
	}

	$("#months").append(months);
	$("#years").append(years);

	$('#hours').html(`<h3>${lang.hours_sum}: ${generateCalendar($("#years").val(), $("#months").val())}</h3>`);

    $("#months, #years").change(function() {
        $('#hours').html(`<h3>${lang.hours_sum}: ${generateCalendar($("#years").val(), $("#months").val())}</h3>`);
    });

	//Function responsible for generating the calendar html and events. Also it adds click listeners for each of the cells
	function generateCalendar(year, month) {
		let hourSymbol = language == 'eng' ? 'h' : 'g'
        let date = new Date(`${year}-${month}-01`);
		//Generating first and last day to have correct days at the start and end of the month
        let firstDay = new Date(date.getFullYear(), date.getMonth());
        let lastDay = new Date(new Date(
				date.getFullYear(),
				(date.getMonth() + 1) % 12
			).setDate(new Date(date.getFullYear(), (date.getMonth() + 1) % 12).getDate() - 1));
        let html = '';
        firstDay = new Date(firstDay.setDate(firstDay.getDate() - (!firstDay.getDay() ? 7 : firstDay.getDay()) + 1));
        lastDay = new Date(date.setDate(lastDay.getDate() + 7 - lastDay.getDay()));
        let weeks = getWeeksBetween(firstDay, lastDay);
        let days;

		//Getting current users timeshifts
        $.ajax({
            url: 'http://localhost/Shop/vendor/cakephp/cakephp/get-employee-timeshifts'+
                `?start_date=${firstDay.getFullYear()}-${String(firstDay.getMonth() + 1).padStart(2, '0')}-`+
                	`${String(firstDay.getDate()).padStart(2, '0')}`+
                `&end_date=${lastDay.getFullYear()}-${String(lastDay.getMonth() + 1).padStart(2, '0')}-`+
                	`${String(lastDay.getDate()).padStart(2, '0')}`+
                `&user_id=${userId}`,
            async: false,
            success: (res) => {
                days = JSON.parse(res);
            }
        });

		let sum = 0;

		//Generating and displaying days with timeshifts
        for (let i = 0; i < weeks.length; i++) {
            html += '<tr>';
            for (let j = 0; j < weeks[i].length; j++) {
                let timeshift_date = days.find(x => x.Timeshift.date == weeks[i][j].date);
                let hours = timeshift_date?.Timeshift.hours;
                let start = String(new Date(+timeshift_date?.Timeshift.start * 1000).getHours())
					.padStart(2, '0')+":"+String(new Date(+timeshift_date?.Timeshift.start * 1000)
					.getMinutes()).padStart(2, '0');
                let end = String(new Date(+timeshift_date?.Timeshift.end * 1000).getHours())
					.padStart(2, '0')+":"+String(new Date(+timeshift_date?.Timeshift.end * 1000)
					.getMinutes()).padStart(2, '0');
                let difference = differenceBetweenTwoHours(
					+timeshift_date?.Timeshift.start,
					+timeshift_date?.Timeshift.end
				);
				if (timeshift_date && new Date(timeshift_date.Timeshift.date).getMonth() + 1 == month) {
					sum += difference.whole * 60 * 60;
				}
				html += `
					<td class='border align-baseline text-center
						${new Date(weeks[i][j].date).getMonth() != month - 1 ? 'other-month' : 'bg-white'}'>
						<span class='
							${new Date(weeks[i][j].date).getDay() == 6 || new Date(weeks[i][j].date).getDay() == 0 ?
								'text-danger' : ''}'>
							${new Date(weeks[i][j].date).getDate()}
						</span><br/>
						${timeshift_date ?
							'<h2>'+difference.hours+hourSymbol+' '+difference.minutes+'m</h2><h6>'+start+' - '+end+'</h6>'
							: ''}
					</td>
				`;
            }
            html += '</tr>';
        }

		var weekDays = '';

		for (let i = 0; i < 7; i++) {
			weekDays += `<th>${weekDaysArr[language][i]}</th>`;
		}

		$('#calendar #weekDays').html(weekDays);
        $("#calendar tbody").html(html);

		//Adding a timeshift
        $("#calendar td:not(#selects)").click(function() {
            let date = `${year}-${month}-${$(this).text().replace(/\s/g, "").padStart(2, '0')}`;
			if (
				new Date(date).getMonth() == new Date().getMonth() &&
				new Date(date).getFullYear() == new Date().getFullYear()
			) {
				Swal.fire({
					title: 'Multiple inputs',
					html: '<input id="startHour" class="swal2-input" placeholder="Shift start(hh:mm)">' +
						'<input id="endHour" class="swal2-input" placeholder="Shift end(hh:mm)">',
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
					let difference = differenceBetweenTwoHours(result.value.start, result.value.end);
					if (startHour > 24 || endHour > 24 || startMinute > 60 || endMinute > 60 ||
						timeToUnix(result.value.start) < 0 || timeToUnix(result.value.end) < 0 || difference > 12 ||
						difference.whole > 12 || difference.whole < 1 ||
						!result.value.start.match(timeRegex) || !result.value.end.match(timeRegex)
					) {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: lang.valid_hours
						});
					} else {
						$.ajax({
							url: `http://localhost/Shop/vendor/cakephp/cakephp/add-timeshift?
								date=${date}&
								user_id=${$("#userId").val()}&
								start=${result.value.start}&
								end=${result.value.end}
							`,
							success: (res) => {
								location.reload();
							}
						});
					}
				}).catch(swal.noop)
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: lang.timeshift_in_other_month
				});
			}
        });

		return `${~~(sum / 60 / 60)}${hourSymbol} ${(sum - ~~(sum / 60 / 60) * 3600) / 60}m`;
    }

	//Function responsible for returning all weeks between 2 dates
    function getWeeksBetween(start, end) {
        let weeks = [];
        let dates = [];
        let i = 0;
        const curDate = new Date(start.getTime());
        while (curDate <= end) {
            const dayOfWeek = curDate.getDay();
            dates.push({
                date: `${curDate.getFullYear()}-${String(curDate.getMonth() + 1).padStart(2, '0')}-`+
                	`${String(curDate.getDate()).padStart(2, '0')}`,
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
