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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Detalle del Proyecto</h1>
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
										<div class="card-body pt-9 pb-0">
											<!--begin::Details-->
											<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
												<!--begin::Info-->
												<div class="flex-grow-1">
													<!--begin::Title-->
													<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
														<!--begin::User-->
														<div class="d-flex flex-column mb-10">
															<!--begin::Name-->
															<div class="d-flex align-items-center mb-2">
																<a href="#" class="text-gray-900 text-hover-primary fs-4 fw-bold me-1">{{$proyecto->nombre_proyecto}} </a>
															</div>
															<!--end::Name-->
														</div>
														<div class="card-toolbar">
														<!--begin::Menu-->
														<button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
															<!--begin::Svg Icon | path: icons/duotune/general/gen023.svg-->
															<span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
																	<rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
																	<rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
																	<rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</button>
														<!--begin::Menu 2-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
															<!--begin::Menu separator-->
															<div class="separator mb-3 opacity-75"></div>
															<!--end::Menu separator-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3"data-bs-toggle="modal" data-bs-target="#modal_editar_proyecto">Editar Proyecto</a>
															</div>										
														</div>
														<!--end::Menu 2-->
														<!--end::Menu-->
													</div>
													</div>
													<!--end::Title-->
													<!--begin::Stats-->
													<div class="d-flex flex-wrap flex-stack">
														<!--begin::Wrapper-->
														<div class="d-flex flex-column flex-grow-1 pe-8">
															<!--begin::Stats-->
															<div class="d-flex flex-wrap">
																<!--begin::Stat-->
																<div class="min-w-125px py-3 px-4 me-6 mb-3">
																	<!--begin::Number-->
																	<div class="d-flex align-items-center">
																		<div class="fw-bold fs-6 text-black-600">Fecha de inicio</div>
																	</div>
																	<!--end::Number-->
																	<!--begin::Label-->
																	
                                                                    <span class="badge badge-light-success fs-7 fw-bold">{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->translatedFormat('d-F-Y') }}</span>
																	<!--end::Label-->
																</div>
																<!--end::Stat-->
																<!--begin::Stat-->
																<div class="min-w-125px py-3 px-4 me-6 mb-3">
																	<!--begin::Number-->
																	<div class="d-flex align-items-center">
																		<div class="fw-bold fs-6 text-black-600">Fecha de entrega</div>
																	</div>
																	<!--end::Number-->
																	<!--begin::Label-->
																	<span class="badge badge-light-danger fs-7 fw-bold">{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->translatedFormat('d-F-Y') }}</span>
																	<!--end::Label-->
																</div>
															</div>
															<!--end::Stats-->
														</div>
														<!--end::Wrapper-->
														<!--begin::Progress-->
														<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
															<div class="d-flex justify-content-between w-100 mt-auto mb-2">
																<span class="fw-semibold fs-6 text-gray-400">Progreso</span>
																<span class="fw-bold fs-6">50%</span>
															</div>
															<div class="h-5px mx-3 w-100 bg-light mb-3">
																<div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
														</div>
														<!--end::Progress-->
													</div>
													<!--end::Stats-->
												</div>
												<!--end::Info-->
											</div>
										</div>
                                        <div class="card-body pb-0">
													<span class="fs-5 fw-semibold text-gray-600 pb-5 d-block">{{$proyecto->descripcion_proyecto}}</span>
												</div>
									</div>
								</div>
								<!--end::Content container-->
							</div>
						</div>
					</div> 
					{{-- Modal	 --}}
				<input type="hidden" id="id_proyecto" value="{{$proyecto->id_proyecto}}">
<div class="modal fade" id="modal_editar_proyecto" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content" id="editar_proyecto">
			<form class="form" id="formulario_editar_proyecto">
				<!-- Encabezado modal materias primas -->
							<div class="modal-header" id="kt_modal_add_customer_header">
								<h2 class="fw-bold">Editar Proyecto</h2>
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
											<input type="text" class="form-control form-control-solid" placeholder="" name="nombre_proyecto" id="nombre_proyecto" value="{{ $proyecto->nombre_proyecto}}"/>
										</div>
										<div class="mb-5 fv-row">
											<label for="" class="form-label">Descripción del proyecto</label>
											<textarea class="form-control form-control-solid form-control-sm" placeholder="" name="descripcion_proyecto" id="descripcion_proyecto" value="{{ $proyecto->descripcion_proyecto}}" rows="4"></textarea>
										</div>
										<div class="mb-5 fv-row">
											<label class="fs-6 fw-semibold mb-2 required" >Fecha inicio</label>
                                            <input type="text" class="form-control form-control-solid" id="fecha_inicio" placeholder="" name="fecha_inicio" value="{{ $proyecto->fecha_inicio}}" />
										</div>
										<div class="mb-5 fv-row">
											<label class="fs-6 fw-semibold mb-2 required" >Fecha entrega</label>
                                            <input type="text" class="form-control form-control-solid" id="fecha_entrega" placeholder="" name="fecha_entrega" value="{{ $proyecto->fecha_entrega}}" />
										</div>
										<div class="mb-5 fv-row mb-7">
											<label class="fs-6 fw-semibold mb-2 required">Estado</label>
											<input type="text" class="form-control form-control-solid" placeholder="" name="estado_proyecto" id="estado_proyecto" value="{{ $proyecto->estado_proyecto}}"/>
										</div>
										<div class="mb-5 fv-row mb-7">
											<label class="fs-6 fw-semibold mb-2 required">Categoría</label>
											<input type="text" class="form-control form-control-solid" 
											value="{{ $proyecto->categoria->nombre_categoria }}" readonly>

												<!-- Enviar el id al backend -->
											<input type="hidden" name="id_categoria" value="{{ $proyecto->id_categoria }}">
										</div>

										<div class="mb-5 fv-row mb-7">
											<label class="fs-6 fw-semibold mb-2 required">usuario</label>
											<input type="text" class="form-control form-control-solid" 
											value="{{ $proyecto->usuario->nombre_usuario }}" readonly>
											<!-- Enviar el id al backend -->
											<input type="hidden" name="id_usuario" value="{{ $proyecto->id_usuario }}">
										</div>

										</div>
							</div>
									<div class="modal-footer flex-center">
										<button type="button" id="btn_editar_proyecto" class="btn btn-success" @click.prevent="actualizarProyecto(proyecto)">
											<span class="indicator-label">Editar proyecto</span>
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
    @vite('resources/js/proyecto/editar_proyecto.js')
@endsection