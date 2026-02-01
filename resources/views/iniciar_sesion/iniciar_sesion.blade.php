<!DOCTYPE html>
<html lang="es">

<head>
    <title>Areandina</title>
    <meta charset="utf-8" />
    <meta name="description" content="Iniciar sesión en Areandina" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="es_ES" />
    <meta property="og:title" content="Areandina | Sumamos por Colombia" />
    <meta property="og:url" content="@yield('url', '')" />
    <meta property="og:site_name" content="Areandina| Iniciar Sesión" />
    <link rel="shortcut icon" href="{{ asset('images/identidad/favicon.ico') }}" />

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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">

    @yield('styles')

</head>
<body id="kt_body" class="app-blank app-blank">

<div class="d-flex flex-column flex-root" id="kt_app_root">

    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <!-- Sección de formularios -->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">

            <div class="d-flex flex-center flex-column flex-lg-row-fluid">

                <div class="w-300px w-lg-450px">
                    <div id="app_registro">
                        @yield('formularioAutenticacion')
                    </div>
                    <div id="app_inicio">
                        @yield('formularioLogin')
                    </div>
                </div>

            </div>

        </div>
        <!-- ./ Sección de formularios -->

        <!-- Hero iniciar sesión -->
        <div class="d-flex flex-lg-row-fluid w-lg-50 order-1 order-lg-2 position-relative" style="height: 100vh;">
        <!-- Imagen de fondo -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                    background-image: url('{{ asset('assets/images/identidad/estudiantes.jpg') }}');
                    background-size: cover;
                    background-position: center;
                    z-index: 1;">
        </div>

        <!-- Capa verde con opacidad sobre la imagen -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                    background-color: rgba(118, 143, 81, 0.5); z-index: 2; position: relative; z-index: 3; width: 100%;">
        </div>

</div>
</div>
@yield('scripts')


</body>
</html>

