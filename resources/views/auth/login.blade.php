@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">{{ Language::trans('auth.login') }}</div>
					<div class="panel-body">
						{!! Form::open(['url' => route('login_post'), 'class' => 'form-horizontal']) !!}

							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								{{ Form::label('email', Language::trans('auth.email'), ['for' => 'email', 'class' => 'col-md-4 control-label']) }}
								<div class="col-md-6">
									{{ Form::email('email', old('email'), ['class' => 'form-control']) }}
									@if ($errors->has('email'))
										<span class="help-block">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								{{ Form::label('password', Language::trans('auth.password'), ['for' => 'password', 'class' => 'col-md-4 control-label']) }}
								<div class="col-md-6">
									{{ Form::password('password', ['class' => 'form-control']) }}
									@if ($errors->has('password'))
										<span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<div class="checkbox">
										<label>
											{{ Form::checkbox('remember') }}
											{{ Language::trans('auth.remember') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{{ Form::submit(Language::trans('auth.login'), ['class' => 'submit btn btn-primary']) }}
									<a id="forgot-password-button" class="btn btn-link" href="{{ route('password_reset') }}">Forgot Your Password?</a>
								</div>
							</div>

						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
