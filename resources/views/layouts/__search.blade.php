<?php
	if(!isset($_search_class)) {
		$_search_class = '';
	}
	if(!isset($_search_style)) {
		$_search_style = '';
	}
	if(!isset($_search_text)) {
		$_search_text = '';
	}
?>
{!! Form::open(['method' => 'GET', 'url' => route('search'), 'class' => $_search_class, 'style' => $_search_style]) !!}
	<div class="form-group">
		{{ Form::text('q', $_search_text, ['class' => 'form-control', 'placeholder' => Language::trans('common.search')]) }}
	</div>
	{{-- Form::submit(Language::trans('common.search'), array('class' => 'btn btn-primary')) --}}
{!! Form::close() !!}
<?php
	unset($_search_class);
	unset($_search_style);
	unset($_search_text);
?>
