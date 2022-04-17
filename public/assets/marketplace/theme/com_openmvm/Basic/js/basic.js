$( document ).ready(function() {
    var base = $('base').attr('href');

	$('#search input[name="search"]').keypress(function (e) {
        var keyword = $('#search input[name="search"]').val();

		if (e.which == 13) {
			window.location.href = base + '/marketplace/product/search?keyword=' + keyword;

			return false;
		}
	});

	$('#search').on('click', '#button-search', function() {
        var keyword = $('#search input[name="search"]').val();

		window.location.href = base + '/marketplace/product/search?keyword=' + keyword;
	});
});