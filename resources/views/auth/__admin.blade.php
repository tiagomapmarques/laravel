<?php
	if(!isset($_nav_style)) {
		$_nav_style = '';
	}
?>
@if(Auth::user() && Auth::user()->isAdmin())
	@if(Helper::routeIsAdmin())
		<li style="{{ $_nav_style!==''?$_nav_style:'' }}"><a href="{{ url('/user') }}">{{ Helper::trans('auth.root') }}</a></li>
	@else
		<li style="{{ $_nav_style!==''?$_nav_style:'' }}"><a href="{{ url('/admin') }}">{{ Helper::trans('auth.admin') }}</a></li>
	@endif
@endif
<?php
	unset($_nav_style);
?>
