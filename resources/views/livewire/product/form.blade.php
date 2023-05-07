<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h5>
                    <b> @if($selected_id == 0) Registrar Nuevo Producto @else Editar Producto @endif</b>
                </h5>

                @include('common.message')

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    
                                </div>
                                <div class="row g-7">
                                    <div class="col-md">
                                        <input type="text" class="form-control bg-light border-1 small" placeholder="Nombre" wire:model.lazy="name">
                                    </div>
                                    <div class="col-md">
                                        <input type="number" min="0" step="0.01" class="form-control bg-light border-1 small" placeholder="Cantidad" wire:model.lazy="cant">
                                    </div>
                                    <div class="col-md">
                                       <select name="" id="" wire:model="weight_id" class="form-control bg-light border-1 small">
                                            <option value="" disabled>U.M</option>
                                            @if(!empty($data_weight))
                                                @foreach($data_weight as $w)
                                                <option value="{{$w->id}}">{{$w->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <input type="number" min="0" step="0.01" class="form-control bg-light border-1 small" placeholder="Costo" wire:model.lazy="price">
                                    </div>
                                    <div class="col-md">
                                       <select name="" id="" wire:model="type_id" class="form-control bg-light border-1 small">
                                            <option value="" disabled>Tipo de Moneda</option>
                                            @if(!empty($data_type))
                                                @foreach($data_type as $t)
                                                <option value="{{$t->id}}">{{$t->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <select name="" id="" wire:model="branch_id" class="form-control bg-light border-1 small">
                                            <option value="" disabled>Sucursal</option>
                                            @if(!empty($data))
                                                @foreach($data as $u)
                                                <option value="{{$u->id}}">{{$u->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <textarea class="form-control bg-light border-1 small" style="width:400px" placeholder="Descripción" wire:model.lazy="description"></textarea>
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