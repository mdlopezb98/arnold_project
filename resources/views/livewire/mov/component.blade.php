<div class="shadow p-3 mb-5 bg-body rounded">
    @if($action == 1)
    <div class="widget-content-area br-8">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 text-center">
                    <h5><b>Compra/Venta</b></h5>
                </div>
            </div>
        </div>
        @include('common.search')
        @include('common.alerts')

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4"> 
                <thead>
                    <tr>
                        <th class="">TIPO DE MOV</th>
                        <th class="">PRODUCTO</th>
                        <th class="">CANTIDAD</th>
                        <th class="">U.M</th>
                        <th class="">PRECIO</th>
                        <th class="">T.M</th>
                        <th class="">SUCURSAL</th>
                        <th class="">FECHA</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($info as $r)
                    <tr>
                        <td><p class="mb-0">{{$r->mov_type == TRUE ? 'VENTA' : 'COMPRA'}}</p></td>
                        <td>@foreach($data_product as $prod)
                                @if($prod['id'] == $r->id_prod) 
                                    {{$prod->name}}
                                @endif 
                            @endforeach</td>
                        <td>{{$r->cant}}</td>
                        <td>@foreach($data_weight as $weight)
                                @if($weight['id'] == $r->weight_id) 
                                    {{$weight->name}}
                                @endif 
                            @endforeach</td>
                        <td>{{$r->sales_price}}</td>
                        <td>@foreach($data_type as $type)
                                @if($type['id'] == $r->type_id) 
                                    {{$type->name}}
                                @endif 
                            @endforeach</td>
                        <td>@foreach($data_branch as $b)
                                @if($b['id'] == $r->branch_id) 
                                    {{$b->name}}
                                @endif 
                            @endforeach</td>
                        <td>{{$r->updated_at}}</td>
                        <td class="text-center">
                            @include('common.actions')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
             {{$info->links()}}
        </div>
       
    </div>


    @elseif($action == 2)
    @include('livewire.mov.form')
    @endif

    <!-- Function delete -->
    <script type="text/javascript">
        function Confirm(id)
        {
            let me = this
            Swal.fire({
                title: 'CONFIRM',
                text: 'ARE YOU SURE?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Acept',
                cancelButtonText: 'Cancel',
                closeOnConfirm:false
            }).then((response) => {
                if(response.value){
                    console.log('ID', id);
                    window.livewire.emit('deleteRow', id) //AQUI EMITE UN EVENTO Y LOS LISTENER QUE ESTAN AL TANTO EJECUTAN LA FUNCION
                    toastr.success( "{{'Deleted succefull'}}", "info", {"iconClass": 'customer-info'});
                    swal.close()
                }
            })
            // function(){
            //     console.log('ID', id);
            //     window.livewire.emit('deleteRow', id) //AQUI EMITE UN EVENTO Y LOS LISTENER QUE ESTAN AL TANTO EJECUTAN LA FUNCION
            //     toastr.success('info', 'Deleted succefull')
            //     swal.close()
            // })
        }

        document.addEventListener('DOMContentLoaded', function () {

        });
    </script>

</div>






