<!DOCTYPE html>
<html lang="es">

<head>
    <title>WebApp Ecoline</title>
    <meta charset="utf-8" />
    <meta name="description" content="Iniciar sesión en Ecoline Agrícola" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="es_ES" />
    <meta property="og:title" content="Ecoline Agrícola | Sumamos por Colombia" />
    <meta property="og:url" content="@yield('url', 'https://ecolineagricola.com/app')" />
    <meta property="og:site_name" content="Ecoline Agrícola | Iniciar Sesión" />
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
                    <form class="form w-100" novalidate="novalidate" id="form_iniciar_sesion" action="#">
                        
                        <div class="text-center mb-11">
                            <img src="{{ asset('assets/images/logo/Areandina.png') }}" class="mb-4" alt="" style="width: 350px;">
                            <h1 class="text-dark fw-bolder mt-3 text-dark--login">Iniciar sesión</h1>
                        </div>

                        <div class="form-floating mb-7">
                            <input
                                type="email"
                                class="form-control form-control-solid"
                                id="correo_electronico"
                                placeholder=""
                                @keyup="detectarDato('correo_electronico')"
                            />
                            <label for="correo_electronico">Correo electrónico</label>
                            <div v-if="errores.correo_electronico.estado" class="mt-1">
                                <span class="text-danger" v-text="errores.correo_electronico.mensaje"></span>
                            </div>
                        </div>
                        <!-- ./ Correo electrónico -->
                        <!-- Contraseña -->
                        <div class="form-floating mb-7">
                            <input
                                type="password"
                                class="form-control form-control-solid"
                                id="password"
                                placeholder=""
                                @keydown="detectarDato('password')"
                                @keypress.enter="enviarFormularioInicioSesion"
                            />
                            <label for="password">Contraseña</label>
                            <div v-if="errores.password.estado" class="mt-1">
                                <span class="text-danger" v-text="errores.password.mensaje"></span>
                            </div>
                        </div>
                        <!-- ./ Contraseña -->
                        <!-- Botón inicio de sesión -->
                        <div class="d-grid mb-10">
                            <button
                                type="button"
                                id="btn_enviar_formulario_inicio_sesion"
                                @click="enviarFormularioInicioSesion"
                                :data-kt-indicator="cargando ? 'on' : ''"
                                class="btn btn-primary"
                                :class="cargando ? 'disabled' : ''"
                                >

                                <span class="indicator-label">Iniciar sesión</span>

                                <!-- Botón de progreso inicio de sesión -->
                                <span class="indicator-progress">
                                    Verificando información...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                <!-- ./ Botón de progreso inicio de sesión -->
                            </button>
                        </div>
                    </form>
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


<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
@yield('scripts')

</body>
</html>