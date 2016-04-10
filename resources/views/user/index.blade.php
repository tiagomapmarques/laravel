@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="text-align: center;">
							<span>User details</span>
							<a href="{{ route('user.update') }}"><span class="fa fa-pencil"></span></a>
						</h3>

					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<p style="text-align: center;">
									<img width="50%" src="/{{ $_user_User->image() }}" alt="{{ $_user_User->name }} image" />
								</p>
							</div>
							<div class="col-md-6">
								<label>Name:</label>
								<p>{{ $_user_User->name }}</p>
								<label>Email:</label>
								<p>{{ $_user_User->email }}</p>
								<label>Role:</label>
								<p>{{ $_user_User->role->name }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
