$(() => {
	//Granting admin privileges to specific employee
	$("#revokeAdmin").click(function() {
		$.ajax({
			url: `http://localhost/Shop/vendor/cakephp/cakephp/revoke-admin-privileges?`+
				`id=${$("select#usersSelect").val()}`+
				`&admin=0`,
			success: function(result) {
				Swal.fire({
					title: lang.success,
					text: lang.admin_revoked,
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
