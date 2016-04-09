
/**
 * List of functions to be inserted to our vanilla jQuery
 */

jQuery.fn.rotate = function(degrees) {
	return jquery_addon_transform($(this), 'rotate', degrees + 'deg', true);
}
jQuery.fn.translate = function(x, y) {
	return jquery_addon_transform($(this), 'translate', x + 'px, ' + y + 'px', true);
}
jQuery.fn.scale = function(x, y) {
	return jquery_addon_transform($(this), 'scale', x + ', ' + y, true);
}

function jquery_addon_transform(element, operation, arguments, keep_matrix) {
	var matrix = element.css('transform');
	if(matrix==='none' || !keep_matrix) {
		matrix = '';
	}
	element.css({
		'-webkit-transform' : matrix + ' ' + operation + '('+ arguments +')',
		'-moz-transform' : matrix + ' ' + operation + '('+ arguments +')',
		'-ms-transform' : matrix + ' ' + operation + '('+ arguments +')',
		'transform' : matrix + ' ' + operation + '('+ arguments +')'
	});
	return element;
};
