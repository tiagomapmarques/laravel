<?php
/*
 * Add the admin templates with a new namespace so they can be versatile.
 * Note that if they are located in the "Admin" folder, they will be
 * processed and included automatically in every page! So the best practice
 * is to store them in the resources/views/admin folder.
 */
View::addNamespace('admin', resource_path().'/views/admin/');

// Register custom columns
AdminColumn::register([
	'boolean'      => \App\Admin\Addons\Display\Column\Boolean::class,
	'hash'         => \App\Admin\Addons\Display\Column\Hash::class,
	'reference'    => \App\Admin\Addons\Display\Column\Reference::class,
	'translatable' => \App\Admin\Addons\Display\Column\Translatable::class,
]);

// Register custom Form Elements
// AdminFormElement::register([
// 	//
// ]);
