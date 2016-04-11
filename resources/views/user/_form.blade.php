<?php
	if(!isset($_user_route)) {
		$_user_route = 'user.update';
	}
	if(!isset($_user_button_text)) {
		$_user_button_text = 'save';
	}
	if(!isset($_user_image)) {
		$_user_image = true;
	}
	if(!isset($_user_registration)) {
		$_user_registration = false;
	}
?>
{!! Form::open(['url' => route($_user_route), 'class' => 'form-horizontal', 'files' => $_user_image]) !!}

	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		{{ Form::label('name', Helper::trans('auth.name'), ['for' => 'name', 'class' => 'col-md-4 control-label']) }}
		<div class="col-md-6">
			{{ Form::text('name', isset($_user_User)? $_user_User->name : old('name'), ['class' => 'form-control']) }}
			@if ($errors->has('name'))
				<span class="help-block">
					<strong>{{ $errors->first('name') }}</strong>
				</span>
			@endif
		</div>
	</div>

	@if($_user_registration)
		@include('user.__registration')
	@endif

	@if($_user_image)
		<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
			{{ Form::label('image', Helper::trans('auth.image').' (Max:'.Helper::getUploadLimit('mb').'MB)', ['for' => 'image', 'class' => 'col-md-4 control-label']) }}
			<div class="col-md-6">
				{{ Form::file('image') }}
				@if ($errors->has('image'))
					<span class="help-block">
						<strong>{{ $errors->first('image') }}</strong>
					</span>
				@endif
			</div>
		</div>
	@endif

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			{{ Form::submit(Helper::trans('auth.'.$_user_button_text), ['class' => 'submit btn btn-primary']) }}
			<a href="{{ route('home') }}" class="submit btn btn-danger">{{ Helper::trans('auth.cancel') }}</a>
			<a href="{{ route('user.password') }}" class="btn btn-link">{{ Helper::trans('auth.password-change') }}</a>
		</div>
	</div>

{!! Form::close() !!}
<?php
	unset($_user_route);
	unset($_user_button_text);
	unset($_user_image);
	unset($_user_registration);
?>
