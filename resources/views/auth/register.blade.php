@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">{{ Language::trans('auth.register') }}</div>
					<div class="panel-body">
						@include('user._form', [
							'_user_route' => 'register_post',
							'_user_button_text' => 'register',
							'_user_registration' => true,
							'_user_image' => false
						])
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
