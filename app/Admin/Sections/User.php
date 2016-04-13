<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

use App\Models\User;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
	$model->setTitle(Helper::trans('database.user',2));

	// Display
	$model->onDisplay(function () {
		$display = AdminDisplay::table()->setColumns([
			AdminColumn::text('name', Helper::trans('database.user-name')),
			AdminColumn::text('email', Helper::trans('database.user-email')),
			AdminColumn::hash('hash', Helper::trans('database.user-id')),
			AdminColumn::image('image', Helper::trans('database.user-image'))
		]);
		$display->paginate(15);
		return $display;
	});

	// Create And Edit
	$model->onCreateAndEdit(function() {
		return $form = AdminForm::panel()->addBody(
			AdminFormElement::text('name', Helper::trans('database.user-name'))
				->required(),
			AdminFormElement::text('email', Helper::trans('database.user-name'))
				->required(),
			AdminFormElement::image('image', Helper::trans('database.user-image'))
		);
		return $form;
	});
})
	->addMenuPage(User::class, 100)
	->setIcon('fa fa-users');
