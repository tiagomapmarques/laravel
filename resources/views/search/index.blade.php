@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2" style="display: flex;">
				<div id="search-bar" style="width: 75%;">
					@include('layouts.__search')
				</div>
				<button id="search-button-bar" style="width: 25%; margin-top: 3px; margin-bottom: 17px; margin-left: 10px;">
					<span class="fa fa-search"></span>
				</button>
			</div>
		</div>
		<div class="row">
			@foreach($_seacrh_results as $class => $all)
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
									<p>
										@foreach($class_path::$searchable as $attribute)
											{{ $item->$attribute }}
										@endforeach
									</p>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection
