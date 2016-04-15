<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

use App\Models\Role;

AdminSection::registerModel(Role::class, function(ModelConfiguration $model) {
	$model->setTitle(Helper::trans('database.roles',2));

	// Display
	$model->onDisplay(function() {
		$display = AdminDisplay::table()->setColumns([
			AdminColumn::translatable('name', Helper::trans('database.roles-name', 2))
				->setChoice(2),
			AdminColumn::text('name', Helper::trans('database.users-id', 2))
		]);
		$display->paginate(15);
		return $display;
	});
	$model->disableDeleting();
})
	->addMenuPage(Role::class, 200)
	->setIcon('fa fa-user-plus');
