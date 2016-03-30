@if($_app_html5)
	<nav class="navbar navbar-default">
@else
	<div id="nav" class="navbar navbar-default">
@endif
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">{{ trans_choice('common.toggle',1).trans_choice('common.navigation',1) }}</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">{{ trans_choice('common.brand',1) }}</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">{{ trans_choice('common.link',1) }} <span class="sr-only">({{ strtolower(trans_choice('common.current',1)) }})</span></a></li>
				<li><a href="#">{{ trans_choice('common.link',1) }}</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">{{ trans_choice('common.action',1) }} 1</a></li>
						<li><a href="#">{{ trans_choice('common.action',1) }} 2</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#"> + {{ trans_choice('common.action',2) }}</a></li>
					</ul>
				</li>
			</ul>
			<form action="/search" class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input type="text" class="form-control" name="q" placeholder="{{ trans_choice('common.search',1) }}">
				</div>
				<button type="submit" class="btn btn-default">{{ trans_choice('common.submit',1) }}</button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">{{ trans_choice('common.link',1) }}</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">{{ trans_choice('common.action',1) }}</a></li>
						<li><a href="#">{{ trans_choice('common.action',1) }} 2</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">{{ trans_choice('common.link',1) }}</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
@if($_app_html5)
	</nav>
@else
	</div>
@endif
