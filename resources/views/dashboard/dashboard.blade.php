@extends('welcome')

@section('contenido')
<div id="app_general" class="p-8">
    <div class="row g-5">
        <div class="col-md-8">
            <div class="row g-5 mb-5">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Total Proyectos</div>
                            <div class="fw-bolder fs-1">{{ $totalProyectos}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Proyectos Activos</div>
                            <div class="fw-bolder fs-1">
                                {{ $proyectosActivos }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Proyectos Finalizados</div>
                            <div class="fw-bolder fs-1">{{ $proyectosFinalizados }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Proyectos Atrasados</div>
                            <div class="fw-bolder fs-1">{{ $proyectosAtrasados }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body d-flex gap-4">
                <div class="card border-0 shadow-sm flex-grow-1" style="padding: 10px; border-radius: 8px;">  
                    <div class="card-body">
                        <div class="card-header border-0">
                            <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 text-gray-800">Porcentaje de avance</span>
                                <span class="text-muted mt-1 fw-bold fs-7">Proyectos</span>
                            </h3>
                            {{-- <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="bi bi-search position-absolute ms-3"></i>
                                    <input type="text" class="form-control form-control-solid w-200px ps-10" id="buscarProyecto" placeholder="Buscar proyecto..." value="{{ request('buscar') }}" />
                                </div>
                            </div> --}}
                        </div>
                            <div class="card-body scroll-y me-n5 pe-5" style="max-height: 200px;">
                                @forelse ($porcentajeProyecto as $porProyecto)
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <div class="flex-grow-1 me-2">
                                            <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{$porProyecto->nombre_proyecto}}</a>
                                            <span class="text-muted fw-bold d-block fs-8">{{ $porProyecto->ultima_version->version ?? 'Sin versión' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center w-100 mw-125px">
                                            <div class="progress h-6px w-100 me-2 bg-light-danger">
                                                <div class="progress-bar bg-{{ $porProyecto->color_progreso }}" 
                                                    role="progressbar" 
                                                    style="width: {{ $porProyecto->progreso_real }}%" 
                                                    aria-valuenow="{{ $porProyecto->progreso_real }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100" ></div>
                                            </div>
                                            <span class="text-gray-500 fw-bold fs-7">{{$porProyecto->progreso_real}}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                @empty
                                    <div class="text-center py-10">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-gray-400 fw-bold fs-6">Aún no tiene proyectos en curso</span>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        
                    </div>
                </div>
                <div class="card border-0 shadow-sm" style="padding: 40px; border-radius: 8px; width: 400px;">
                    <span class="card-label fw-bolder fs-3 text-gray-800">Tareas</span>
                    <div style="height: 250px;" class="mb-6 d-flex flex-column justify-content-center align-items-center">
                        @if($totalTareas > 0)
                            <canvas id="graficoDonaTareas" >
                            </canvas>
                        @else
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="ki-outline ki-clipboard-tick fs-4x text-gray-200"></i>
                                </div>
                                <span class="text-gray-400 fw-bold fs-6">Aún no tiene tareas disponibles</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mt-4 g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0" style="border-radius: 12px; height: 270px; overflow: hidden;">
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="card-header border-0 p-0 mb-4 bg-transparent flex-shrink-0">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-4 text-gray-800">Tareas Entregadas</span>
                                    <span class="text-muted mt-1 fw-bold fs-8 d-block">Últimas actividades de los investigadores</span>
                                </h3>
                            </div>
                            
                            <div class="flex-grow-1" style="overflow-y: auto; padding-right: 10px;">
                                <div class="timeline-steps">
                                    @forelse ($tareas as $tarea)
                                    <div class="timeline-item d-flex mb-8">
                                        <div class="symbol symbol-40px me-4">
                                            <div class="symbol-label bg-light-warning text-warning fw-bold">T</div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{$tarea->titulo_tarea}}</a>
                                                {{-- <span class="badge badge-light-dark fs-9">Ayer</span> --}}
                                            </div>
                                            <span class="text-muted fw-bold fs-8 d-block mb-2">Proyecto:{{$tarea->proyecto->nombre_proyecto}} </span>
                                            <div class="p-3 rounded-3 bg-light border-start border-warning border-3">
                                                <p class="text-gray-600 fs-9 mb-0 italic">{{$tarea->descripcion_tarea}}</p>
                                                <a href="{{ url('tarea/'.$tarea->id_tarea) }}" class="fs-9">
                                                    Revisar entrega
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-10">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-gray-400 fw-bold fs-6">Aún no se han realizado entregas</span>
                                        </div>
                                    </div>    
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0" style="border-radius: 12px; height: 270px; overflow: hidden;">
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="card-header border-0 p-0 mb-4 bg-transparent flex-shrink-0">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-4 text-gray-800">Control de versiones</span>
                                    <span class="text-muted mt-1 fw-bold fs-8 d-block">Últimas versiones</span>
                                </h3>
                            </div>
                            <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="sticky-top bg-white" style="z-index: 1;">
                                        <tr class="text-muted text-uppercase fs-9 border-bottom">
                                            <th class="ps-0">Proyecto</th>
                                            <th>Versión</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($versiones as $version)
                                            <tr>
                                                <td class="ps-0">
                                                    <span class="fw-bold text-gray-800">{{ $version->proyecto->nombre_proyecto }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light-primary fw-bold">{{ $version->version }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning">{{ $version->estado_version }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('version/'.$version->id_version) }}" 
                                                    class="btn btn-sm btn-light-primary fw-bold py-1 px-3 fs-9">
                                                        ver detalle
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-10">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-gray-400 fw-bold fs-6">Aún no tiene versiones pendientes</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-5 ps-1">
                <h3 class="fw-bolder text-gray-800 fs-4 mb-0">Panorama Institucional</h3>
                <span class="text-muted fw-semibold fs-8 text-uppercase tracking-tight">Métricas de Impacto y Agenda 2026</span>
            </div>

            <div class="row g-3 mb-6">
                <div class="col-4">
                    <div class="bg-white shadow-sm rounded-4 p-4 h-100 d-flex flex-column align-items-center text-center border-0">
                        <div class="symbol symbol-30px mb-2">
                            <div class="symbol-label bg-light-warning">
                                <i class="bi bi-mortarboard-fill text-warning fs-5"></i>
                            </div>
                        </div>
                        <span class="fs-3 fw-bolder text-gray-800">{{ $proyectosAvalados }}</span>
                        <span class="text-gray-400 fw-bold fs-9 text-uppercase mt-auto pt-2">Avalados</span>
                    </div>
                </div>

                <div class="col-4">
                    <div class="bg-white shadow-sm rounded-4 p-4 h-100 d-flex flex-column align-items-center text-center border-0">
                        <div class="symbol symbol-30px mb-2">
                            <div class="symbol-label bg-light-success">
                                <i class="bi bi-clipboard2-check-fill text-success"></i>
                            </div>
                        </div>
                        <span class="fs-3 fw-bolder text-gray-800">{{ $totalProyectosGeneral }}</span>
                        <span class="text-gray-400 fw-bold fs-9 text-uppercase mt-auto pt-2">Activos</span>
                    </div>
                </div>

                <div class="col-4">
                    <div class="bg-white shadow-sm rounded-4 p-4 h-100 d-flex flex-column align-items-center text-center border-0">
                        <div class="symbol symbol-30px mb-2">
                            <div class="symbol-label bg-light-info">
                                <i class="bi bi-people-fill text-info fs-5"></i>
                            </div>
                        </div>
                        <span class="fs-3 fw-bolder text-gray-800">{{ $estudiantes }}</span>
                        <span class="text-gray-400 fw-bold fs-9 text-uppercase mt-auto pt-2">Alumnos</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-6" style="border-radius: 16px;">
                <div class="card-body p-6">
                    <div class="d-flex flex-stack mb-5">
                        <span class="badge badge-light-primary fw-bolder fs-9 px-3 py-1 text-uppercase">Distribución por Facultad</span>
                    </div>
                    <div style="height: 300px;" class="mt-5 d-flex flex-column justify-content-center align-items-center">
                        @if(isset($participacion) && $participacion > 0)
                            {{-- Se muestra el gráfico si hay al menos 1 proyecto en facultades --}}
                            <canvas id="graficoFacultades"></canvas>
                        @else
                            {{-- Mensaje de estado vacío --}}
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="ki-outline ki-bank fs-4x text-gray-200"></i>
                                </div>
                                <span class="text-gray-400 fw-bold fs-6">Aún no hay participación en las facultades.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-start">
                <div class="card border-0 shadow-sm w-75" style="border-radius: 16px; min-width: 520px;">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center mb-4 text-primary">
                            <i class="bi bi-calendar-event-fill me-2"></i>
                            <h3 class="fw-bolder text-gray-800 fs-8 m-0">Agenda Próxima</h3>
                        </div>
                        
                        <div class="d-flex align-items-center mb-4">
                            <div class="w-4px h-30px bg-primary rounded-pill me-3"></div>
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 fw-bold fs-8 lh-1 mb-1">Feria de Semilleros</span>
                                <span class="text-muted fs-9">12 Mar • Presencial</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="w-4px h-30px bg-danger rounded-pill me-3"></div>
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 fw-bold fs-8 lh-1 mb-1">Cierre Convocatoria</span>
                                <span class="text-muted fs-9">05 Abr • Virtual</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="id_docente_sesion" 
    value="{{ auth()->user()->id_usuario }}" 
    data-inicial-proyectos="{{ $totalProyectos }}"
    data-inicial-asignadas="{{ $totalAsignadas }}"
    data-inicial-entregadas="{{ $totalEntregadas }}"
    data-inicial-finalizadas="{{ $totalFinalizadas }}"
    data-inicial-corregir="{{ $totalCorregidas }}"
    data-inicial-proyectos-activos="{{ $proyectosActivos }}"
    data-inicial-proyectos-finalizados="{{ $proyectosFinalizados }}"
    data-inicial-proyectos-atrasados="{{ $proyectosAtrasados }}"
    data-inicial-proyectos-avalados="{{ $proyectosAvalados }}"
    data-inicial-estudiantes="{{ $estudiantes }}"
    data-inicial-proyecto-general="{{ $totalProyectosGeneral }}"
    data-inicial-tareas="{{$tareas}}"
    data-inicila-versiones="{{$versiones}}"
    data-inicial-porcentajeProyecto="{{$porcentajeProyecto}}">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    @vite('resources/js/dashboard/dashboard.js')
@endsection