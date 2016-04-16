
/**
 * List of functions to be used for the Lurk Search
 */

// Initializes the search buttons interaction
function nav_init() {
	$('.navbar-toggle').click(toggle_nav_click);
	$('#search-button-nav').click(search_button_nav_click);
	$('#search-button-bar').click(search_button_bar_click);
	$('#search-cancel-bar').click(search_cancel_bar_click);
	if($('#search-bar').is(":visible")) {
		var input = $('#search-bar input')
		input.focus();
	}
}

//
function toggle_nav_click() {
	if($('.navbar-toggle').attr('class').indexOf('collapsed')<0) {
		$('#navbar-toggle-icon-2')
			.scale(1.25,1)
			.rotate(-50)
			.translate(5,0);
		$('#navbar-toggle-icon-3')
			.scale(1.25,1)
			.rotate(50)
			.translate(-5,6);
	}
	else {
		$('#navbar-toggle-icon-2')
			.translate(-5,0)
			.rotate(50)
			.scale(0.8,1);
		$('#navbar-toggle-icon-3')
			.translate(5,-6)
			.rotate(-50)
			.scale(0.8,1);
	}

}

// performs the search buttons' click actions
function search_button_nav_click() {
	var bar = $('#search-bar');
	if(parseInt(bar.css('marginTop'))<0) {
		search_bar_show();
	}
}
function search_button_bar_click() {
	var form = $('#search-bar').find('form');
	form.submit();
}
function search_cancel_bar_click() {
	var bar = $('#search-bar');
	if(parseInt(bar.css('marginTop'))>=0) {
		search_bar_hide();
	}
}

// functions to animate the search bar
function search_bar_show() {
	var bar = $('#search-bar');
	search_bar_animate('+', bar.outerHeight());
	// focus the search input
	$('#search-input-bar form input').focus();
}
function search_bar_hide() {
	var bar = $('#search-bar');
	search_bar_animate('-', bar.outerHeight());
}

// search bar animation
function search_bar_animate(signal, height) {
	if(signal==='+') {
		$('#nav .container-fluid').animate({ "opacity": '0' }, 100);
	}
	else if(signal==='-') {
		$('#nav .container-fluid').animate({ "opacity": '1' }, 400);
	}
	$('#search-bar').animate({ "margin-top": signal + '=' + height + 'px' }, 300);
}
