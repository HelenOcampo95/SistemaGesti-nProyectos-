@extends('welcome')

@section('contenido')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
		<div class="d-flex flex-column flex-column-fluid">	
			<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">				
				<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
					<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
						<div class="page-title d-flex align-items-center">
							<a href="{{ url('detalle/' . $tarea->proyecto->id_proyecto) }}" class="text-gray-500 text-hover-primary me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
								</svg>
							</a>
							<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Detalle de la Entrega</h1>
						</div>
							<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
								<li class="breadcrumb-item text-muted">
									<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Información de la tarea</a>
								</li>
							</ul>
					</div>
				</div>
			</div>
			<div id="kt_app_content" class="app-content flex-column-fluid">
				<div id="kt_app_content_container" class="app-container container-xxl">
					<div class="card mb-5 mb-xl-10">
						<div class="card shadow-sm">
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="text-muted fw-semibold fs-7">Proyecto de Investigación</span>
									<span class="card-label fw-bold text-dark fs-3">{{ $tarea->proyecto->nombre_proyecto }}</span>
								</h3>
							</div>
							<div class="card-body perspective-main">
								<div class="row g-5 card-3d-dynamic">
									<div class="col-md-8">
										<div>
											<div class="d-flex justify-content-between align-items-start mb-6 layer-top">
												<div class="me-3">
													{{-- <span class="badge badge-light-primary fw-bold mb-2">Detalle de la Entrega</span> --}}
													<h2 class="text-dark fw-bolder fs-1">{{ $tarea->titulo_tarea }}</h2>
												</div>
												<div class="bg-light-danger border border-danger border-dashed rounded p-3 text-center min-w-125px">
													<span class="fs-8 fw-bold text-danger d-block uppercase">Fecha Límite</span>
													<span class="fs-6 fw-bolder text-gray-800">{{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d M, Y') }}</span>
												</div>
											</div>

											<div class="mb-8 layer-mid">
												<label class="fw-bold text-muted mb-2">Descripción del Proyecto</label>
												<div class="bg-light-primary bg-opacity-50 p-5 rounded-3 border border-primary border-dashed">
													<p class="text-gray-700 fs-6 m-0 lh-base">{{ $tarea->descripcion_tarea }}</p>
												</div>
											</div>
											<div class="col-sm-6 mb-5">
													<div>
														<span class="text-muted fw-bold d-block mb-1 fs-8">Estado actual:</span>
														<span class="badge badge-light-warning fw-bolder fs-7">{{ strtoupper($tarea->estado_tarea) }}</span>
													</div>
												</div>
											<div class="row g-4 layer-low">
												<div class="col-sm-12">
													<div class="bg-light rounded p-4 border h-100">
														<span class="text-muted fw-bold d-block mb-1 fs-8">Observaciones del Docente:</span>
														<span class="text-gray-800 fw-bold fs-7">{{ $tarea->observaciones_docente ?? 'Sin observaciones' }}</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="card border-0 shadow-sm" style=" border-radius: 15px; backdrop-filter: blur(4px);">
											<div class="card-body p-7">
												<h3 class="text-gray-800 fw-bold mb-6 fs-5">Entrega de Tarea</h3>

												@if(!empty($tarea->url_tarea))
													<div class="d-flex align-items-center p-4 bg-white rounded-3 border border-dashed border-gray-300 mb-6 shadow-sm">
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label bg-light-primary">
																<i class="ki-duotone ki-google-drive text-primary fs-1">
																	<span class="path1"></span><span class="path2"></span>
																</i>
															</div>
														</div>
														
														<div class="d-flex flex-column flex-grow-1 overflow-hidden">
															<a href="{{ $tarea->url_tarea }}" target="_blank" class="text-gray-800 text-hover-primary fw-bold fs-7 text-truncate">
																Ver documento adjunto
															</a>
															<span class="text-gray-500 fw-semibold fs-9 text-truncate">docs.google.com/...</span>
														</div>
													</div>

													<button class="btn btn-success btn-sm w-100 fw-bold py-3 shadow-sm" 
															data-bs-toggle="modal" data-bs-target="#modal_entregar_tarea">
														<i class="ki-duotone ki-arrows-loop fs-4 me-2"></i>
														Intentar nuevamente
													</button>
												@else
													<div class="text-center py-4">
														<div class="symbol symbol-50px mb-3">
															<div class="symbol-label bg-white shadow-sm" style="background-color: rgba(255, 255, 255, 0.5) !important;">
																<i class="ki-duotone ki-cloud-add fs-2tx text-gray-500"></i>
															</div>
														</div>
														<p class="text-gray-700 fs-7 fw-bold mb-5">No hay archivos entregados</p>
														<button class="btn btn-success w-100 fw-bold py-3" data-bs-toggle="modal" data-bs-target="#modal_entregar_tarea">
															Subir Entrega
														</button>
													</div>
												@endif
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
    </div>
</div>
<input type="hidden" id="id_tarea" value="{{$tarea->id_tarea}}">
<div class="modal fade" id="modal_entregar_tarea" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" id="registrar_proyecto">
            <form class="form" id="formulario_registrar_proyecto">
                <div class="modal-header">
                    <h2 class="fw-bold">Tarea</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_scroll" data-kt-scroll="true" data-kt-scroll-max-height="auto" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2 required">Url tarea</label>
                            <input type="text" class="form-control form-control-solid" name="url_tarea" id="url_tarea" placeholder="Ej: https://..." />
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn_crear_proyecto" class="btn btn-success" @click.prevent="entregarTarea">
                        <span class="indicator-label">Entregar</span>
                        <span class="indicator-progress">Espere... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    @vite('resources/js/tareas/detalle_tarea.js')
@endsection