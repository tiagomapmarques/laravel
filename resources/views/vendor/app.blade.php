<?php
	// $_app_html5 variable must exist and make sure it's a boolean value
	if(!isset($_app_html5) || ($_app_html5!==true && $_app_html5!==false)) {
		// defaults to true
		$_app_html5 = true;
	}
?>
@if($_app_html5)
<!DOCTYPE html>
@else
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
@endif
<html lang="{{ App::getLocale() }}">
<head>
	@if($_app_html5)
		<meta charset="utf-8">
	@else
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	@endif
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<meta name="description" content="{{ trans('web.description') }}" />
	<meta name="keywords" content="{{ trans('web.keywords') }}">
	<meta name="author" content="Legendary Coders">

	<!-- Web-crawlers -->
	<meta name="robots" content="noodp, noarchive" />

	<!-- Google Search API - for Google Homepage searches -->
	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "WebSite",
		"url": "{{ Config::get('app.url') }}",
		"potentialAction": {
			"@type": "SearchAction",
			"target": "{{ Config::get('app.url') }}/search?q={search_term_string}",
			"query-input": "required name=search_term_string"
		}
	}
	</script>

	<title>{{ trans('web.title') }}</title>

	<!-- Fonts -->
	@include('vendor._fonts')

	<!-- Styles -->
	@include('vendor._styles')
</head>
<body id="app-layout">

	<div class="content">
		@include('vendor._navigation')
		@include('vendor._messages')

		@yield('content')
	</div>

	@include('vendor._footer')

	<!-- JavaScripts -->
	@include('vendor._scripts')
</body>
</html>
<?php
	unset($_app_html5);
?>
