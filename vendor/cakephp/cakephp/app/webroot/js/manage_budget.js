$(() => {
    $("select#years").change(function () {
        $.ajax({
            url: `http://localhost/Shop/vendor/cakephp/cakephp/get-budget?year=${$(this).val()}`,
            success: function(result) {
				console.log(result);
                let data = JSON.parse(result);
                let transactions = data[1];
                let sum	 = data[0]
                let html = '';
                for (let i = 0; i < transactions.length; i++) {
                    html += `
						<tr>
							<td>${transactions[i].Budget.type}</td>
							<td>${transactions[i][0].amount}</td>
							<td>${transactions[i].Budget.date}</td>
							<td>${transactions[i].Budget.from}</td>
						</tr>
					`;
                }
                $("table#budget").html(html);
                $("#sum").html(`${sum} USD`);
            }
        });
    });

})
