<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ __('Administración - Municipalidad Distrital de José Sabogal') }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="{{ __('Administración') }}">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('css/portal.css') }}">

</head>

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="{{ route('web.home') }}"><img
                                class="logo-icon me-2" src="{{ Storage::url(app('configService')->get('site_logo')) }}"
                                alt="logo"></a>
                    </div>
                    <h2 class="auth-heading text-center mb-5">{{ __('Login') }}</h2>
                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="email mb-3">
                                <label class="sr-only" for="signin-email">{{ __('Email Address') }}</label>
                                <input id="signin-email" name="email" type="email"
                                    class="form-control signin-email @error('email') is-invalid @enderror"
                                    placeholder="{{ __('Email Address') }}" required="required"
                                    value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="password mb-3">
                                <label class="sr-only" for="signin-password">{{ __('Password') }}</label>
                                <input id="signin-password" name="password" type="password"
                                    class="form-control signin-password @error('password') is-invalid @enderror"
                                    placeholder="{{ __('Password') }}" required="required"
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="extra mt-3 row justify-content-between">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                            id="RememberPassword" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="RememberPassword">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="forgot-password text-end">
                                        <a
                                            href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit"
                                    class="btn app-btn-primary w-100 theme-btn mx-auto">{{ __('Login') }}</button>
                            </div>
                        </form>

                        <div class="auth-option text-center pt-5">{{ __('No Account? Sign up') }} <a class="text-link"
                                href="{{ route('register') }}">{{ __('here') }}</a>.</div>
                    </div>

                </div>

                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                        <small class="copyright">
                            &copy; {{ date('Y') }}
                        </small>
                    </div>
                </footer>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>
        </div>
    </div>
</body>

</html>
