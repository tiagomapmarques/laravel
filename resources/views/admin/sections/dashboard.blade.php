{!! Language::trans('web.admin-welcome') !!}

<{!! Language::getTag() !!}>
{{ Language::trans('web.admin-languages') }}:
@foreach(Language::getAll() as $locale)
	{{ Language::trans('web.language-name', 1, $locale).', ' }}
@endforeach
</{!! Language::getTag() !!}>
