@extends('iniciar_sesion.iniciar_sesion')

@section('formularioAutenticacion')
<div id="app_registro">
    <form class="form w-100" method="POST" id="form_registro">
        @csrf

        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">Crear cuenta</h1>
        </div>

        <!-- Nombre -->
        <div class="fv-row mb-7">
            <label class="form-label fs-6 fw-bold text-dark">Nombres</label>
            <input type="text" name="nombre_usuario" class="form-control form-control-lg form-control-solid" required />
        </div>
        <div class="fv-row mb-7">
            <label class="form-label fs-6 fw-bold text-dark">Apellidos</label>
            <input type="text" name="apellido_usuario" class="form-control form-control-lg form-control-solid" required />
        </div>
        <div class="fv-row mb-7">
            <label class="form-label fs-6 fw-bold text-dark">Cédula</label>
            <input type="text" name="cedula" class="form-control form-control-lg form-control-solid" required />
        </div>
        <div class="fv-row mb-7">
            <label class="form-label fs-6 fw-bold text-dark">Rol</label>
            <input type="text" name="id_rol" class="form-control form-control-lg form-control-solid" required />
        </div>
        <!-- Correo -->
        <div class="fv-row mb-7">
            <label class="form-label fs-6 fw-bold text-dark">Correo electrónico</label>
            <input type="email" name="correo_usuario" class="form-control form-control-lg form-control-solid" required />
        </div>
        <!-- Contraseña -->
        <div class="fv-row mb-7">
            <label class="form-label fs-6 fw-bold text-dark">Contraseña</label>
            <input type="password" name="contrasena_usuario" class="form-control form-control-lg form-control-solid" required />
        </div>
        <!-- Botón -->
        <div class="text-center">
            <button type="submit" class="btn btn-lg btn-success w-100 mb-5" @click="enviarFormularioRegistro">
                Registrarme
            </button>

            <div class="text-gray-500 fw-semibold fs-6">
                ¿Ya tienes cuenta?
                <a href="{{ url('/') }}" class="link-primary fw-bold">Inicia sesión</a>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
    @vite('resources/js/inicio_sesion/registro.js')
@endsection