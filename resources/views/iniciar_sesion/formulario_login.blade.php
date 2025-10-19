
@extends('iniciar_sesion.iniciar_sesion')
@section('formularioLogin')
<div id="app_inicio">
    <form class="form w-100" novalidate="novalidate" id="form_iniciar_sesion" action="#">

        <!-- Encabezado del inicio de sesión -->

        <div class="text-center mb-11">
            <img src="{{ asset('images/identidad/logo_ecoline_xs.png') }}" class="mb-4" alt="" style="width: 250px;">
            <h1 class="text-dark fw-bolder mt-3 text-dark--login">Iniciar sesión</h1>
        </div>

        <!-- ./ Encabezado del inicio de sesión -->
        <!-- Correo electrónico -->
        <div class="form-floating mb-7">
            <input
                type="email"
                class="form-control form-control-solid"
                :class="errores.correo_electronico.estado ? 'is-invalid' : ''"
                v-model="correo_usuario"
                id="correo_usuario"
                placeholder=""
                @keyup="detectarDato('correo_usuario')"
            />
            <label for="correo_usuario">Correo electrónico</label>
            <div v-if="errores.correo_usuario.estado" class="mt-1">
                <span class="text-danger" v-text="errores.correo_usuario.mensaje"></span>
            </div>
        </div>
        <!-- ./ Correo electrónico -->
        <!-- Contraseña -->
        <div class="form-floating mb-7">
            <input
                type="password"
                class="form-control form-control-solid"
                :class="errores.contrasena_usuario.estado ? 'is-invalid' : ''"
                v-model="contrasena_usuario"
                id="contrasena_usuario"
                placeholder=""
                @keydown="detectarDato('contrasena_usuario')"
                @keypress.enter="enviarFormularioInicioSesion"
            />
            <label for="contrasena_usuario">Contraseña</label>
            <div v-if="errores.contrasena_usuario.estado" class="mt-1">
                <span class="text-danger" v-text="errores.contrasena_usuario.mensaje"></span>
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
        <div class="text-gray-500 fw-semibold fs-6">
                ¿Ya tienes cuenta?
                <a href="{{ url('registrarme') }}" class="link-primary fw-bold">Registrarme</a>
            </div>
        <!-- ./ Botón inicio de sesión -->
    </form>
</div>
@endsection
@section('scripts')
    @vite(['resources/js/inicio_sesion/inicio_sesion.js'])
@endsection
