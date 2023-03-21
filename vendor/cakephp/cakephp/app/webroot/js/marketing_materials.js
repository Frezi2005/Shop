$(() => {
	let btn = $('button');
	let img = $('img#flyer');
	btn.click(() => {
		let impath = img.attr('src');
		let fn = getFileName(impath);
		saveAs(impath, fn);
	});

	function getFileName(str) {
		return str.substring(str.lastIndexOf('/') + 1);
	}
})
