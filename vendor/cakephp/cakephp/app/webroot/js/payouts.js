$(() => {
	$("#pay").click(function() {
		let employees = [];
		$('input[type=checkbox]:checked').each(function() {
			employees.push($(this).data("user-id"));
		});
		$.ajax({
			url: `http://localhost/Shop/vendor/cakephp/cakephp/handle-payouts
			?employees=${encodeURI(JSON.stringify(employees))}&year=${$('#year').val()}&month=${$('#month').val()}`,
			success: function(result) {
				if (result == -1) {
					Swal.fire({
						icon: 'error',
						text: 'Not enough funds in budget!'
					});
				} else {
					location.reload();
				}
			}
		});
	});
})
