
/**
 * List of functions to be used for the search mechanism
 */

// Initializes the search button interaction
function search_init() {
	$('#search-button-nav').click(search_button_nav_click);
	$('#search-button-bar').click(search_button_bar_click);
	$('#search-cancel-bar').click(search_cancel_bar_click);
}

// performs the search button click action
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

// animates the search bar
function search_bar_show() {
	var bar = $('#search-bar');
	search_bar_animate('+', bar.outerHeight());
}
function search_bar_hide() {
	var bar = $('#search-bar');
	search_bar_animate('-', bar.outerHeight());
}
function search_bar_animate(signal, height) {
	if(signal==='+') {
		$('#nav .container-fluid').animate({ "opacity": '0' }, 100);
	}
	else if(signal==='-') {
		$('#nav .container-fluid').animate({ "opacity": '1' }, 400);
	}
	$('#search-bar').animate({ "margin-top": signal + '=' + height + 'px' }, 300);
}
