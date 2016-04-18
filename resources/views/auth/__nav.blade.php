<?php
	if(!isset($_nav_style)) {
		$_nav_style = '';
	}
?>
@include('auth.__admin')
@if(Auth::user())
	<li style="{{ $_nav_style!==''?$_nav_style:'' }}"><a id="logout-button" href="{{ route('logout') }}">{{ Language::trans('auth.logout') }}</a></li>
@else
	<li><a id="register-button" href="{{ route('register') }}">{{ Language::trans('auth.register') }}</a></li>
	<li><a id="login-button" href="{{ route('login') }}">{{ Language::trans('auth.login') }}</a></li>
@endif
<?php
	unset($_nav_style);
?>
