<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	{{ Form::label('email', Helper::trans('auth.email'), ['for' => 'email', 'class' => 'col-md-4 control-label']) }}
	<div class="col-md-6">
		{{ Form::email('email', isset($_user_User)? $_user_User->email : old('email'), ['class' => 'form-control']) }}
		@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	{{ Form::label('password', Helper::trans('auth.password'), ['for' => 'password', 'class' => 'col-md-4 control-label']) }}
	<div class="col-md-6">
		{{ Form::password('password', ['class' => 'form-control']) }}
		@if ($errors->has('password'))
			<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	{{ Form::label('password_confirmation', Helper::trans('auth.password-confirm'), ['for' => 'password_confirmation', 'class' => 'col-md-4 control-label']) }}
	<div class="col-md-6">
		{{ Form::password('password_confirmation', ['class' => 'form-control']) }}
		@if ($errors->has('password_confirmation'))
			<span class="help-block">
				<strong>{{ $errors->first('password_confirmation') }}</strong>
			</span>
		@endif
	</div>
</div>
