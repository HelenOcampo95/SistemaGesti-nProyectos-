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
													<th>Descripción</th>
													<th>Fecha entrega</th>
													<th>Estado</th>
													<th>Observaciones docente</th>
													<th>Porcenaje Avance</th>
													<th></th>
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
								<select  class="form-select form-select-solid" data-placeholder="Seleccione un proyecto" name="id_proyecto" id="id_proyecto"></select>
                            </div>
							<div class="mb-5 fv-row">
								<label for="" class="form-label">Título de la tarea</label>
								<input class="form-control form-control-solid form-control-sm" placeholder="" name="titulo_tarea" id="titulo_tarea" rows="4"></input>
							</div>
							<div class="mb-5 fv-row">
								<label for="" class="form-label">Descripción de la tarea</label>
								<textarea class="form-control form-control-solid form-control-sm" placeholder="" name="descripcion_tarea" id="descripcion_tarea" rows="4"></textarea>
							</div>
							<div class="mb-5 fv-row">
								<label class="fs-6 fw-semibold mb-2 required" >Fecha entrega</label>
                                <input type="text" class="form-control form-control-solid" id="fecha_entrega" placeholder="" name="fecha_entrega" value="" />
							</div>
							<div class="mb-5 fv-row">
                                <label class="fs-6 fw-semibold mb-2 required">Estado</label>
                                <input name="estado_tarea" class="form-select form-select-solid form-control-sm" data-placeholder="Seleccione una materia prima" id="estado_tarea"></input>
                            </div>
                            <div class="mb-5 fv-row">
								<label for="" class="form-label">Observaciones del docente</label>
								<textarea class="form-control form-control-solid form-control-sm" placeholder="" name="observaciones_docente" id="observaciones_docente" rows="4"></textarea>
							</div>
                            <div class="mb-5 fv-row">
                                <label class="fs-6 fw-semibold mb-2 required">Porcentaje de avance</label>
                                <input name="porcentaje_avance" class="form-select form-select-solid form-control-sm" data-placeholder="Seleccione una materia prima" id="porcentaje_avance"></input>
                            </div>
						</div>
					</div>
					<div class="modal-footer flex-center">
						<button type="button" id="btn_asignar_tarea" class="btn btn-success" @click.prevent="asignarTarea">
							<span class="indicator-label">Registrar proyecto</span>
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
                                id="titulo_tarea_editar" rows="4"></input>
                    </div>
                    <div class="mb-5 fv-row">
                        <label class="form-label">Descripción de la tarea</label>
                        <textarea class="form-control form-control-solid form-control-sm"
                                name="descripcion_tarea_editar"
                                id="descripcion_tarea_editar" rows="4"></textarea>
                    </div>
					<div class="mb-5 fv-row">
						<label for="" class="form-label">Observaciones del docente</label>
						<textarea class="form-control form-control-solid form-control-sm" placeholder="" name="observaciones_tarea_editar" id="observaciones_tarea_editar" rows="4"></textarea>
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

@endsection
@endsection
@section('scripts')
    @vite('resources/js/tareas/asignar_tareas.js')
@endsection