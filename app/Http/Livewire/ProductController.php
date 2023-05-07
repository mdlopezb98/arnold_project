<?php

namespace App\Http\Livewire;

use Livewire\WithPagination; //paginations
use App\Models\Product; //model
use App\Models\Branch; //model
use App\Models\Type; //model
use App\Models\Weight; //model

use Livewire\Component;

class ProductController extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    //public properties
    public $branchs;
    public $types;
    public $weight;

    public $branch_id = '';
    public $type_id = '';
    public $weight_id = ''; 

    //atributos del producto
    public $name, $cant, $price, $description;

   
    public $selected_id, $search;
    public $action = 1; //permtir movernos entre forms
    private $pagination = 5;

    public function mount()
    {}

    public function render()
    {
         //esto es para cargar los usuarios y poder asignarlos al select
         $branchs = Branch::all();
         $types = Type::all();
         $weight = Weight::all();

         if(strlen($this->search) > 0) //validar que la variable search tenga algun valor
        {
             $info = Product::where('name','like', '%' . $this->search  . '%')->paginate($this->pagination);
             return view('livewire.product.component', [
                 'info' => $info, 'data' => $branchs, 'data_type' => $types, 'data_weight' => $weight
             ]);
        }
        else{
             return view('livewire.product.component', [
                 'info' => Product::paginate($this->pagination),'data' => $branchs, 'data_type' => $types, 'data_weight' => $weight //orderBy('name', 'DESC')
             ]);
        }
    }

    public function updatingSearch(): void
     {
         $this->gotoPage(1);
     }
 
     //permitir movernos entre formularios
     public function doAction($action)
     {
         $this->action = $action;
     }
 
     //limpiar todas las variables
     public function resetInput()
     {
         $this->branch_id = null;
         $this->type_id = null;
         $this->weight_id = null;

         $this->name = '';
         $this->cant = '';
         $this->price = '';
         $this->description = '';

         $this->selected_id = null;
         $this->action = 1;
         $this->search = '';
     }

     public function edit($id)
     {
         $record = Product::findOrFail($id);
 
         $this->branch_id = $record->branch_id;
         $this->type_id = $record->type_id;
         $this->weight_id = $record->weights_id;

         $this->name = $record->name;
         $this->cant = $record->cant;
         $this->price = $record->price;
         $this->description = $record->description;

         $this->selected_id = $record->id;
         $this->action = 2;
     }

     public function StoreOrUpdate()
     {
         //validar descripcion
         $this->validate([
             'name' => 'required',
             'cant' => 'required',
             'price' => 'required',
             'description' => 'required',
             'branch_id' => 'required',
             'type_id' => 'required',
             'weight_id' => 'required',
         ]);

        if($this->selected_id > 0)
        {
            $existe = Product::where('name', $this->name)->where('id', '<>', $this->selected_id)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }
        else
        {
            $existe = Product::where('name', $this->name)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }
 
         if($this->selected_id <= 0){ //se esta creando un registro
             //creamos registro
             $record = Product::create([
                 'name' => $this->name,
                 'cant' => $this->cant,
                 'price' => $this->price,
                 'description' => $this->description,
                 'branch_id' => $this->branch_id,
                 'type_id' => $this->type_id,
                 'weights_id' => $this->weight_id
             ]);
         }
         else
         {
             //buscamos el registro
             $record = Product::find($this->selected_id);
             //actualizamos la inf
             $record->update([
                'name' => $this->name,
                'cant' => $this->cant,
                'price' => $this->price,
                'description' => $this->description,
                'branch_id' => $this->branch_id,
                'type_id' => $this->type_id,
                'weights_id' => $this->weight_id
             ]);
         }
 
         //notificar al usuario
         if($this->selected_id)
             session()->flash('message', 'Product Updated');
         else
             session()->flash('message', 'Product Created');
 
         //limpiar los campos
         $this->resetInput();
     }

     public function destroy($id)
      {
          if($id)
          {
              $record = Product::where('id', $id);
              $record->delete();
              $this->resetInput();
          }
      }
 
     //listeners / escuchar eventos y ejecutar acciones
     protected $listeners = [
         'deleteRow' => 'destroy'
     ];

}
