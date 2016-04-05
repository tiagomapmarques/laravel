@if($_app_html5)
	<nav class="navbar navbar-default">
@else
	<div id="nav" class="navbar navbar-default">
@endif
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav-1" aria-expanded="false">
					<span class="sr-only">{{ Helper::trans('common.toggle').' '.Helper::trans('common.navigation',1) }}</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ route('root') }}">Lurk</a>
			</div>

			<div class="collapse navbar-collapse" id="collapsable-nav-1">

				<ul class="nav navbar-nav">
					<?php if(!isset($_navigation_selected)) $_navigation_selected = null; ?>
					<li class="{{ $_navigation_selected==='home'?'active':'' }}"><a href="{{ route('root') }}">{{ Helper::trans('common.home') }}</a></li>
					<li class=""><a href="#">{{ Helper::trans('common.link',1) }}</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li>
						{!! Form::open(['method' => 'GET', 'url' => route('search'), 'class' => 'navbar-form navbar-right']) !!}
							<div class="form-group">
								{{ Form::text('q', '', ['class' => 'form-control', 'placeholder' => Helper::trans('common.search',1).' + Enter']) }}
							</div>
							{{-- Form::submit(Helper::trans('common.search',1), array('class' => 'btn btn-primary')) --}}
						{!! Form::close() !!}
					<li>

					@if(Auth::user())
						<li><a id="logout-button" href="{{ route('logout') }}">{{ Helper::trans('auth.logout') }}</a></li>
					@else
						<li><a id="register-button" href="{{ route('register') }}">{{ Helper::trans('auth.register') }}</a></li>
						<li><a id="login-button" href="{{ route('login') }}">{{ Helper::trans('auth.login') }}</a></li>
					@endif
				</ul>

			</div>
		</div>
@if($_app_html5)
	</nav>
@else
	</div>
@endif
<?php
	unset($_navigation_original_locale);
?>
