@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row">
					<div class="col-md-9">
						<div id="search-bar">
							@include('layouts.__search')
						</div>
					</div>
					<div class="col-md-3">
						<a id="search-button-bar" class="btn btn-primary" style="width: 100%;">
							<span class="fa fa-search"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			@foreach($_search_results as $class => $all)
				<?php
					$class_name = ucfirst($class);
					$class_path = '\\App\\'.$class_name;
				?>
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title" style="text-align: center;">{{ $class_name }} {{ Helper::trans('common.result',2) }}</h3>
						</div>
						<div class="panel-body" style="text-align: center;">
							@if(count($all)<=0)
								<p>0 {{ strtolower(Helper::trans('common.result',2)) }}</p>
							@else
								@foreach($all as $item)
									<a href="/{{ $class }}/{{ $item->hash }}"><p>
										@foreach($class_path::$searchable as $attribute)
											{{ $item->$attribute }}
										@endforeach
									</p></a>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection
