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
										<a href="#" class="btn btn-sm fw-bold btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Crear categoria</a>
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
										<div class="card-body pt-9 pb-0">
											
										</div>
									</div>
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
</div> 
					{{-- Modal	 --}}
    <div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content" id="reasignar_comercial">
                        <form class="form" id="formulario_reasignar_comercial">
                            <!-- Encabezado modal materias primas -->
                            <div class="modal-header" id="kt_modal_add_customer_header">

                                <h2 class="fw-bold">Crear categoria</h2>

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
                                        <label class="fs-6 fw-semibold mb-2 required">Nombre de la categoria</label>
                                        <input type="text" class="form-control form-control-solid" id="categoria" placeholder="" name="categoria" value="" />
                                    <div class="mb-5 fv-row">
                                        <label for="" class="form-label">Descripción de la categoria</label>
                                        <textarea class="form-control form-control-solid form-control-sm" placeholder="" name="descripcion_categoria" id="descripcion_categoria" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer flex-center">
                                <button type="reset" id="btn_reasignar_comercial" class="btn btn-light me-3 d-none" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                                <button type="button" id="btn_seleccionar_comercial" class="btn btn-success" @click="asignarComercial">
                                <span class="indicator-label">Crear categoria</span>
                                <span class="indicator-progress">Cambiando al responsable...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                </button>
                            </div>
                        </form>
                </div>
        </div>
    </div>					

@endsection