<?php

namespace App\Http\Livewire;

use Livewire\WithPagination; //las librerias para las paginaciones
use App\Models\Product; //modelo
use App\Models\Weight; //modelo
use App\Models\Type; //modelo
use App\Models\Branch; //modelo
use App\Models\Mov; //modelo

use Livewire\Component;

class MovController extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
//----------------------------------compra (suma) , venta(resta), delete(suma), update(verifica si es mayor o menor y procede)
     //public properties
     public $products;
     public $weights;
     public $types;
     public $branchs;
 
     public $id_prod = '';
     public $weight_id = '';
     public $type_id = '';
     public $branch_id = ''; 
   
    //atributos del mov
    public $mov_type = '1', $cant, $sales_price;

    public $selected_id, $search;
    public $action = 1; //permtir movernos entre forms
    private $pagination = 5;

    public function mount()
    {
        //-------------
    }

    public function render()
    {
        $products = Product::all();
        $weights = Weight::all();
        $types = Type::all();
        $branchs = Branch::all();

        if(strlen($this->search) > 0) //validar que la variable search tenga algun valor
       {    

            // $info = Mov::where('description','like', '%' . $this->search  . '%')->paginate($this->pagination);
            $info = Mov::where('movs.id', '!=', 0)->join('products', 'products.id', '=', 'movs.id_prod')->where('products.name', 'like', '%'.$this->search.'%')->select('movs.*')->paginate($this->pagination);
            return view('livewire.mov.component', [
                'info' => $info, 'data_product' => $products, 'data_weight' => $weights, 'data_type' => $types, 'data_branch' => $branchs
            ]);
       }
       else{
            return view('livewire.mov.component', [
                'info' => Mov::orderBy('movs.id', 'DESC')->paginate($this->pagination), 'data_product' => $products, 'data_weight' => $weights, 'data_type' => $types, 'data_branch' => $branchs //orderBy('description', 'DESC')
            ]);
       }
    }

    public function updatingSearch(): void
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->action = $action;
    }

    public function resetInput()
    {
        $this->cant = null;
        $this->mov_type = '1'; //1-venta 0 compra
        $this->sales_price = null;

        $this->id_prod = '';
        $this->weight_id = '';
        $this->type_id = '';
        $this->branch_id = '';

        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Mov::findOrFail($id);

        $this->cant = $record->cant;
        $this->mov_type = $record->mov_type;
        $this->sales_price = $record->sales_price;
        $this->id_prod = $record->id_prod;
        $this->weight_id = $record->weight_id;
        $this->type_id = $record->type_id;
        $this->branch_id = $record->branch_id;

        $this->selected_id = $record->id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        //validar descripcion
        $this->validate([
            'mov_type' => 'required',
            'cant' => 'required',
            'sales_price' => 'required',
            'weight_id' => 'required',
            'id_prod' => 'required',
            'type_id' => 'required',
            'branch_id' => 'required'
        ]);

        if($this->selected_id <= 0){ //se esta creando un registro
            //creamos registro
            $record = Mov::create([
                'mov_type' => $this->mov_type,
                'cant' => $this->cant,
                'sales_price' => $this->sales_price,
                'weight_id' => $this->weight_id,
                'id_prod' => $this->id_prod,
                'type_id' => $this->type_id,
                'branch_id' => $this->branch_id
            ]);

            //actualizo la cantidad de productos (compra +) vendo(-)
            $prod = Product::find($this->id_prod);
            if($this->mov_type == '1'){ //venta
                $prod->update([
                    'cant' => $prod['cant'] - $this->cant
                ]);
            }else{//compra
                $prod->update([
                    'cant' => $prod['cant'] + $this->cant
                ]);
            }
        }
        else
        {
            //buscamos el registro
            $record = Mov::find($this->selected_id);

            //actualizo la cantidad de productos (compra +) vendo(-)
            $prod = Product::find($this->id_prod);
            if($record['mov_type'] == '1'){ //venta
                $dif = $record['cant'] - $this->cant;
                $prod->update([
                    'cant' => $prod['cant'] + $dif
                ]);
            }else{//compra
                $dif = $this->cant - $record['cant'];
                $prod->update([
                    'cant' => $prod['cant'] + $dif
                ]);
            }

            //actualizamos la inf
            $record->update([
                'mov_type' => $this->mov_type,
                'cant' => $this->cant,
                'sales_price' => $this->sales_price,
                'weight_id' => $this->weight_id,
                'id_prod' => $this->id_prod,
                'type_id' => $this->type_id,
                'branch_id' => $this->branch_id
            ]);
        }

        //notificar al usuario
        if($this->selected_id)
            session()->flash('message', 'Mov Updated');
        else
            session()->flash('message', 'Mov Created');

        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id)
        {
            $record = Mov::find($id);
           
            $prod = Product::find($record['id_prod']);
            if($record['mov_type'] == '1'){ //venta
                $prod->update([
                    'cant' => $prod['cant'] + $record['cant']
                ]);
            }else{//compra
                $prod->update([
                    'cant' => $prod['cant'] - $record['cant']
                ]);
            }

            $record = Mov::where('id', $id);
    	    $record->delete();
            $this->resetInput();
        }
    }

   protected $listeners = [
       'deleteRow' => 'destroy'
   ];

}
