@extends('iniciar_sesion.iniciar_sesion')

@section('formularioLogin')
<form class="form w-100" id="form_iniciar_sesion" novalidate>
    <!-- Encabezado -->
    <div class="text-center mb-11">
        
        <h1 class="text-dark fw-bolder mt-3 text-dark--login">Iniciar sesión</h1>
    </div>

    <!-- Correo electrónico -->
    <div class="form-floating mb-7">
        <input
            type="email"
            id="correo_usuario"
            class="form-control form-control-solid"
            :class="errores.correo_usuario.estado ? 'is-invalid' : ''"
            v-model.trim="correo_usuario"
            placeholder="Correo electrónico"
            @input="errores.correo_usuario.estado = false"
            autocomplete="off"
        />
        <label for="correo_usuario">Correo electrónico</label>

        <div v-if="errores.correo_usuario.estado" class="mt-1">
            <span class="text-danger" v-text="errores.correo_usuario.mensaje"></span>
        </div>
    </div>

    <!-- Contraseña -->
    <div class="form-floating mb-7">
        <input
            type="password"
            id="contrasena_usuario"
            class="form-control form-control-solid"
            :class="errores.contrasena_usuario.estado ? 'is-invalid' : ''"
            v-model.trim="contrasena_usuario"
            placeholder="Contraseña"
            @input="errores.contrasena_usuario.estado = false"
            autocomplete="off"
        />
        <label for="contrasena_usuario">Contraseña</label>

        <div v-if="errores.contrasena_usuario.estado" class="mt-1">
            <span class="text-danger" v-text="errores.contrasena_usuario.mensaje"></span>
        </div>
    </div>

    <!-- Botón de inicio de sesión -->
    <div class="d-grid mb-10">
        <button
            type="submit"
            id="btn_enviar_formulario_inicio_sesion"
            class="btn btn-primary"
            @click.prevent="enviarFormularioInicioSesion"
            :disabled="cargando"
        >
            <span v-if="!cargando">Iniciar sesión</span>
            <span v-else>
                Verificando información...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>

    <!-- Enlace a registro -->
    <div class="text-gray-500 fw-semibold fs-6 text-center">
        ¿No tienes cuenta?
        <a href="{{ url('registrarme') }}" class="link-primary fw-bold">Registrarme</a>
    </div>
</form>
@endsection
@section('scripts')
    @vite('resources/js/inicio_sesion/inicio_sesion.js')
@endsection
