
/**
 * List of functions to be inserted to our vanilla jQuery
 */

// Element Tranformations (Translate, Rotate, Scale)
jQuery.fn._custom_transform = (element, operation, arguments, keep_matrix) => {
	var matrix = element.css('transform');
	if (matrix === 'none' || !keep_matrix) {
		matrix = '';
	}
	var transformation = matrix + ' ' + operation + '(' + arguments + ')';
	element.css({
		'-webkit-transform': transformation,
		'-moz-transform': transformation,
		'-ms-transform': transformation,
		'transform': transformation
	});
	return element;
};
jQuery.fn.rotate = function(degrees) {
	return jQuery.fn._custom_transform($(this), 'rotate', degrees + 'deg', true);
}
jQuery.fn.translate = function(x, y) {
	return jQuery.fn._custom_transform($(this), 'translate', x + 'px, ' + y + 'px', true);
}
jQuery.fn.scale = function(x, y) {
	return jQuery.fn._custom_transform($(this), 'scale', x + ', ' + y, true);
}
