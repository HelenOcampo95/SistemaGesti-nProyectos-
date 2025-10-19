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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Proyectos</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Información del proyecto</a>
											</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a href="#" class="btn btn-sm fw-bold btn-success" data-bs-toggle="modal" data-bs-target="#modal_registrar_proyecto">Crear Proyecto</a>
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
									<div class="row g-5 g-xl-8">
										@foreach ($proyectos as $proyecto)
										<div class="col-xl-4">
											<!--begin::Statistics Widget 1-->
											<div class="card bgi-no-repeat card-xl-stretch mb-xl-8" style="background-position: right top; background-size: 30% auto; background-color: #FFFFFF;">
												<!--begin::Body-->
												<div class="card-body">
													<a href="{{ 'detalle/'.$proyecto->id_proyecto }}" class="text-gray-800 fw-bold link-primary">{{ $proyecto->nombre_proyecto }}</a>
													<div class="text-gray-600 my-6">{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->translatedFormat('d-F-Y') }}</div>
													<p class="text-gray-600 fs-5 m-0"  style="text-align: justify;">{{ $proyecto->descripcion_proyecto }}</p>
												</div>
												<!--end::Body-->
											</div>
											<!--end::Statistics Widget 1-->
										</div>
										@endforeach
									</div>
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
					</div> 
					{{-- Modal	 --}}
					<div class="modal fade" id="modal_registrar_proyecto" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
						<div class="modal-dialog modal-dialog-centered mw-650px">
							<div class="modal-content" id="registrar_proyecto">
								<form class="form" id="formulario_registrar_proyecto">

									<!-- Encabezado modal materias primas -->
									<div class="modal-header" id="kt_modal_add_customer_header">

										<h2 class="fw-bold">Crear Proyecto</h2>

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
											<div class="mb-5 fv-row mb-7">
												<label class="fs-6 fw-semibold mb-2 required">Nombre del proyecto</label>
												<input type="text" class="form-control form-control-solid" placeholder="" name="nombre_proyecto" id="nombre_proyecto"/>
											</div>
											<div class="mb-5 fv-row">
												<label for="" class="form-label">Descripción del proyecto</label>
												<textarea class="form-control form-control-solid form-control-sm" placeholder="" name="descripcion_proyecto" id="descripcion_proyecto" rows="4"></textarea>
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
												<select  class="form-select form-select-solid" data-placeholder="Seleccione una categoria" name="id_categoria" id="id_categoria"></select>
											</div>
											<div class="mb-5 fv-row mb-7">
												<label class="fs-6 fw-semibold mb-2 required">usuario</label>
												<select name="id_usuario" class="form-select form-select-solid" data-placeholder="Seleccione un usuario" id="id_usuario"></select>
											</div>
											<div class="mb-3">
												<label class="form-label">Agregar colaboradores (por correo)</label>
												<div id="chipsContainer" class="border p-2 rounded" style="min-height: 40px; display: flex; flex-wrap: wrap; align-items: center;">
													<input type="text" id="correo_usuario" name="correo_usuario" placeholder="Escribe un correo y presiona Enter" style="border: none; outline: none; flex: 1;">
												</div>
												<small class="text-muted">Presiona Enter para agregar varios correos</small>
											</div>	

											<!-- Input hidden que enviará los correos al backend -->
											<input type="hidden" name="correo_usuario" id="correo_usuarios_hidden">
										</div>
									</div>
									<div class="modal-footer flex-center">
										<button type="button" id="btn_crear_proyecto" class="btn btn-success" @click.prevent="crearProyecto">
											<span class="indicator-label">Registrar proyecto</span>
											<span class="indicator-progress">Por favor espere...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										</button>
									</div>
									<!-- ./ Footer modal materias primas -->

								</form>
								<!--end::Form-->
							</div>
						</div>
					</div>
@endsection
@section('scripts')
    @vite('resources/js/proyecto/registrar_proyecto.js')
@endsection