<?php
/*
 * Add the admin templates with a new namespace so they can be versatile.
 * Note that if they are located in the "Admin" folder, they will be
 * processed and included automatically in every page! So the best practice
 * is to store them in the resources/views/admin folder.
 */
View::addNamespace('admin', resource_path().'/views/admin/');

// Register custom Display Columns
AdminColumn::register([
	'boolean'      => \App\Admin\Addons\Display\Column\Boolean::class,
	'button'       => \App\Admin\Addons\Display\Column\Button::class,
	'hash'         => \App\Admin\Addons\Display\Column\Hash::class,
	'link'         => \App\Admin\Addons\Display\Column\Link::class,
	'reference'    => \App\Admin\Addons\Display\Column\Reference::class,
	'textFunction' => \App\Admin\Addons\Display\Column\TextFunction::class,
	'translatable' => \App\Admin\Addons\Display\Column\Translatable::class,
]);

// Register custom Form Elements
AdminFormElement::register([
	'translatableSelect' => \App\Admin\Addons\Form\Element\TranslatableSelect::class,
]);
