@include('assets.svgs')
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Administración - Municipalidad Distrital de José Sabogal</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('css/portal.css') }}">

    <link id="theme-style" rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">

    @livewireStyles

    @stack('css')

    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

</head>

<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 30 30" role="img">
                                    <title>Menu</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                        stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="app-utilities col-auto">
                            <div class="app-utility-item app-user-dropdown dropdown">
                                <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-expanded="false">
                                    <img src="{{ Storage::url(Auth::user()->photo) }}"
                                        alt="{{ Auth::user()->name ?? '' }}"></a>

                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li><a class="dropdown-item" href="#">{{ __('Account') }}</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.settings.index') }}">{{ __('Settings') }}</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">{{ __('Logout') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="app-sidepanel" class="app-sidepanel sidepanel-hidden">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">

                <a href="{{ route('admin.index') }}" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>

                <div class="app-branding">
                    <a class="app-logo" href="{{ route('admin.index') }}"><img class="logo-icon me-2"
                            src="{{ Storage::url(app('configService')->get('site_logo')) }}"
                            alt="{{ app('configService')->get('site_title') }}">
                        <span class="logo-text">{{ app('configService')->get('site_title') }}</span>
                    </a>
                </div>

                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}"
                                href="{{ route('admin.index') }}">
                                <span class="nav-icon">
                                    <i class="fa-solid fa-house"></i>
                                </span>
                                <span class="nav-link-text">{{ __('General') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/posts*') ? 'active' : '' }}"
                                href="{{ route('admin.posts.index') }}">
                                <span class="nav-icon">
                                    <i class="fa-solid fa-newspaper"></i>
                                </span>
                                <span class="nav-link-text">{{ __('News') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/videos*') ? 'active' : '' }}"
                                href="{{ route('admin.videos.index') }}">
                                <span class="nav-icon">
                                    <i class="fa-solid fa-play"></i>
                                </span>
                                <span class="nav-link-text">{{ __('Videos') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/documents*') ? 'active' : '' }}"
                                href="{{ route('admin.documents.index') }}">
                                <span class="nav-icon">
                                    <i class="fa-solid fa-file"></i>
                                </span>
                                <span class="nav-link-text">{{ __('Documents') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <span class="nav-icon">
                                    <i class="fa-solid fa-newspaper"></i>
                                </span>
                                <span class="nav-link-text">{{ __('Users') }}</span>
                            </a>
                        </li>

                    </ul>
                </nav>

                <div class="app-sidepanel-footer">
                    <nav class="app-nav app-nav-footer">
                        <ul class="app-menu footer-menu list-unstyled">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.settings.index') }}">
                                    <span class="nav-icon">
                                        @yield('svg-config')
                                    </span>
                                    <span class="nav-link-text">{{ __('Settings') }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </header>

    <div class="app-wrapper">

        {{ $slot }}

        <footer class="app-footer">
            <div class="container text-center py-3">
                <small class="copyright"></small>
            </div>
        </footer>

    </div>

    <!-- Javascript -->
    <script src="{{ asset('js/jquery-3.7.1.min.js.') }}"></script>
    <script src="{{ asset('plugins/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Page Specific JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>

    @livewireScripts

    @stack('js')

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        $(document).ready(function() {
            $('#documentsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
            });
        });
    </script>

</body>

</html>
