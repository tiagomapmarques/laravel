@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">{{ Language::trans('auth.reset') }}</div>
					<div class="panel-body">
						@if(session('status'))
							<div class="alert alert-success">
								{{ session('status') }}
							</div>
						@endif

						{!! Form::open(['url' => route('password_email_post'), 'class' => 'form-horizontal']) !!}

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

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{{ Form::submit(Language::trans('auth.reset-send'), ['class' => 'submit btn btn-primary']) }}
								</div>
							</div>

						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
