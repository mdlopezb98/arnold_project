<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h5>
                    <b> @if($selected_id == 0) Crear Nuevo Tipo @else Editar Tipo @endif</b>
                </h5>

                @include('common.message')

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0
                                    1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md">
                                        <input type="text" class="form-control bg-light border-1 small" placeholder="Nombre del tipo" wire:model.lazy="description">
                                    </div>
                                    <div class="col-md">
                                        <input type="number" min="0" step="0.01" class="form-control bg-light border-1 small" placeholder="Rel. Moneda Nacional" wire:model.lazy="relacion_mn">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                        <i class="mbri-left"></i> Regresar
                    </button>
                    <button type="button"
                        wire:click="StoreOrUpdate()" class="btn btn-primary"><i class="mbri-success"></i> Guardar
                    </button>
            </div>
        </div>
    </div>
</div>