<p>This is the Lurk administration section.</p>
<p>Feel free to explore and edit it as you like!</p>
<p>This application is (so far) provided in the following languages:
@foreach(Helper::getAllLocales() as $locale)
	{{ Helper::trans('web.language-name', 1, $locale).', ' }}
@endforeach
</p>
