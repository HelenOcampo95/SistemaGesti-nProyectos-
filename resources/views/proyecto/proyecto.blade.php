@extends('welcome')

@section('contenido')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Gestión de Proyectos
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Panel Principal</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Listado de Proyectos</li>
                    </ul>
                </div>
                @can('Crear_proyecto')
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <button class="btn btn-sm fw-bold btn-success" data-bs-toggle="modal" data-bs-target="#modal_registrar_proyecto">
                        <i class="ki-duotone ki-plus fs-2"></i> Nuevo Proyecto
                    </button>
                </div>
                @endcan
                </div>
        </div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
		<div id="kt_app_content" class="app-content flex-column-fluid">
		<div id="kt_app_content_container" class="app-container container-xxl">
			
			<div class="row g-6"> 
				@foreach ($proyectos as $proyecto)
    <div class="col-md-6 col-xl-4 mb-7"> <div class="card card-flush border-hover-primary h-100 shadow-sm"> <div class="card-header pt-5 px-7 border-0">
                <div class="card-title m-0">
                    <div class="symbol symbol-45px symbol-circle">
                        <span class="symbol-label bg-light-primary text-primary fs-3 fw-bold">
                            {{ substr($proyecto->nombre_proyecto, 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="card-toolbar">
                    <span class="badge badge-light-success fw-bold fs-8 px-3 py-1">{{$proyecto->estado_proyecto}}</span>
                </div>
            </div>

            <div class="card-body px-7 py-5 d-flex flex-column">
                <a href="{{ url('detalle/'.$proyecto->id_proyecto) }}" class="text-gray-900 text-hover-success fw-bold fs-4 mb-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.4em;">
                    {{ $proyecto->nombre_proyecto }}
                </a>

                <div class="text-muted fs-7 fw-semibold mb-4">
                    <i class="ki-duotone ki-calendar-8 fs-7 me-1"></i>
                    {{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->translatedFormat('d M, Y') }}
                </div>

                <p class="text-gray-600 fs-6 mb-6 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $proyecto->descripcion_proyecto }}
                </p>

                <div class="d-flex flex-stack pt-4">
                    <a href="{{ url('detalle/'.$proyecto->id_proyecto) }}" class="btn btn-sm btn-light-success fw-bold px-4">
                        Abrir Proyecto
                        <i class="ki-duotone ki-arrow-right fs-4 ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
                <div class="mt-4">
                    {{ $proyectos->links() }}
                </div>
			</div>
			
		</div>
</div>
</div>
        </div>
</div>

<div class="modal fade" id="modal_registrar_proyecto" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" id="registrar_proyecto">
            <form class="form" id="formulario_registrar_proyecto">
                <div class="modal-header">
                    <h2 class="fw-bold">Crear Nuevo Proyecto</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_scroll" data-kt-scroll="true" data-kt-scroll-max-height="auto" data-kt-scroll-offset="300px">
                        
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2 required">Nombre del Proyecto</label>
                            <input type="text" class="form-control form-control-solid" name="nombre_proyecto" id="nombre_proyecto" placeholder="Ej: Rediseño Web" />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2">Descripción</label>
                            <textarea class="form-control form-control-solid" name="descripcion_proyecto" id="descripcion_proyecto" rows="3"></textarea>
                        </div>
                        <div class="row mt-5 mb-4">  
                            <div class="col-12 col-md-6">
                                <label class="fs-6 fw-semibold mb-2 required" >Fecha inicio</label>
                                <input type="text" class="form-control form-control-solid" id="fecha_inicio" placeholder="" name="fecha_inicio" value="" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="fs-6 fw-semibold mb-2 required" >Fecha entrega</label>
                                <input type="text" class="form-control form-control-solid" id="fecha_entrega" placeholder="" name="fecha_entrega" value="" />
                            </div>
                        </div>
                        <div class="mb-5 fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2 required">Estado</label>
                            <input type="text" class="form-control form-control-solid" placeholder="" name="estado_proyecto" id="estado_proyecto"/>
                        </div>
                        <div class="mb-5 fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2 required">Categoria</label>
                            <select  class="form-select form-select-solid" data-placeholder="Seleccione una categoria" name="id_categoria" id="id_categoria"></select>
                        </div>
                        <div class="mb-3">
                        <label class="fs-6 fw-semibold mb-2 required">Estudiantes participantes</label>
                        <div class="border p-2 rounded d-flex flex-wrap align-items-center" style="min-height: 45px; background-color: #f5f8fa;">
                            <div v-for="(correo, index) in colaboradores" :key="index" class="badge badge-secondary m-1 p-2 d-flex align-items-center">
                            @{{ correo }}
                            <span @click="eliminarColaborador(index)" class="ms-2 cursor-pointer text-danger">&times;</span>
                            </div>
                            <input type="email" v-model="nuevo_correo"  @keydown.enter.prevent="agregarColaborador" 
                            class="border-0 bg-transparent flex-grow-1" 
                            placeholder="Escribe un correo y pulsa Enter"
                            style="outline: none;">
                        </div>
                            <small class="text-muted">Los usuarios que no existan serán invitados automáticamente.</small>
                        </div>
                        <input type="hidden" name="correo_usuario" id="correo_usuarios_hidden">
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Descartar</button>
                    <button type="button" id="btn_crear_proyecto" class="btn btn-primary" @click.prevent="crearProyecto">
                        <span class="indicator-label">Registrar Proyecto</span>
                        <span class="indicator-progress">Espere... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @vite('resources/js/proyecto/registrar_proyecto.js')
@endsection