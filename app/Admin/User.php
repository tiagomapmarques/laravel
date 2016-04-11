<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

use App\User;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
	$model->setTitle(Helper::trans('database.user',2));

	// Display
	$model->onDisplay(function () {
		$display = AdminDisplay::table()->setColumns([
			AdminColumn::text('name')->setLabel(Helper::trans('database.user-name')),
			AdminColumn::text('email')->setLabel(Helper::trans('database.user-email')),
			AdminColumn::custom()->setLabel(Helper::trans('database.user-id'))
				->setCallback(function ($instance) {
					return implode('<br />',str_split($instance->hash, 32));
				}),
			AdminColumn::custom()->setLabel(Helper::trans('database.user-image'))
			->setCallback(function ($instance) {
				return $instance->image===''?
					'<i class="fa fa-minus"></i>':
					'<img height="50" src="/'.$instance->image.'" />';
			})
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
				->required()
		);

		return $form;
	});
})
	->addMenuPage(User::class, 0)
	->setIcon('fa fa-users');
