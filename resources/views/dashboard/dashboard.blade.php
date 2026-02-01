@extends('welcome')

@section('contenido')
<div id="app_general" class="p-8">
    <div class="row g-5">
        <div class="col-md-8">
            <div class="row g-5 mb-5">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm" style="background-color: #f9fccf; color:#5a6005">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Total Proyectos</div>
                            <div class="fw-bolder fs-1">{{ $totalProyectos}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm" style="background-color: #cff4fc; color:#055160">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Proyectos Activos</div>
                            <div class="fw-bolder fs-1">
                                {{ $proyectosActivos }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm" style="background-color: #e1fccf; color:#226005">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Proyectos Finalizados</div>
                            <div class="fw-bolder fs-1">{{ $proyectosFinalizados }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm" style="background-color:#f8d7da; color:#842029">
                        <div class="card-body p-5 text-center">
                            <div class="fw-bold fs-7">Proyectos Atrasados</div>
                            <div class="fw-bolder fs-1">{{ $proyectosAtrasados }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 pt-5 bg-white text-center">
                    <h3 class="card-title fw-bolder">Estado de Tareas</h3>
                </div>
                <div class="card-body" style="width:450px">
                    <div style="background-color: rgba(224, 224, 224, 0.295); padding: 15px; border-radius: 8px;">
                        <span class="fs-7 fw-semibold text-gray-600 text-uppercase">Total de tareas</span>
                        <div style="height: 250px; position: relative;"> 
                            <canvas id="graficoDonaTareas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-6">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div class="fw-bold fs-5 text-gray-800">Panorama Institucional</div>
                            </div>
                            <div class="p-6">
                                <div class="d-flex flex-wrap gap-5 mb-8 border-bottom pb-5">
                                <div class="me-2">
                                    <div class="d-flex align-items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" style="color: #DBC339;" class="bi bi-mortarboard-fill me-2" viewBox="0 0 16 16">
                                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z"/>
                                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z"/>
                                        </svg>
                                        <span class="fs-2 fw-bold text-gray-800 lh-1">{{ $proyectosAvalados }}</span>
                                    </div>
                                    <span class="fs-6 fw-semibold text-gray-400">Semilleros Avalados</span>
                                </div>
                                <div class="border-start-dashed border-1 border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">
                                    <!--begin::Statistics-->
                                    <div class="d-flex align-items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" style="color:#226005" class="bi bi-person-fill-check" viewBox="0 0 16 16">
                                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                            <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                                        </svg>
                                        <span class="fs-2 fw-bold text-gray-800 lh-1">0</span>
                                    </div>
                                    <span class="fs-6 fw-semibold text-gray-400">Estudiantes Activos</span>
                                </div>        
                            </div>
                            </div>
                            <div style="background-color: rgba(224, 224, 224, 0.295); padding: 15px; border-radius: 8px;">
                                <span class="fs-7 fw-semibold text-gray-600 text-uppercase">Participación de Proyectos por Facultad</span>
                                <div style="flex: 1.5; height: 200px; max-width: 450px;"> 
                                    <canvas id="graficoFacultades"></canvas>
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
    data-inicial-pendientes="{{ $totalPendientes }}"
    data-inicial-enproceso="{{ $totalEnProceso }}"
    data-inicial-finalizada="{{ $totalFinalizado }}"
    data-inicial-proyectos-activos="{{ $proyectosActivos }}"
    data-inicial-proyectos-finalizados="{{ $proyectosFinalizados }}"
    data-inicial-proyectos-atrasados="{{ $proyectosAtrasados }}"
    data-inicial-proyectos-avalados="{{ $proyectosAvalados }}">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    @vite('resources/js/dashboard/dashboard.js')
@endsection