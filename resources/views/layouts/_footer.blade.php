@if($_app_html5)
	<footer class="navbar navbar-default">
@else
	<div id="footer" class="navbar navbar-default">
@endif
		<div class="container-fluid">

				<ul class="nav navbar-nav navbar-right">
					<?php $_navigation_locales = Helper::getAllLocales(); ?>
					@if(count($_navigation_locales)>1)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Helper::trans('common.language',1) }} <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php $_navigation_original_locale = Helper::getLocale(); ?>
								@foreach($_navigation_locales as $locale)
									<?php Helper::applyLocale($locale); ?>
									<li><a href="/locale/{{ $locale }}">{{ Helper::trans('web.language-name') }}</a></li>
								@endforeach
								<?php Helper::applyLocale($_navigation_original_locale); ?>
							</ul>
						</li>
					@endif
				</ul>

		</div>
@if($_app_html5)
	</footer>
@else
	</div>
@endif
