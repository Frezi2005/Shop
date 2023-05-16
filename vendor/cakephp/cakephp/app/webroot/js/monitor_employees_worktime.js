$(() => {
	var params = new URLSearchParams(window.location.search);
	let year = params.get("year") ?? new Date().getFullYear()
	let month = params.get("month") ?? +(new Date().getMonth()) + 1
	$("#year").val(year);
	$("#month").val(month);
	$("h3#date").text(`${new Date(new Date().setMonth(month - 1)).toLocaleString($('#lang').val() == 'eng' ? 'en-US' : 'pl-PL', { month: 'long' })} ${year}`);

	$("#year, #month").change(function() {
		params.set("month", $("#month").val());
		params.set("year", $("#year").val());
		location.replace("http://localhost/Shop/vendor/cakephp/cakephp/monitor-employees-worktime?" + params.toString());
	});

	let sums = {};
	let timeshifts = [];
	let userIds = [];
	let employees = JSON.parse($('#employees').val());
	employees.map(u => userIds.push({id: u.Timeshift.user_id, name: u.User.name, surname: u.User.surname}));
	userIds = [...new Map(userIds.map(u => [u.id, u])).values()]
	userIds.map(u => sums[u.id] = 0);
	for (let i = 0; i < userIds.length; i++) {
		for (let timeshift of employees.filter(u => u.Timeshift.user_id == userIds[i].id)) {
			sums[userIds[i].id] += differenceBetweenTwoHours(+timeshift.Timeshift.start, +timeshift.Timeshift.end).whole * 60 * 60;
		}
	}

	for (let i = 0; i < userIds.length; i++) {
		timeshifts.push({
			user_id: userIds[i].id,
			name: userIds[i].name,
			surname: userIds[i].surname,
			sum: `${~~(sums[userIds[i].id] / 60 / 60)}h ${(sums[userIds[i].id] - ~~(sums[userIds[i].id] / 60 / 60) * 3600) / 60}m`
		})
	}

	for (let timeshift of timeshifts) {
		$("#timeshifts").append(`<p>${timeshift.name} ${timeshift.surname} (${timeshift.user_id}) - <b>${timeshift.sum}</b></p>`);
	}

	if (timeshifts.length == 0) {
		$("#timeshifts").html(`<h3>${lang.no_employees_hours}</h3>`);
	}
});
