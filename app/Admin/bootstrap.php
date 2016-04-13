<?php
/*
 * Add the admin templates with a new namespace so they can be versatile.
 * - Note that if they are located in the "Admin" folder, they will be
 * processed and included automatically in every page!
 */
View::addNamespace('admin', resource_path().'/views/admin/');

// Register custom columns
AdminColumn::register([
	'hash' => \App\Admin\Addons\Display\Column\Hash::class,
]);

// Register custom Form Elements
// AdminFormElement::register([
// 	//
// ]);
