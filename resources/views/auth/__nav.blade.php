<?php
	if(!isset($_nav_style)) {
		$_nav_style = '';
	}
?>
@include('auth.__admin')
@if(Auth::user())
	<li style="{{ $_nav_style!==''?$_nav_style:'' }}"><a id="logout-button" href="{{ route('logout') }}">{{ Helper::trans('auth.logout') }}</a></li>
@else
	<li><a id="register-button" href="{{ route('register') }}">{{ Helper::trans('auth.register') }}</a></li>
	<li><a id="login-button" href="{{ route('login') }}">{{ Helper::trans('auth.login') }}</a></li>
@endif
<?php
	unset($_nav_style);
?>
