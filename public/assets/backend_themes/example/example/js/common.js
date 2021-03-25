$(document).ready(function() {
	// Sidebar
	$('#button-menu').on('click', function(e) {
		e.preventDefault();
		
		$('#sidemenu').toggleClass('active');
	});

	// Set last page opened on the menu
	$('#menu a[href]').on('click', function() {
		sessionStorage.setItem('menu', $(this).attr('href'));
	});

	if (!sessionStorage.getItem('menu')) {
		$('#menu #menu-dashboard').addClass('show');
	} else {
		// Sets active and open to selected page in the left column menu.
		$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().parent().parent().addClass('show');
	}

	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li > a').removeClass('collapsed');
	
	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('ul').addClass('in');
	
	$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('div').addClass('show');
	
});
