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
																<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
																	<path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708z"/>
																	<path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
																</svg>
															</div>
														</div>
														
														<div class="d-flex flex-column flex-grow-1 overflow-hidden">
															<a href="{{ \Illuminate\Support\Str::start($tarea->url_tarea, 'https://') }}" 
																target="_blank" 
																class="text-gray-800 text-hover-primary fw-bold fs-7 text-truncate">
																Ver documento adjunto
															</a>
															<span class="text-gray-500 fw-semibold fs-9 text-truncate">{{$tarea->url_tarea}}</span>
														</div>
													</div>
													
													@can('Ver_entrega')
														@if($tarea->intentos_realizados < 2)
															<button class="btn btn-success btn-sm w-100 fw-bold py-3 shadow-sm" 
																	data-bs-toggle="modal" data-bs-target="#modal_entregar_tarea">
																<i class="ki-duotone ki-arrows-loop fs-4 me-2"></i>
																Intentar nuevamente ({{$tarea->intentos_realizados}}/2)
															</button>
														@else
															<div class="alert alert-light-danger d-flex align-items-center p-3 rounded">
																<i class="ki-duotone ki-information-5 fs-2x text-danger me-2"></i>
																<span class="fw-bold text-danger fs-8">Has alcanzado el límite de dos intentos</span>
															</div>
														@endif
													@endcan
													
												@else
													<div class="text-center py-4">
														<div class="symbol symbol-50px mb-3">
															<div class="symbol-label bg-white shadow-sm" style="background-color: rgba(255, 255, 255, 0.5) !important;">
																<i class="ki-duotone ki-cloud-add fs-2tx text-gray-500"></i>
															</div>
														</div>
														<p class="text-gray-700 fs-7 fw-bold mb-5">No hay archivos entregados</p>
														@can('Ver_entrega')
															<button class="btn btn-success w-100 fw-bold py-3" data-bs-toggle="modal" data-bs-target="#modal_entregar_tarea">
																Subir Entrega
															</button>
														@endcan
													</div>
												@endif
												{{-- Falta ajustar está funcionalidad --}}
												@can('Evaluar_entrega')
													@if($tarea->estado_tarea == \App\Models\Tareas::ENTREGADAS)
														<button class="btn btn-success w-100 fw-bold py-3" data-bs-toggle="modal" data-bs-target="#modal_calificar_tarea">
															Calificar Entrega
														</button>
													@endif
												@endcan	
												
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
                            <input type="text"
							class="form-control form-control-solid" 
							name="url_tarea" 
							id="url_tarea" 
							placeholder="Ej: https://..." 
							v-model="nuevaVersion.urlTarea"
							:class="{ 'border-danger': excedidos.url}"
							:maxlength="limites.urlTarea"/>
							<div class="d-flex justify-content-between mt-2">
								<small v-if="excedidos.url" class="text-danger">
									Límite máximo alcanzado.
								</small>
							</div>
                        </div>
                    </div>
					<div class="form-check form-switch mb-5">
						<input 
							class="form-check-input" 
							type="checkbox" 
							id="toggleVersion" 
							v-model="mostrarFormVersion"
						>
						<label class="form-check-label fw-bold" for="toggleVersion">
							¿Registrar nueva versión?
						</label>
					</div>

					<transition name="fade">
						<div v-if="mostrarFormVersion" class="card bg-light-primary border-dashed p-5 mb-5">
							<div class="row g-3">
								<div class="col-md-4">
									<input v-model="nuevaVersion.tag" 
									:class="{'border-danger': excedidos.version}"
									:maxlength="limites.tag" 
									type="text" class="form-control form-control-sm" 
									placeholder="v1.0.0">
									<div class="d-flex justify-content-between mt-2">
										<small v-if="excedidos.version" class="text-danger">
											Límite máximo alcanzado
										</small>
									</div>
								</div>
								<div class="col-md-8">
									<input v-model="nuevaVersion.descripcion_cambios" 
									type="text" 
									class="form-control form-control-sm" 
									placeholder="Descripción de cambios"
									v-model="nuevaVersion.descripcion_cambios"
									:class="{'border-danger': excedidos.descripcion}"
									:maxlength="limites.descripcion_cambios">
									<div class="d-flex justify-content-between mt-2">
										<small v-if="excedidos.descripcion" class="text-danger">
											Límite máximo alcanzado
										</small>
									</div>
								</div>
								
							</div>
						</div>
					</transition>
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

<div class="modal fade" id="modal_calificar_tarea" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" id="calificar_tarea">
            <form class="form" id="formulario_calificar_tarea">
                <div class="modal-header">
                    <h2 class="fw-bold">Calificar</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
					<div class="row g-9 mb-8">
						<div class="col-md-8 fv-row">
							<label class="required fs-6 fw-bold mb-2">Estado de la Tarea</label>
							<select name="estado_tarea" id="estado_tarea" class="form-select form-select-solid" data-control="select2" data-hide-search="true">
								@foreach($estados as $estado)
									<option value="{{ $estado }}" {{ $tarea->estado_tarea == $estado ? 'selected' : '' }}>
										{{ $estado }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4 fv-row">
							<label class="required fs-6 fw-bold mb-2">Avance (%)</label>
							<div class="input-group input-group-solid">
								<input type="number" name="porcentaje_avance" id="porcentaje_avance" class="form-control form-control-solid" min="0" max="100" value="{{ $tarea->porcentaje_avance ?? 0 }}" />
								<span class="input-group-text">%</span>
							</div>
						</div>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="fs-6 fw-bold mb-2">Observaciones del docente</label>
						<textarea class="form-control form-control-solid" 
						id="observaciones_docente" 
						rows="4" 
						name="observaciones_docente" 
						placeholder="Escriba aquí los detalles o correcciones..."
						value="{{ $tarea->observaciones_docente ?? '' }}">
						</textarea>
					</div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn_calificar_tarea" class="btn btn-success" @click.prevent="calificarTarea">
                        <span class="indicator-label">Calificar</span>
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