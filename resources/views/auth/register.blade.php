<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ __('Registro - Municipalidad Distrital de José Sabogal') }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="{{ __('Registro de usuario') }}">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('css/portal.css') }}">

</head>

<body class="app app-signup p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="{{ route('web.home') }}"><img
                                class="logo-icon me-2" src="{{ asset('images/logo.png') }}" alt="logo"></a>
                    </div>
                    <h2 class="auth-heading text-center mb-5">{{ __('Registro') }}</h2>
                    <div class="auth-form-container text-start">
                        <form class="auth-form register-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="name mb-3">
                                <label class="sr-only" for="register-name">{{ __('Nombre') }}</label>
                                <input id="register-name" name="name" type="text"
                                    class="form-control register-name @error('name') is-invalid @enderror"
                                    placeholder="{{ __('Nombre') }}" required="required" value="{{ old('name') }}"
                                    autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="email mb-3">
                                <label class="sr-only" for="register-email">{{ __('Correo Electrónico') }}</label>
                                <input id="register-email" name="email" type="email"
                                    class="form-control register-email @error('email') is-invalid @enderror"
                                    placeholder="{{ __('Correo Electrónico') }}" required="required"
                                    value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="password mb-3">
                                <label class="sr-only" for="register-password">{{ __('Contraseña') }}</label>
                                <input id="register-password" name="password" type="password"
                                    class="form-control register-password @error('password') is-invalid @enderror"
                                    placeholder="{{ __('Contraseña') }}" required="required"
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="password-confirm mb-3">
                                <label class="sr-only"
                                    for="register-password-confirm">{{ __('Confirmar Contraseña') }}</label>
                                <input id="register-password-confirm" name="password_confirmation" type="password"
                                    class="form-control register-password-confirm"
                                    placeholder="{{ __('Confirmar Contraseña') }}" required="required"
                                    autocomplete="new-password">
                            </div>

                            <div class="text-center">
                                <button type="submit"
                                    class="btn app-btn-primary w-100 theme-btn mx-auto">{{ __('Registrarse') }}</button>
                            </div>
                        </form>

                        <div class="auth-option text-center pt-5">{{ __('¿Ya tienes una cuenta? Inicia sesión') }} <a
                                class="text-link" href="{{ route('login') }}">{{ __('aquí') }}</a>.</div>
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
