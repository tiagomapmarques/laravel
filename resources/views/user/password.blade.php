@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="text-align: center;">{{ Helper::trans('auth.password-change') }}</h3>
					</div>
					<div class="panel-body">
						{!! Form::open(['url' => url('/user/password'), 'class' => 'form-horizontal']) !!}
							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								{{ Form::label('old_password', Helper::trans('auth.password-old'), ['for' => 'old_password', 'class' => 'col-md-4 control-label']) }}
								<div class="col-md-6">
									{{ Form::password('old_password', ['class' => 'form-control']) }}
									@if ($errors->has('old_password'))
										<span class="help-block">
											<strong>{{ $errors->first('old_password') }}</strong>
										</span>
									@endif
								</div>
							</div>

							@include('user.__registration',[
								'_user_email' => false
							])

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{{ Form::submit(Helper::trans('auth.password-change'), ['class' => 'submit btn btn-primary']) }}
									<a href="{{ route('home') }}" class="btn btn-danger">{{ Helper::trans('auth.cancel') }}</a>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
