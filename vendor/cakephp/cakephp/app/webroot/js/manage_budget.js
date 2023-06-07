$(() => {
	var queryString = window.location.search;
	var urlParams = new URLSearchParams(queryString);

	var page = parseInt((urlParams.get("page") != null) ? urlParams.get("page") : 1);

	$("select#years").val(urlParams.get("year") ?? "");

	displayBudget();

    $("select#years").change(function () {
       displayBudget();
		urlParams.set("year", $(this).val());
		urlParams.set("page", 1);
		location.replace("http://localhost/Shop/vendor/cakephp/cakephp/manage-budget?" + urlParams.toString());
    });

	function displayBudget() {
		$.ajax({
			url: `http://localhost/Shop/vendor/cakephp/cakephp/get-budget?year=${$("select#years").val()}&page=${page}`,
			success: function(result) {
				let data = JSON.parse(result);
				let transactions = data[1];
				let sum	 = data[0]
				let pages = data[2];
				let html = '';
				for (let i = 0; i < transactions.length; i++) {
					html += `
						<tr>
							<td>${lang[transactions[i].Budget.type]}</td>
							<td>${transactions[i][0].amount}</td>
							<td>${transactions[i].Budget.date}</td>
							<td>${transactions[i].Budget.from}</td>
						</tr>
					`;
				}

				if (pages > 1) {
					let paginationHtml = "<i class='fas fa-angle-left page-prev' data-page='-1'></i>";
					for (let i = page - 2; i <= page + 2; i++) {
						paginationHtml += (i > 0 && i <= pages) ?
							((i == page) ? `<p class='bold'>${i}</p>` : `<p>${i}</p>`) :
							"";
					}
					paginationHtml += "<i class='fas fa-angle-right page-next' data-page='1'></i>";
					$(".pagination").html(paginationHtml);

					$(".pagination p:not(.bold)").click(function() {
						urlParams.set("page", $(this).text());
						urlParams.set("year", $("select#years").val());
						location.replace("http://localhost/Shop/vendor/cakephp/cakephp/manage-budget?" + urlParams.toString());
					});


					$(".pagination .fas").click(function() {
						if (page + $(this).data("page") != 0 && page + $(this).data("page") <= $(".pagination").data("count")) {
							urlParams.set("page", (page + parseInt($(this).data("page")) > 0 ? page + parseInt($(this).data("page")) : 1))
							urlParams.set("year", $("select#years").val());
							location.replace("http://localhost/Shop/vendor/cakephp/cakephp/manage-budget?" + urlParams.toString());
						}
					});
				}
				$("table#budget tbody").html(`${html}`);
				$("#sum").html(`${sum} USD`);
			}
		});
	}
})
