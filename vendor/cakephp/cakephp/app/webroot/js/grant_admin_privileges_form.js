$(() => {
	//Granting admin privileges to specific employee
	$("#grantAdmin").click(function() {
		$.ajax({
			url: `http://localhost/Shop/vendor/cakephp/cakephp/grant-admin-privileges?`+
				`id=${$("select#usersSelect").val()}`+
				`&admin=1`,
			success: function(result) {
				Swal.fire({
					title: lang.success,
					text: lang.admin_granted,
					icon: "success",
					button: "OK",
					onClose: () => {
						location.reload();
					}
				});
			}
		});
	});
})
