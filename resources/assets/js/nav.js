
/**
 * List of functions to be used for the Lurk Search
 */

// Initializes the search buttons interaction
function navInit() {
	$('.navbar-toggle').click(navbarToggle);
	$('#nav-search').click(navSearchClick);
	$('#search-bar-submit').click(searchBarSubmit);
	$('#search-bar-cancel').click(searchBarCancel);
	if ($('#search-bar').is(':visible')) {
		$('#search-bar-input').focus();
	}
}

// Toggles the navbar (on small displays)
function navbarToggle() {
	var defaultSelector = 'navbar-toggle';
	var element = this ? $(this) : $('.' + defaultSelector);
	var isCollapsed = element.attr('class').indexOf('collapsed') >= 0;
	if (isCollapsed) {
		$('#' + defaultSelector + '-icon-mid')
			.translate(-5,0)
			.rotate(50)
			.scale(0.8,1);
		$('#' + defaultSelector + '-icon-bot')
			.translate(5,-6)
			.rotate(-50)
			.scale(0.8,1);
	} else {
		$('#' + defaultSelector + '-icon-mid')
			.scale(1.25,1)
			.rotate(-50)
			.translate(5,0);
		$('#' + defaultSelector + '-icon-bot')
			.scale(1.25,1)
			.rotate(50)
			.translate(-5,6);
	}

}

// performs the search buttons' click actions
function navSearchClick() {
	var bar = $('#search-bar');
	if (parseInt(bar.css('marginTop')) < 0) {
		searchBarShow();
	}
}
function searchBarSubmit() {
	var form = $('#search-bar').find('form');
	form.submit();
}
function searchBarCancel() {
	var bar = $('#search-bar');
	if(parseInt(bar.css('marginTop')) >= 0) {
		searchBarHide();
	}
}

// functions to animate the search bar
function searchBarShow() {
	var bar = $('#search-bar');
	searchBarAnimate('down', bar.outerHeight());
	// focus the search input
	$('#search-input-bar form input').focus();
}
function searchBarHide() {
	var bar = $('#search-bar');
	searchBarAnimate('up', bar.outerHeight());
}

// search bar animation
function searchBarAnimate(direction, height) {
	var signal = '';
	if (direction === 'down') {
		$('#nav .container-fluid').animate({ 'opacity': '0' }, 100);
		signal = '+';
	}
	else if (direction === 'up') {
		$('#nav .container-fluid').animate({ 'opacity': '1' }, 400);
		signal = '-';
	}
	$('#search-bar').animate({ 'margin-top': signal  + '=' + height + 'px' }, 300);
}
