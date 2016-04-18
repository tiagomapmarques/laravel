@if($_app_html5)
	<footer class="navbar navbar-default">
@else
	<div id="footer" class="navbar navbar-default">
@endif
		<div class="container-fluid">

				<ul class="nav navbar-nav navbar-left">
					<?php $_navigation_locales = Language::getAll(); ?>
					@if(count($_navigation_locales)>1)
						<li class="dropup">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{-- Language::trans('common.language',1) --}} <span class="fa fa-globe"></span> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php $_navigation_original_locale = Language::get(); ?>
								@foreach($_navigation_locales as $locale)
									<?php Language::apply($locale); ?>
									<li><a href="/locale/{{ $locale }}">{{ Language::trans('web.language-name') }}</a></li>
								@endforeach
								<?php Language::apply($_navigation_original_locale); ?>
							</ul>
						</li>
					@endif
					<li><a>Lurk {{ date('Y') }}</a></li>
				</ul>

		</div>
@if($_app_html5)
	</footer>
@else
	</div>
@endif
<?php
	unset($_navigation_locales);
	unset($_navigation_original_locale);
?>
