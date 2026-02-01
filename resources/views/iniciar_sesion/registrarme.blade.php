@extends('iniciar_sesion.iniciar_sesion')
@section('styles')
    <style>
        /* Para que el select seleccionado tenga buen tamaño */
        .select2-container--bootstrap-5 .select2-selection--single {
            height: auto !important;
            padding: 8px 12px !important;
        }

        /* Espaciado entre opciones de la lista */
        .select2-results__option {
            padding: 8px 12px !important;
        }
    </style>
@endsection
@section('formularioAutenticacion')
    <form class="form w-100" id="form_registro">
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
        <select name="id_rol" id="id_rol" class="form-select form-select-solid" required>
            <option>Seleccione un rol</option>
            <option value="Docente Director" 
                    data-icon="bi-shield-check" 
                    data-color="text-danger"
                    data-desc="Administración total del sistema">Docente Director</option>
            <option value="Estudiante" 
                    data-icon="bi-mortarboard-fill" 
                    data-color="text-success"
                    data-desc="Acceso a cursos y materiales">Estudiante</option>
            <option value="Docente Lider" 
                    data-icon="bi-person-badge-fill" 
                    data-color="text-primary"
                    data-desc="Gestión de proyectos y categorías">Docente Líder</option>        
        </select>
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
            <button type="submit" class="btn btn-lg btn-success w-100 mb-5"   @click.prevent="enviarFormularioRegistro">
                Registrarme
            </button>

            <div class="text-gray-500 fw-semibold fs-6">
                ¿Ya tienes cuenta?
                <a href="{{ url('/') }}" class="link-primary fw-bold">Inicia sesión</a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    @vite('resources/js/inicio_sesion/registro.js')
@endsection