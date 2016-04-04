{{ Helper::trans('auth.reset-text') }}: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
