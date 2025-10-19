<!DOCTYPE html>
<html lang="es">
<head>
    <title>Areandina</title>
    <meta charset="utf-8" />
    <meta name="description" content="Iniciar sesión en Ecoline Agrícola" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="es_ES" />

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/iconos/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/iconos/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/iconos/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/iconos/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/iconos/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/iconos/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/iconos/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/iconos/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/iconos/apple-icon-180x180.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/iconos/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/iconos/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('images/iconos/apple-icon-57x57.png') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/iconos/favicon.ico') }}">

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/iconos/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/iconos/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/iconos/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/iconos/favicon-16x16.png') }}">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/iconos/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">


    @yield('styles')

    <style>
        div.space-inicial {
            min-height: calc(91vh - 50px);
        }
        .menu-item .menu-link .menu-icon {
            margin-right: 0.8rem;
        }
        .btn.btn-active-color-primary:hover, .btn.btn-active-color-primary:hover:not(.btn-active), .btn.btn-active-color-primary:hover:not(.btn-active) .svg-icon{
            color: #284734 !important;
        }


        .btn-confirmar-eliminacion {
            background-color: #d80606;
            color: #fff;
        }

        .btn-confirmar-eliminacion:hover {
            transition: 0.3s;
            background-color: #b30808 !important;
        }

    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<body id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

        <div id="kt_app_header" class="app-header">

            <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">

                <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                        <!-- Botón menú Tablets y Mobile | path: images/demo/media/icons/duotune/abstract/abs015.svg -->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                                <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!-- ./Botón menú Tablets y Mobile -->
                    </div>
                </div>
            </div>
            <!--end::Header container-->
        </div>
        <!--end::Header-->

        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Sidebar-->
            <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                <!--begin::Logo-->
				<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                    <!--begin::Logo image-->
                    {{-- <a href="">
                        <img alt="Logo Areandina" src="{{ asset('assets/images/logo/Areandina.png') }}" class="h-70px app-sidebar-logo-default" />
                        <img alt="Logo Areandina" src="{{ asset('assets/images/logo/Areandina.png') }}" class="h-20px app-sidebar-logo-minimize" />
                    </a> --}}
                    <!--end::Logo image-->

                    <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
                        <span class="svg-icon svg-icon-2 rotate-180">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"></path>
                                <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <div class="app-sidebar-menu overflow-hidden flex-column-fluid" id="app_menu">
                    <!--begin::Menu wrapper-->
                    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                            <div class="menu-item">
                                <a class="menu-link @if( request()->path() === 'dashboard' ) active @endif" href="/">
                                                    <span class="menu-icon">
                                                        <i class="bi bi-graph-up-arrow fs-3"></i>
                                                    </span>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                    <a class="menu-link" href="{{ route('proyecto') }}">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-lightbulb"></i>
                                        </span>
                                        <span class="menu-title">Proyecto</span>
                                    </a>
                            </div>
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <div class="menu-item">
                                    <a class="menu-link" href="{{ route('categorias') }}">
                                        <span class="menu-icon">
                                            <i class="bi bi-people-fill fs-3"></i>
                                        </span>
                                        <span class="menu-title">Categorias</span>
                                    </a>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('tareas') }}">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-list-check"></i>
                                        </span>
                                        <span class="menu-title">Tareas</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('tareas') }}">
                                        <span class="menu-icon">
                                            <i class="bi bi-people-fill fs-3"></i>
                                        </span>
                                        <span class="menu-title">Registrarme</span>
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Sidebar-->

            <div id="app_general">

                <!-- Contenido principal de la página -->
                <div class="app-main flex-column flex-row-fluid pt-15" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid space-inicial">

                        @yield('contenido')

                    </div>
                    <!--end::Content wrapper-->

                    <!--begin::Footer-->
                    <div id="kt_app_footer" class="app-footer">
                        <!--begin::Footer container-->
                        <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
                                <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Areandina</a>
                            </div>
                            <!--end::Copyright-->
                        </div>
                        <!--end::Footer container-->
                    </div>
                    <!--end::Footer-->

                </div>
                <!-- ./Contenido principal de la página -->

                <!-- Modales -->
                @yield('modales')
                <!-- ./ Modales -->

            </div>

        </div>
        <!--end::Wrapper-->
    </div>
</div>


<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

<script src="{{ asset('assets/js/externos/amcharts/index.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/xy.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/percent.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/radar.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/animated.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/map.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/worldLow.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/continentsLow.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/usaLow.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/worldTimeZonesLow.js') }}"></script>
<script src="{{ asset('assets/js/externos/amcharts/worldTimeZoneAreasLow.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

@yield('scripts')

</body>
</html>
