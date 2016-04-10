@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="text-align: center;">Laravel Up and Running Kit (v<?php echo Helper::version(); ?>)</h3>
					</div>
					<div class="panel-body" style="text-align: center;">
						Based on Laravel 5.2(+community), Bootstrap 3, Sass and jQuery 2.
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
