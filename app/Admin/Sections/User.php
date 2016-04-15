<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

use App\Models\Role;
use App\Models\User;

AdminSection::registerModel(User::class, function(ModelConfiguration $model) {
	$model->setTitle(Helper::trans('database.users',2));

	// Display
	$model->onDisplay(function() {
		$display = AdminDisplay::table()->setColumns([
			AdminColumn::text('name', Helper::trans('database.users-name')),
			AdminColumn::text('email', Helper::trans('database.users-email')),
			AdminColumn::hash('hash', Helper::trans('database.users-id')),
			AdminColumn::image('image', Helper::trans('database.users-image')),
			AdminColumn::custom()->setLabel('Role')
				->setCallback(function($instance) {
					return Helper::trans('database.role-name-'.$instance->role->name);
				}),
			AdminColumn::boolfunction('isAdmin', 'Admin')
		]);
		$display->paginate(15);
		return $display;
	});

	// Create And Edit
	$model->onCreateAndEdit(function() {
		return $form = AdminForm::panel()->addBody(
			AdminFormElement::text('name', Helper::trans('database.users-name'))
				->required(),
			AdminFormElement::text('email', Helper::trans('database.users-email'))
				->required(),
			AdminFormElement::image('image', Helper::trans('database.users-image')),
			AdminFormElement::select('role_id', Helper::trans('database.roles'))
				->setModelForOptions(new Role)
				->setDisplay('name')
				->required()
		);
		return $form;
	});
})
	->addMenuPage(User::class, 100)
	->setIcon('fa fa-users');
