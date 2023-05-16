//Function responsible for converting hours and minutes to unix timestamp
function timeToUnix(s) {
	return moment(`${moment().format('YYYY-MM-DD')} ${s.replaceAll('-', '').padStart(5, '0')}:00`).format("X")
}

//Function calculating difference between two hours
function differenceBetweenTwoHours(s, e) {
	let hours = ~~((new Date((typeof e === 'string' ? timeToUnix(e) : e) * 1000) -
		new Date(((typeof s === 'string' ? timeToUnix(s) : s) * 1000) -
			((((typeof s === 'string' ? timeToUnix(s) : s) * 1000) > ((typeof e === 'string' ? timeToUnix(e) : e) *
				1000)) ? 1000 * 60 * 60 * 24 : 0))) / 1000);
	return {
		hours: ~~(hours / 60 / 60),
		minutes: (hours - ~~(hours / 60 / 60) * 3600) / 60 ,
		whole: hours / 60 / 60
	};
}
