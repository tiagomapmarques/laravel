<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

use App\Models\Role;
use App\Models\User;

AdminSection::registerModel(User::class, function(ModelConfiguration $model) {
	$model->setTitle(Language::trans('database.users',2));

	// Display
	$model->onDisplay(function() {
		$display = AdminDisplay::tabbed();

		$display->setTabs(function() {
			$tabs = [];
			$columns = [
				AdminColumn::text('name', Language::trans('database.users-name')),
				AdminColumn::text('email', Language::trans('database.users-email')),
				AdminColumn::hash('hash', Language::trans('database.users-id')),
				AdminColumn::image('image', Language::trans('database.users-image')),
				AdminColumn::download(
					'getImage',
					Language::trans('common.download').' '.Language::trans('database.users-image'),
					Language::trans('common.download', 2)),
				AdminColumn::reference('role_id', Language::trans('database.roles').' '.Language::trans('database.roles-id')),
				AdminColumn::translatable('role_id', 'name', Language::trans('database.roles')),
				AdminColumn::boolean('isAdmin', Language::trans('database.role-name-admin').'?')
			];

			$allTable = AdminDisplay::table()->paginate(15);
			$allTable->setColumns($columns);
			$tabs[] = AdminDisplay::tab($allTable)->setLabel('All')->setActive();

			$Roles = Role::all();
			foreach($Roles as $Role) {
				$roleTable = AdminDisplay::table()->paginate(15);
				$roleTable->getScopes()->push($Role->name);
				$roleTable->setColumns($columns);
				$tabs[] = AdminDisplay::tab($roleTable)
					->setLabel(Language::trans('database.role-name-'.$Role->name, 2));
			}
			return $tabs;
		});
		return $display;
	});

	// Create And Edit
	$model->onCreateAndEdit(function() {
		return $form = AdminForm::panel()->addBody(
			AdminFormElement::text('name', Language::trans('database.users-name'))
				->required(),
			AdminFormElement::text('email', Language::trans('database.users-email'))
				->required(),
			AdminFormElement::image('image', Language::trans('database.users-image')),
			AdminFormElement::select('role_id', Language::trans('database.roles'))
				->setModelForOptions(new Role)
				->setDisplay('name')
		);
		return $form;
	});
})
	->addMenuPage(User::class, 100)
	->setIcon('fa fa-users');
