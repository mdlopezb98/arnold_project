<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h5>
                    <b> @if($selected_id == 0) Registrar Nueva Sucursal @else Editar Sucursal @endif</b>
                </h5>

                @include('common.message')

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    
                                </div>
                                <div class="row g-3">
                                    <div class="col-md">
                                        <input type="text" class="form-control bg-light border-1 small" placeholder="Nombre" wire:model.lazy="name">
                                    </div>
                                    <div class="col-md">
                                        <textarea class="form-control bg-light border-1 small" style="width:400px" placeholder="Descripcion" wire:model.lazy="description"></textarea>
                                    </div>
                                    <div class="col-md">
                                        <select name="" id="" wire:model="user_id" class="form-control bg-light border-1 small">
                                            <option value="..." disabled>...</option>
                                            @if(!empty($data))
                                                @foreach($data as $u)
                                                <option value="{{$u->id}}">{{$u->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
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