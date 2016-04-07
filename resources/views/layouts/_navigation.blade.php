@if($_app_html5)
	<nav id="nav" class="navbar navbar-default">
@else
	<div id="nav" class="navbar navbar-default">
@endif
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav-1" aria-expanded="false">
					<span class="sr-only">{{ Helper::trans('common.toggle').' '.Helper::trans('common.navigation') }}</span>
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
					<li class=""><a href="#">{{ Helper::trans('common.link') }}</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li id="search-button-nav" class="hidden-xs">
						<a><span class="fa fa-search"></span></a>
					<li>

					@if(Auth::user())
						<li><a id="logout-button" href="{{ route('logout') }}">{{ Helper::trans('auth.logout') }}</a></li>
					@else
						<li><a id="register-button" href="{{ route('register') }}">{{ Helper::trans('auth.register') }}</a></li>
						<li><a id="login-button" href="{{ route('login') }}">{{ Helper::trans('auth.login') }}</a></li>
					@endif

					<li class="hidden-sm hidden-md hidden-lg">
						<a href="{{ route('search') }}">{{ Helper::trans('common.search') }}</a>
					<li>
				</ul>

			</div>
		</div>
@if($_app_html5)
	</nav>
@else
	</div>
@endif

@if($_app_html5)
	<nav id="search-bar" class="navbar navbar-default hidden-xs">
@else
	<div id="search-bar" class="navbar navbar-default hidden-xs">
@endif
		<div class="container">
			<ul class="nav navbar-nav navbar-right">
				<li id="search-button-bar">
					<a><span class="fa fa-search"></span></a>
				<li>
				<li id="search-cancel-bar">
					<a><span class="fa fa-times"></span></a>
				<li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li id="search-input-bar">
					@include('layouts.__search', ['_search_class' => 'navbar-form'])
				<li>
			</ul>
		</div>
@if($_app_html5)
	</nav>
@else
	</div>
@endif
<?php
	unset($_navigation_original_locale);
?>
