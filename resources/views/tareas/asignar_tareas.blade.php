@extends('welcome')

@section('contenido')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<!--begin::Content wrapper-->
	<div class="d-flex flex-column flex-column-fluid">
		<!--begin::Toolbar-->
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<!--begin::Toolbar container-->
			<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
				<!--begin::Page title-->
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<!--begin::Title-->
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Tareas</h1>
					<!--end::Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
					<!--begin::Item-->
						<li class="breadcrumb-item text-muted">
							<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Información tareas asignadas</a>
						</li>
						<!--end::Item-->
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="#" class="btn btn-sm fw-bold btn-success" data-bs-toggle="modal" data-bs-target="#modal_asignar_tarea">Asignar Tareas</a>
					<!--end::Primary button-->
				</div>
			<!--end::Actions-->
			</div>
			<!--end::Toolbar container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Content-->
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<!--begin::Content container-->
			<div id="kt_app_content_container" class="app-container container-xxl">
				<!--begin::Navbar-->
				<div class="card mb-5 mb-xl-10">
					<div class="card-header border-0 pt-6">
						<div class="card-title">
						<!-- Input buscador de materias primas -->
						<div class="d-flex align-items-center position-relative my-1">
							<span class="svg-icon svg-icon-1 position-absolute ms-6">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
									<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
								</svg>
							</span>
							<input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-300px ps-15" id="buscador_tareas" placeholder="Buscar pedido"/>
						</div>
						<!-- ./ Input buscador de materias primas -->
						</div>
                	</div>
					<div class="card-body pt-9 pb-0">
						<table class="table display responsive table-row-bordered gy-5 table-striped" id="listadoDeTareas" >
							<thead>
								<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
									<th>Proyecto</th>
									<th>Título</th>
									<th>Fecha entrega</th>
									<th>Estado</th>
									<th>Porcenaje Avance</th>
									<th>Actualizado</th>
									<th>Eliminado</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="fw-semibold text-gray-600"></tbody>
						</table>
					</div>
				</div>
			</div>
			<!--end::Content container-->
		</div>
		<!--end::Content-->
	</div>
</div> 
					
