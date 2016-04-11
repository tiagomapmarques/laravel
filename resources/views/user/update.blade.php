@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="text-align: center;">{{ Helper::trans('user.update') }}</h3>
					</div>
					<div class="panel-body">
						@include('user._form')
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
