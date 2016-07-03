<?php
	if(!isset($_nav_style)) {
		$_nav_style = '';
	}
?>
@if(Auth::user() && Auth::user()->isAdmin())
	<li style="{{ $_nav_style!==''?$_nav_style:'' }}">
		@if(Helper::routeIsAdmin())
			<a href="{{ url('/') }}">{{ Language::trans('auth.root') }}</a>
		@else
			<a href="{{ url('/admin') }}">{{ Language::trans('auth.admin') }}</a>
		@endif
	</li>
@endif
<?php
	unset($_nav_style);
?>