@section('modales')
{{-- Modal	 --}}
<div class="modal fade" id="modal_asignar_tarea" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content" id="asignar_tarea">
			<form class="form" id="formulario_asignar_tarea">
				<!-- Encabezado modal materias primas -->
					<div class="modal-header" id="kt_modal_add_customer_header">
						<h2 class="fw-bold">Crear Tarea</h2>
						<div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
							<span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
							</span>
						</div>
					</div>
					<div class="modal-body py-10 px-lg-17">
						<div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
							<div class="mb-5 fv-row">
                                <label class="fs-6 fw-semibold mb-2 required">Nombre del proyecto</label>
								<select  class="form-select form-select-solid" data-placeholder="Seleccione un proyecto" name="id_proyecto" id="id_proyecto" required></select>
                            </div>
							<div class="mb-5 fv-row">
								<label class="form-label required">Título de la tarea</label>
								<input class="form-control form-control-solid form-control-sm" 
									placeholder="" 
									name="titulo_tarea" 
									id="titulo_tarea" 
									rows="4"
									v-model="formTarea.tituloTarea"
									:class="{'border-danger': excedidos.titulo }"
									:maxlength="limites.tituloTarea">
								</input>
								<div class="d-flex justify-content-between mt-2">
									<small v-if="excedidos.titulo" class="text-danger">
										Límite máximo alcanzado
									</small>
								</div>
							</div>
							<div class="mb-5 fv-row">
								<label class="form-label required">Descripción de la tarea</label>
								<textarea 
									class="form-control form-control-solid form-control-sm"
									name="descripcion_tarea"
									id="descripcion_tarea"
									rows="4"
									v-model="formTarea.descripcionTarea"
									:class="{ 'border-danger': excedidos.descripcion }"
									:maxlength="limites.descripcionTarea"
								></textarea>

								<div class="d-flex justify-content-between mt-2">
									<small 
										:class="excedidos.descripcion ? 'text-danger' : 'text-muted'"
										v-text="formTarea.descripcionTarea.length + ' / ' + limites.descripcionTarea + ' caracteres'">
									</small>
									<small v-if="excedidos.descripcion" class="text-danger">
										Límite máximo alcanzado
									</small>
								</div>
							</div>
							<div class="mb-5 fv-row">
								
							</div>

							<div class="row g-9 mb-8">
								<div class="col-md-6 fv-row">
									<label class="fs-6 fw-semibold mb-2 required" >Fecha entrega</label>
                            		<input type="text" class="form-control form-control-solid" id="fecha_entrega" placeholder="" name="fecha_entrega"/>
								</div>
								<div class="col-md-6 fv-row">
									<label class="fs-6 mb-2">Avance (%)</label>
									<div class="input-group input-group-solid">
										<input type="number" name="porcentaje_avance" id="porcentaje_avance" class="form-control form-control-solid" min="0" max="100" value="{{ $tarea->porcentaje_avance ?? 0 }}" />
										<span class="input-group-text">%</span>
									</div>
								</div>
							</div>
                            <div class="mb-5 fv-row">
								<label for="" class="form-label">Observaciones del docente</label>
								<textarea class="form-control form-control-solid form-control-sm" 
									placeholder="" 
									name="observaciones_docente" 
									id="observaciones_docente" 
									rows="4"
									v-model="formTarea.observacionTarea" 
									:class="{ 'border-danger': excedidos.observacion}"
									:maxlength="limites.observacionTarea">
								</textarea>
								<div class="d-flex justify-content-between mt-2">
									<small 
										:class="excedidos.observacion ? 'text-danger' : 'text-muted'"
										v-text="formTarea.observacionTarea.length + ' / ' + limites.observacionTarea + ' caracteres'">
									</small>

									<small v-if="excedidos.observacion" class="text-danger">
										Límite máximo alcanzado
									</small>
								</div>
							</div> 
							
						</div>
					</div>
					<div class="modal-footer flex-center">
						<button type="button" id="btn_asignar_tarea" class="btn btn-success" @click.prevent="asignarTarea">
							<span class="indicator-label">Registrar tarea</span>
							<span class="indicator-progress">Por favor espere...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
					</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="modal_editar_tareas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" id="id_tarea_editar">
            <form class="form" id="formulario_editar_tarea">
                <input type="hidden" id="id_tarea_editar" name="id_tarea">

                <div class="modal-header" id="header_editar_tarea">
                    <h2 class="fw-bold">Editar tarea</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        ✖
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
					<div class="mb-5 fv-row">
                        <label class="form-label">Título de la tarea</label>
                        <input class="form-control form-control-solid form-control-sm"
                            name="titulo_tarea_editar"
                            id="titulo_tarea_editar" 
							rows="4"
							v-model="formTarea.editarTituloTarea"
							:class="{ 'border-danger': excedidos.editarTitulo}"
							:maxlength="limites.editarTituloTarea">
						</input>
						<div class="d-flex justify-content-between mt-2">
							
							<small v-if="excedidos.editarTitulo" class="text-danger">
								Límite máximo alcanzado
							</small>
						</div>
                    </div>
                    <div class="mb-5 fv-row">
                        <label class="form-label">Descripción de la tarea</label>
                        <textarea class="form-control form-control-solid form-control-sm"
                            name="descripcion_tarea_editar"
                            id="descripcion_tarea_editar" 
							rows="4"
							v-model="formTarea.editarDescripcionTarea"
							:class="{ 'border-danger': excedidos.editarDescripcion}"
							:maxlength="limites.editarDescripcionTarea">
						</textarea>
						<div class="d-flex justify-content-between mt-2">
							<small 
								:class="excedidos.editarDescripcion ? 'text-danger' : 'text-muted'"
								v-text="formTarea.editarDescripcionTarea.length + ' / ' + limites.editarDescripcionTarea + ' caracteres'">
							</small>
							<small v-if="excedidos.editarDescripcion" class="text-danger">
								Límite máximo alcanzado
							</small>
						</div>
                    </div>
					<div class="mb-5 fv-row">
						<label for="" class="form-label">Observaciones del docente</label>
						<textarea class="form-control form-control-solid form-control-sm" 
							placeholder="" name="observaciones_tarea_editar" 
							id="observaciones_tarea_editar" 
							rows="4"
							v-model="formTarea.editarObservacionTarea"
							:class="{ 'border-danger': excedidos.editarObservacion}"
							:maxlength="limites.editarObservacionTarea">
						</textarea>
						<div class="d-flex justify-content-between mt-2">
							<small 
								:class="excedidos.editarObservacionTarea ? 'text-danger' : 'text-muted'"
								v-text="formTarea.editarObservacionTarea.length + ' / ' + limites.editarObservacionTarea + ' caracteres'">
							</small>
							<small v-if="excedidos.editarObservacionTarea" class="text-danger">
								Límite máximo alcanzado
							</small>
						</div>
					</div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" id="btn_editar_tareas" class="btn btn-success" @click.prevent="editarTarea">
                        <span class="indicator-label">Editar Tarea</span>
                        <span class="indicator-progress">Por favor espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_ver_detalle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-0 py-4">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-white shadow-sm">
                            <i class="fa fa-tasks text-success"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="det_titulo">---</h5>
                        <span class="text-muted fs-7" id="det_proyecto">---</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-8">
                <div class="mb-6">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-gray-800">Progreso de la tarea</span>
                        <span class="fw-bold text-success" id="det_avance_texto">0%</span>
                    </div>
                    <div class="progress h-6px w-100 bg-light-success">
                        <div id="det_avance_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>

                <div class="rounded border border-dashed border-gray-300 p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-calendar-alt text-muted me-3"></i>
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 fs-8 fw-bolder text-uppercase">Fecha de Entrega</span>
                            <span class="text-gray-800 fw-bold" id="det_entrega">---</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-info-circle text-muted me-3"></i>
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 fs-8 fw-bolder text-uppercase">Estado Actual</span>
                            <div id="det_estado">---</div>
                        </div>
                    </div>

                    <div class="d-flex flex-column">
                        <span class="text-gray-400 fs-8 fw-bolder text-uppercase mb-1">Descripción</span>
                        <p id="det_descripcion" class="text-gray-600 fs-7 italic">---</p>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-light rounded-3 border-start border-warning border-4">
                    <h6 class="text-warning fw-bold fs-7 mb-1">Observaciones del Docente</h6>
                    <p id="det_observaciones" class="text-gray-700 fs-7 mb-0">---</p>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-light-dark fw-bold" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
@endsection
@endsection
<script>
        // Definimos esto antes para que el archivo JS lo encuentre disponible
        window.permisosUsuario = {
            canEditar: {{ auth()->user()->can('Editar_tareas') ? 'true' : 'false' }},
            canEliminar: {{ auth()->user()->can('Eliminar_tareas') ? 'true' : 'false' }}
        };
    </script>
@section('scripts')
    @vite('resources/js/tareas/asignar_tareas.js')
@endsection