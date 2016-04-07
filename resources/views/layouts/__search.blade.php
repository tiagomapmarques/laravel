
<?php
	if(!isset($_search_class)) {
		$_search_class = '';
	}
	if(!isset($_search_style)) {
		$_search_style = '';
	}
?>
{!! Form::open(['method' => 'GET', 'url' => route('search'), 'class' => $_search_class, 'style' => $_search_style]) !!}
	<div class="form-group">
		{{ Form::text('q', '', ['class' => 'form-control', 'placeholder' => Helper::trans('common.search').' + Enter']) }}
	</div>
	{{-- Form::submit(Helper::trans('common.search'), array('class' => 'btn btn-primary')) --}}
{!! Form::close() !!}
<?php
	unset($_search_class);
	unset($_search_style);
?>
