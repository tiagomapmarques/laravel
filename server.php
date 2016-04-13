<?php
/**
 * LURK - Laravel Up and Running Kit
 *
 * @author Tiago Marques <tsukinushi@gmail.com>
 */
$__public_path = __DIR__.'/public';

$uri = urldecode(
	parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists($__public_path.$uri)) {
	return false;
}

require_once $__public_path.'/index.php';
