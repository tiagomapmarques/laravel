
/**
 * List of functions to be used for the search mechanism
 */

// Initializes the search button interaction
function search_init() {
	$('#search-button').click(search_button_click);
}

// performs the search button click action
function search_button_click() {
	var bar = $('#search-bar');
	var form = bar.find('form');
	var input = form.find('input');
	if(bar.width()>0) {
		if(input.val().length>0) {
			form.submit();
		}
		else {
			search_bar_animate('-', form.outerWidth());
		}
	}
	else {
		search_bar_animate('+', form.outerWidth());
	}
}

// animates the search bar
function search_bar_animate(signal, width) {
	$('#search-bar').animate({ "width": signal + '=' + width + 'px' });
}
