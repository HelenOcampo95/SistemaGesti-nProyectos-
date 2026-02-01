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
					<div class="page-title d-flex align-items-center">
						<a href="{{ route('proyecto')}}" class="text-gray-500 text-hover-primary me-2">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
							</svg>
						</a>
						<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Detalle del Proyecto</h1>
					</div>	
						<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
							<li class="breadcrumb-item text-muted">
								<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Información del proyecto</a>
							</li>
						</ul>
				</div>
			</div>
								<!--end::Toolbar container-->
		</div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-xxl">
				<div class="row gy-5 g-xl-10">
					<div class="col-xl-8 mb-5 mb-xl-10">
						<div class="row h-xl-100">			
							<div class="col">
								<div class="card card-flush h-xl-70">
									<div class="card-header pt-5">
										<div class="d-flex flex-column mt-8">
											<span class="text-gray-900 fs-4 fw-bold me-1">{{$proyecto->nombre_proyecto}} 
												<span class="badge badge-light-success fw-bold fs-8 px-3 py-1">{{$proyecto->estado_proyecto}}</span>
											</span>
											<span class="text-muted fw-bold fs-7">{{$proyecto->categoria->nombre_categoria}}</span>
										</div>
										@can('Ver actividades')
											<div class="card-toolbar">
												<button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
													<span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
														<rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
														<rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
														<rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
														</svg>
													</span>
												</button>
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
													<div class="separator mb-3 opacity-75"></div>
														<div class="menu-item px-3">
															<a href="#" class="menu-link px-3"data-bs-toggle="modal" data-bs-target="#modal_editar_proyecto">Editar Proyecto</a>
														</div>										
												</div>
											</div>
										@endcan
									</div>
									{{-- Tamaño del card  --}}
									<div class="card-body d-flex flex-column justify-content-between p-7 px-0 min-h-250px m-3">
										<div class="tab-content ps-4 pe-6">
											<div class="d-flex flex-wrap flex-stack">
												<div class="d-flex flex-column flex-grow-1 pe-8">				
													<div class="d-flex flex-wrap">
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<div class="me-5 fs-7 text-gray-400 fw-bold">Fecha Inicio</div>
															<div class="d-flex align-items-center">
																<div class="fs-6 fw-bold text-gray-800">{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d M, Y') }}</div>
															</div>
														</div>
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<div class="fs-7 text-gray-400 fw-bold">Fecha Entrega</div>
															<div class="d-flex align-items-center">
																<div class="fs-6 fw-bold text-danger">{{ \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('d M, Y') }}</div>
															</div>
														</div>
													</div>
												</div>
												<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3 p-3">
													<div class="d-flex justify-content-between w-100 mt-auto mb-2">
														<span class="fw-semibold fs-6 text-gray-400">Progreso</span>
														<span class="fw-bold fs-6">50%</span>
													</div>
													<div class="h-5px mx-3 w-100 bg-light mb-3">
														<div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
											</div>
											<div class="notice d-flex  rounded border-secondary border border-dashed p-6 mb-5 mt-">
												<div class="d-flex flex-stack flex-grow-1">
													<div class="fw-semibold">
														<h4 class="text-gray-700 fw-bold">Descripción del Proyecto</h4>
														<div class="fs-6 text-gray-700 mt-2">{{$proyecto->descripcion_proyecto}}</div>
													</div>
												</div>
											</div>
											<div class="mt-7">
												<h6 class="fw-bolder text-gray-800 mb-4">Participantes del Proyecto</h6>
												<div class="d-flex flex-wrap">
													<div class="d-flex align-items-center border border-gray-300 border-dashed rounded min-w-150px py-3 px-4 me-4 mb-3">
														<div class="symbol symbol-35px symbol-circle me-4">
															<div class="symbol-label fs-2 bg-light-danger text-danger fw-bold">
																{{ $proyecto->director ? substr($proyecto->director->nombre_usuario, 0, 1) : '?' }}
															</div>
														</div>
														<div class="d-flex flex-column">
															<span class="text-gray-800 fw-bolder fs-7">
																@if($proyecto->director)
																	{{ $proyecto->director->nombre_usuario }} {{ $proyecto->director->apellido_usuario }}
																@else
																	Sin asignar
																@endif
															</span>
															<span class="text-muted fw-bold fs-7">Docente Director</span>
														</div>
													</div>
													<div class="d-flex align-items-center border border-gray-300 border-dashed rounded min-w-150px py-3 px-4 me-4 mb-3">
														<div class="symbol symbol-35px symbol-circle me-4">
															<div class="symbol-label fs-2 bg-light-danger text-danger fw-bold">
																{{ $proyecto->lider ? substr($proyecto->lider->nombre_usuario, 0, 1) : '?' }}
															</div>
														</div>
														<div class="d-flex flex-column">
															<span class="text-gray-800 fw-bolder fs-7">
																@if($proyecto->lider)
																	{{ $proyecto->lider->nombre_usuario }} {{ $proyecto->lider->apellido_usuario }}
																@else
																	Sin asignar
																@endif
															</span>
															<span class="text-muted fw-bold fs-7">Docente Líder</span>
														</div>
													</div>
													<div class="d-flex flex-wrap">
														@foreach($proyecto->participantes as $participante)
															<div class="d-flex align-items-center border border-gray-300 border-dashed rounded min-w-150px py-3 px-4 me-4 mb-3">
																
																<div class="symbol symbol-35px symbol-circle me-4">
																	<div class="symbol-label fs-2 bg-light-primary text-primary fw-bold">
																		{{ substr($participante->nombre_usuario, 0, 1) }}
																	</div>
																</div>

																<div class="d-flex flex-column">
																	<span class="text-gray-800 fw-bolder fs-7">
																		{{ $participante->nombre_usuario }} {{ $participante->apellido_usuario }}
																	</span>
																	<span class="text-muted fw-bold fs-7">Estudiante</span>
																</div>
															</div>
														@endforeach

														@if($proyecto->participantes->isEmpty())
															<div class="border border-gray-300 border-dashed rounded py-3 px-4 mb-3">
																<span class="text-muted fs-7">No hay compañeros asignados.</span>
															</div>
														@endif
													</div>
													<div class="d-flex align-items-center border border-gray-300 border-dashed rounded min-w-150px py-3 px-4 me-4 mb-3">
														<div class="symbol symbol-35px symbol-circle me-4">
															<div class="symbol-label fs-2 bg-light-danger text-danger fw-bold">
																{{ $proyecto->usuario ? substr($proyecto->usuario->nombre_usuario, 0, 1) : '?' }}
															</div>
														</div>
														<div class="d-flex flex-column">
															<span class="text-gray-800 fw-bolder fs-7">
																@if($proyecto->usuario)
																	{{ $proyecto->usuario->nombre_usuario }} {{ $proyecto->usuario->apellido_usuario }}
																@else
																	Sin asignar
																@endif
															</span>
															<span class="text-muted fw-bold fs-7">Estudiante</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					@can('Ver actividades')
						<div class="col-xl-4 mb-xl-10 align-self-start">
							<div class="card card-flush">
								<div class="card-header pt-7">
									<!--begin::Title-->
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bold text-gray-800">Actividades</span>
											<span class="text-gray-400 mt-1 fw-semibold fs-6">59 Active Shipments</span>
										</h3>
										<div class="card-toolbar">
											<a href="#" class="btn btn-sm btn-light" data-bs-toggle='tooltip' data-bs-dismiss='click' data-bs-custom-class="tooltip-inverse" title="Logistics App is coming soon">View All</a>
										</div>
								</div>
									<div class="card-body">
										<ul class="nav nav-pills nav-pills-custom row position-relative mx-0 mb-9">
											<li class="nav-item col-4 mx-0 p-0">
												<a class="nav-link active d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#kt_list_widget_10_tab_1">
													<span class="nav-text text-gray-800 fw-bold fs-6 mb-3">Pendientes</span>
													<span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>		
												</a>
											</li>
															<li class="nav-item col-4 mx-0 px-0">
																<!--begin::Link-->
																<a class="nav-link d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#kt_list_widget_10_tab_2">
																	<!--begin::Subtitle-->
																	<span class="nav-text text-gray-800 fw-bold fs-6 mb-3">En proceso</span>
																	<!--end::Subtitle-->
																	<!--begin::Bullet-->
																	<span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
																	<!--end::Bullet-->
																</a>
																<!--end::Link-->
															</li>
															<!--end::Item-->
															<!--begin::Item-->
															<li class="nav-item col-4 mx-0 px-0">
																<!--begin::Link-->
																<a class="nav-link d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#kt_list_widget_10_tab_3">
																	<!--begin::Subtitle-->
																	<span class="nav-text text-gray-800 fw-bold fs-6 mb-3">Finalizadas</span>
																	<!--end::Subtitle-->
																	<!--begin::Bullet-->
																	<span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
																	<!--end::Bullet-->
																</a>
																<!--end::Link-->
															</li>
															<!--end::Item-->
															<!--begin::Bullet-->
															<span class="position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded"></span>
															<!--end::Bullet-->
										</ul>
														<!--end::Nav-->
														<!--begin::Tab Content-->
														<div class="tab-content">
															<!--begin::Tap pane-->
															<div class="tab-pane fade show active" id="kt_list_widget_10_tab_1">
																@if($pendientes->count() > 0)
																	<div class="timeline">
																		@foreach($pendientes as $tarea)
																			@php
																				$fecha = \Carbon\Carbon::parse($tarea->fecha_entrega);
																				$atrasada = $fecha->isPast() && !$fecha->isToday();
																				$color = $atrasada ? 'danger' : 'primary';
																			@endphp
																			<div class="timeline-item align-items-center mb-7">
																				<div class="timeline-line w-40px mt-6 mb-n12"></div>
																				<div class="timeline-icon" style="margin-left: 11px">
																					<span class="svg-icon svg-icon-2 svg-icon-success">
																					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																						<path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM6.39999 9.89999C6.99999 8.19999 8.40001 6.9 10.1 6.4C10.6 6.2 10.9 5.7 10.7 5.1C10.5 4.6 9.99999 4.3 9.39999 4.5C7.09999 5.3 5.29999 7 4.39999 9.2C4.19999 9.7 4.5 10.3 5 10.5C5.1 10.5 5.19999 10.6 5.39999 10.6C5.89999 10.5 6.19999 10.2 6.39999 9.89999ZM14.8 19.5C17 18.7 18.8 16.9 19.6 14.7C19.8 14.2 19.5 13.6 19 13.4C18.5 13.2 17.9 13.5 17.7 14C17.1 15.7 15.8 17 14.1 17.6C13.6 17.8 13.3 18.4 13.5 18.9C13.6 19.3 14 19.6 14.4 19.6C14.5 19.6 14.6 19.6 14.8 19.5Z" fill="currentColor" />
																						<path d="M16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z" fill="currentColor" />
																					</svg>
																				</span>
																				</div>
																				<div class="timeline-content m-0">
																					<div class="d-flex align-items-center mb-1">
																						<span class="fs-6 text-gray-800 fw-bold">{{ $tarea->titulo_tarea }}</span>
																						<span class="badge badge-light-{{ $color }} fs-8 ms-auto px-2 py-1">
																							{{ $atrasada ? 'Atrasada' : 'Pendiente' }}
																						</span>
																					</div>
																					<span class="fs-7 {{ $atrasada ? 'text-danger' : 'text-gray-400' }} fw-semibold d-block">
																						{{ $fecha->translatedFormat('d F, Y') }}
																					</span>
																					<div class="">
																						<a href="{{ route('tarea', $tarea->id_tarea) }}" class="text-primary fw-bold text-uppercase" style="font-size: 8px; letter-spacing: 1px;">
																							Ver Más 
																						</a>
																					</div>
																				</div>
																			</div>
																		@endforeach
																	</div>
																@else
																	<p class="text-gray-400 text-center py-5">No hay tareas pendientes.</p>
																@endif
															</div>
															<div class="tab-pane fade" id="kt_list_widget_10_tab_2">
																@if($enDesarrollo->count() > 0)
																		<div class="timeline">
																			@foreach($enDesarrollo as $tarea)
																				@php
																					$fecha = \Carbon\Carbon::parse($tarea->fecha_entrega);
																					$atrasada = $fecha->isPast() && !$fecha->isToday();
																					$color = $atrasada ? 'danger' : 'warning';
																				@endphp
																				<div class="timeline-item align-items-center mb-7">
																					<div class="timeline-line w-40px mt-6 mb-n12"></div>
																					<div class="timeline-icon" style="margin-left: 11px">
																						<span class="svg-icon svg-icon-2 svg-icon-{{ $color }}">
																							<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="currentColor" opacity="0.3"/><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
																						</span>
																					</div>
																					<div class="timeline-content m-0">
																						<div class="d-flex align-items-center mb-1">
																							<span class="fs-6 text-gray-800 fw-bold">{{ $tarea->titulo_tarea }}</span>
																							<span class="badge badge-light-{{ $color }} fs-8 ms-auto px-2 py-1">
																								{{ $atrasada ? 'Atrasada' : 'en proceso' }}
																							</span>
																						</div>
																						<span class="fs-7 {{ $atrasada ? 'text-danger' : 'text-gray-400' }} fw-semibold d-block">
																							{{ $fecha->translatedFormat('d F, Y') }}
																						</span>
																						<div class="">
																							<a href="{{ route('tarea', $tarea->id_tarea) }}" class="text-primary fw-bold text-uppercase" style="font-size: 8px; letter-spacing: 1px;">
																								Ver Más 
																							</a>
																						</div>
																					</div>
																				</div>
																			@endforeach
																		</div>
																	@else
																		<p class="text-gray-400 text-center py-5">No hay tareas en proceso.</p>
																	@endif
															</div>
															<div class="tab-pane fade" id="kt_list_widget_10_tab_3">
																@if($finalizadas->count() > 0)
																	<div class="timeline">
																		@foreach($finalizadas as $tarea)
																			<div class="timeline-item align-items-center mb-7">
																				<div class="timeline-line w-40px mt-6 mb-n12"></div>
																				<div class="timeline-icon" style="margin-left: 11px">
																					<span class="svg-icon svg-icon-2 svg-icon-success">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M10.58 13.41l-2.41-2.41L7.05 12.12L10.58 15.65L17.65 8.58L16.53 7.46L10.58 13.41Z" fill="currentColor"/></svg>
																					</span>
																				</div>
																				<div class="timeline-content m-0">
																					<div class="d-flex align-items-center mb-1">
																						<span class="fs-6 text-gray-800 fw-bold">{{ $tarea->titulo_tarea }}</span>
																						<span class="badge badge-light-success fs-8 ms-auto px-2 py-1">Finalizada</span>
																					</div>
																					<span class="fs-7 text-gray-400 fw-semibold d-block">Completada</span>
																					<div class="">
																						<a href="{{ route('tarea', $tarea->id_tarea) }}" class="text-primary fw-bold text-uppercase" style="font-size: 8px; letter-spacing: 1px;">
																							Ver Más 
																						</a>
																					</div>
																				</div>
																			</div>
																		@endforeach
																	</div>
																@else
																	<p class="text-gray-400 text-center py-5">No hay tareas finalizadas.</p>
																@endif
															</div>
														</div>
														<!--end::Tab Content-->
									</div>
								<!--end: Card Body-->
							</div>
							<!--end::List widget 10-->
						</div>
					@endcan	
				</div>
			</div>
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
											<input type="text" class="form-control form-control-solid" placeholder="" name="estado_proyecto" id="estado_proyecto" value="{{ $proyecto->estado_proyecto}}" disabled/>
										</div>
										<div class="mb-5 fv-row mb-7">
											<label class="fs-6 fw-semibold mb-2 required">Categoría</label>
											<input type="text" class="form-control form-control-solid" 
											value="{{ $proyecto->categoria->nombre_categoria }}" readonly>

												<!-- Enviar el id al backend -->
											<input type="hidden" name="id_categoria" value="{{ $proyecto->id_categoria }}">
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