@extends('welcome')

@section('styles')

@endsection
@section('contenido')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
						<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Categorias</h1>
						<!--end::Title-->
						<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
								<!--begin::Item-->
								<li class="breadcrumb-item text-muted">
									<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Información categorias</a>
								</li>
								<!--end::Item-->
							</ul>
						<!--end::Breadcrumb-->
					</div>
					<!--end::Page title-->
					<!--begin::Actions-->
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="#" class="btn btn-sm fw-bold btn-success" data-bs-toggle="modal" data-bs-target="#modal_registrar_categoria">Crear categoria</a>
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
								<input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-300px ps-15" id="buscador_categorias" placeholder="Buscar pedido"/>
							</div>
						<!-- ./ Input buscador de materias primas -->
						</div>
                	</div>
					<div class="card-body pt-9 pb-0">
						<table class="table display responsive table-row-bordered gy-5 table-striped" id="listadoDeCategorias" >
							<thead>
								<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Eliminado</th>
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

@endsection
@section('modales')
<!-- Modal Registrar -->
<div class="modal fade" id="modal_registrar_categoria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" id="registrar_categoria_content">
            <form class="form" id="formulario_registrar_categoria">
                <div class="modal-header" id="header_registrar_categoria">
                    <h2 class="fw-bold">Crear categoria</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        ✖
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5 fv-row">
                        <label class="fs-6 fw-semibold mb-2 required">Nombre de la categoria</label>
                        <input type="text" class="form-control form-control-solid" 
                            id="nombre_categoria_registrar" 
                            name="nombre_categoria" />
                    </div>
                    <div class="mb-5 fv-row">
                        <label class="form-label">Descripción de la categoria</label>
                        <textarea class="form-control form-control-solid form-control-sm"
                                name="descripcion_categoria"
                                id="descripcion_categoria_registrar" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" id="btn_registrar_categoria" class="btn btn-success" @click.prevent="registrarCategoria">
                        <span class="indicator-label">Registrar categoría</span>
                        <span class="indicator-progress">Por favor espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Editar -->
<div class="modal fade" id="modal_editar_categoria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" id="editar_categoria_content">
            <form class="form" id="formulario_editar_categoria">
                <input type="hidden" id="id_categoria_actualizar" name="id_categoria">

                <div class="modal-header" id="header_editar_categoria">
                    <h2 class="fw-bold">Editar categoria</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        ✖
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5 fv-row">
                        <label class="fs-6 fw-semibold mb-2 required">Nombre de la categoria</label>
                        <input type="text" class="form-control form-control-solid" 
                            id="nombre_categoria_editar" 
                            name="nombre_categoria"/>
                    </div>
                    <div class="mb-5 fv-row">
                        <label class="form-label">Descripción de la categoria</label>
                        <textarea class="form-control form-control-solid form-control-sm"
                                name="descripcion_categoria"
                                id="descripcion_categoria_editar" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" id="btn_editar_categoria" class="btn btn-success" @click.prevent="editarCategoria">
                        <span class="indicator-label">Editar Categoria</span>
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
@section('scripts')
	@vite('resources/js/categorias/registrar_categoria.js')
@endsection				
