@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="text-align: center;">
							<span>{{ Helper::trans('user.details') }}</span>
							<a id="user-update-button" href="{{ route('user.update') }}"><span class="fa fa-pencil" style="float: right;"></span></a>
						</h3>

					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<p style="text-align: center;">
									<img width="50%" src="/{{ $_user_User->getImage() }}" alt="{{ $_user_User->name }} image" />
								</p>
							</div>
							<div class="col-md-6">
								<label>{{ Helper::trans('auth.name') }}:</label>
								<p>{{ $_user_User->name }}</p>
								<label>{{ Helper::trans('auth.email') }}:</label>
								<p>{{ $_user_User->email }}</p>
								<label>{{ Helper::trans('database.role') }}:</label>
								<p>{{ $_user_User->role->name }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
