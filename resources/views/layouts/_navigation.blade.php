<?php
	if(!isset($_navigation_selected)) {
		$_navigation_selected = null;
	}
	if(!isset($_navigation_search)) {
		$_navigation_search = true;
	}
?>
@if($_app_html5)
	<nav id="nav" class="navbar navbar-default">
@else
	<div id="nav" class="navbar navbar-default">
@endif
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav-1" aria-expanded="false">
					<span class="sr-only">{{ Language::trans('common.toggle').' '.Language::trans('common.navigation') }}</span>
					<span id="navbar-toggle-icon-top" class="icon-bar"></span>
					<span id="navbar-toggle-icon-mid" class="icon-bar"></span>
					<span id="navbar-toggle-icon-bot" class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ route('root') }}">Lurk</a>
			</div>

			<div class="collapse navbar-collapse" id="collapsable-nav-1">

				<ul class="nav navbar-nav">
					<li class="{{ $_navigation_selected==='home'?'active':'' }}"><a href="{{ route('home') }}">{{ Language::trans('common.home') }}</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if($_navigation_search)
						<li class="hidden-xs">
							<a id="nav-search"><span class="fa fa-search"></span></a>
						<li>
					@endif

					@include('auth.__nav')

					@if($_navigation_search)
						<li class="hidden-sm hidden-md hidden-lg">
							<a href="{{ route('search') }}">{{ Language::trans('common.search') }}</a>
						<li>
					@endif
				</ul>

			</div>
		</div>
@if($_app_html5)
	</nav>
@else
	</div>
@endif

@if($_navigation_search)
	@if($_app_html5)
		<nav id="search-bar" class="navbar navbar-default hidden-xs">
	@else
		<div id="search-bar" class="navbar navbar-default hidden-xs">
	@endif
			<div class="container">
				<ul class="nav navbar-nav navbar-right">
					<li id="search-bar-submit">
						<a><span class="fa fa-search"></span></a>
					<li>
					<li id="search-bar-cancel">
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
@endif
<?php
	//unset($_navigation_selected);
	unset($_navigation_search);
?>
