<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

                <!-- Logo en Mobile  -->
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                    <a href="/" class="d-lg-none">
                        <img src="{{ asset('assets/images/logo/Areandina.png') }}" alt="Isologo Areandina" class="w-30px">
                    </a>
                </div>
                <!-- ./ Lobo en Mobile -->
                <!--begin::Header wrapper-->
                <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1" id="kt_app_header_wrapper">
                    <!--begin::Navbar-->
                    <div class="app-navbar flex-shrink-0">
                        <!--begin::Search-->
                        <div class="app-navbar-item align-items-stretch ms-1 ms-lg-3 d-none">
                            <!--begin::Search-->
                            <!--end::Search-->
                        </div>
                        <div class="app-navbar-item ms-1 ms-lg-3">
                        </div>
                        <!--end::Theme mode-->
                        <!--begin::User menu-->
                        <div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                            <!--begin::Menu wrapper-->
                            <div class="cursor-pointer symbol symbol-35px symbol-md-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <img src="" alt="Perfil" class="me-2"/>
                            </div>
                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">

                                    <!--begin::Menu separator-->
                                    <div class="separator my-2 d-none"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="/posibles-socios" class="menu-link px-5">
                                            <span class="menu-text"><i class="fa-regular fa-user me-3"></i> Posibles socios</span>

                                        </a>
                                    </div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5 my-1 d-none">
                                        <a href="/" class="menu-link px-5"><i class="fa-solid fa-gear me-3"></i> Configuración</a>
                                    </div>
                                    @if( session()->has('personificador') )
                                        <div class="menu-item px-5">
                                            <a href="/administracion/personificar/salir" class="menu-link px-5"><i class="fa-solid fa-right-from-bracket me-3"></i> Volver a la administración</a>
                                        </div>
                                    @else
                                        <div class="menu-item px-5">
                                            <form action="/cerrar-sesion" method="POST">
                                                @csrf
                                                <a href="#" class="menu-link px-5" onclick="this.closest('form').submit()"><i class="fa-solid fa-right-from-bracket me-3"></i> Cerrar sesión</a>
                                            </form>
                                        </div>
                                    @endif
                            </div>
                        
                        </div>
                        <!--end::User menu-->
                    </div>
                    <!--end::Navbar-->
                </div>
                <!--end::Header wrapper-->

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
                    <a href="">
                        <img alt="Logo Areandina" src="{{ asset('assets/images/logo/Areandina.png') }}" class="h-70px app-sidebar-logo-default" />
                        <img alt="Logo Areandina" src="{{ asset('assets/images/logo/Areandina.png') }}" class="h-20px app-sidebar-logo-minimize" />
                    </a>
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
                <!--end::Logo-->
                <!--begin::sidebar menu-->
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
                                            <i class="bi bi-people-fill fs-3"></i>
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
                                            <i class="bi bi-people-fill fs-3"></i>
                                        </span>
                                        <span class="menu-title">Tareas</span>
                                    </a>
                            </div>
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="bi bi-people-fill fs-3"></i>
                                        </span>
                                        <span class="menu-title">Usuarios</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <div class="menu-item">
                                                <a class="menu-link" href="">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Usuarios</span>
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="bi bi-people-fill fs-3"></i>
                                        </span>
                                        <span class="menu-title">Reportes</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <div class="menu-item">
                                                <a class="menu-link" href="">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Usuarios</span>
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Sidebar-->

            <div id="app_general">

                <!-- Contenido principal de la página -->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid space-inicial">
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
								</div>
								<!--end::Toolbar container-->
							</div>
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
                                <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Areandina.</a>
                            </div>
                            <!--end::Copyright-->
                        </div>
                        <!--end::Footer container-->
                    </div>
                    <!--end::Footer-->
                </div>
            </div>

        </div>
        <!--end::Wrapper-->
        
    </div>
</div>

@yield('scripts')

</body>
</html>