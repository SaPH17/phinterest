function searchListener() {
	var search = $("#search-bar").val()
	setTimeout(() => {
		if (search === $("#search-bar").val()) {
			if (search === "") {
				window.location = "/"
			} else {
				window.location = "/search.php?q=" + $("#search-bar").val()
			}
			s
		}
	}, 500)
}
