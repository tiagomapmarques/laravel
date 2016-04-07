@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			@foreach($_seacrh_results as $class => $all)
				<?php
					$class_name = ucfirst($class);
					$class_path = '\\App\\'.$class_name;
				?>
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title" style="text-align: center;">{{ $class_name }}</h3>
						</div>
						<div class="panel-body" style="text-align: center;">
							@if(count($all)<=0)
								<p>0 results</p>
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
