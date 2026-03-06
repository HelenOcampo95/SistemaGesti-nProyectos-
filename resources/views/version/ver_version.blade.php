@extends('welcome')

@section('contenido')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
		<div class="d-flex flex-column flex-column-fluid">	
			<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">				
				<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
					<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
						<div class="page-title d-flex align-items-center">
							<a href="/dashboard" class="text-gray-500 text-hover-primary me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
								</svg>
							</a>
							<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Detalle</h1>
						</div>
							<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
								<li class="breadcrumb-item text-muted">
									<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Información de la versión</a>
								</li>
							</ul>
					</div>
				</div>
			</div>
			<div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card shadow-sm ">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title align-items-start flex-column">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge badge-light-primary fw-bold me-2">V. {{ $version->version }}</span>
                                    <span class="text-muted fw-semibold fs-7">Detalle de la Entrega Realizada</span>
                                </div>
                                <h3 class="fw-bold text-dark fs-1">{{ $version->proyecto->nombre_proyecto }}</h3>
                            </div>
                            <div class="card-toolbar">
                                <span class="badge badge-{{ $version->estado_version == 'Pendiente' ? 'warning' : 'success' }} px-4 py-3">
                                    {{ $version->estado_version }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="bg-light-sm rounded p-8 border border-dashed border-gray-300">
                                
                                <div class="mb-8">
                                    <h4 class="text-gray-800 fw-boldest mb-4">
                                        <i class="ki-duotone ki- notepad-edit fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                                        Resumen de Cambios
                                    </h4>
                                    <div class="fs-5 text-gray-700 ps-9">
                                        {{ $version->descripcion_cambios ?? 'Sin descripción disponible.' }}
                                    </div>
                                </div>

                                <div class="separator separator-dashed my-8"></div>

                                <div class="row g-10 ps-9">
                                    <div class="col-sm-6">
                                        <h4 class="text-gray-800 fw-bold mb-4">Información Técnica</h4>
                                        <div class="d-flex flex-column gap-3">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted fw-bold w-150px">Fecha de entrega:</span>
                                                <span class="text-gray-800 fw-bolder">{{ \Carbon\Carbon::parse($version->fecha_modificacion)->format('d/m/Y h:i A') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted fw-bold w-150px">Estado de Gestión:</span>
                                                <span class="text-gray-800 fw-bolder">{{ $version->estado_version }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <h4 class="text-gray-800 fw-bold mb-4">Documentación Adjunta</h4>
                                        @if($version->archivos_relacionados)
                                            <div class="d-flex align-items-center bg-white border border-gray-300 rounded p-4">
                                                <i class="ki-duotone ki-file fs-2x text-danger me-3"><span class="path1"></span><span class="path2"></span></i>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                                    <a href="{{ \Illuminate\Support\Str::start($version->archivos_relacionados, 'https://') }}" 
														target="_blank" 
														class="text-gray-800 text-hover-primary fw-bold fs-7 text-truncate">
														{{$version->archivos_relacionados}}
													</a>
                                                    <span class="text-muted fs-8">Haga clic para previsualizar</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-muted fs-7 italic">No hay archivos cargados en esta versión.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($version->esPendiente())
                                <div class="d-flex justify-content-end mt-10">
                                    <button type="button" id="btn_rechazar_version" class="btn btn-danger me-3" >Rechazar Entrega</button>
                                    <button type="button" id="btn_aceptar_version" class="btn btn-success" @click="aceptarVersion({{ $version->id_version }})">Aprobar Entrega</button>
                                </div>
                            @endIf
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </div>
@endsection
@section('scripts')
    @vite('resources/js/version/version.js')
@endsection