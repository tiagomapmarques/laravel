{{ Language::trans('auth.reset-text') }}: <a href="{{ $link = route('password_reset', ['token' => $token, 'email' => urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
