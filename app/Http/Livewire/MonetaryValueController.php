<?php

namespace App\Http\Livewire;

use Livewire\WithPagination; //paginations
use App\Models\add_monetary_fund; //model
use App\Models\Branch; //model
use Livewire\Component;

class MonetaryValueController extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    //public properties
    public $branchs;
    public $branch_id = '...'; 
    public $monetary_value; 
   
    public $selected_id, $search;
    public $action = 1; //permtir movernos entre forms
    private $pagination = 5;

    public function mount()
    {}

    public function render()
    {
         //esto es para cargar los usuarios y poder asignarlos al select
         $branchs = add_monetary_fund::all();

         if(strlen($this->search) > 0) //validar que la variable search tenga algun valor
        {
             $info = add_monetary_fund::where('monetary_value','like', '%' . $this->search  . '%')->paginate($this->pagination);
             return view('livewire.monetary_value.component', [
                 'info' => $info, 'data' => $branchs
             ]);
        }
        else{
             return view('livewire.monetary_value.component', [
                 'info' => add_monetary_fund::paginate($this->pagination),'data' => $branchs //orderBy('name', 'DESC')
             ]);
        }
    }

     //para busquedas con paginacion OJO (Necesario en la documentacion de LIVEWIRE)
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
         $this->branch_id = '...';
         $this->monetary_value = '';
         $this->selected_id = null;
         $this->action = 1;
         $this->search = '';
     }
 
     //mostrar el registro a editar
     public function edit($id)
     {
         $record = add_monetary_fund::findOrFail($id);
 
         $this->branch_id = $record->branch_id;
         $this->monetary_value = $record->monetary_value;
         $this->selected_id = $record->id;
         $this->action = 2;
     }
 
     //crear y/o editar
     public function StoreOrUpdate()
     {
         //validar descripcion
         $this->validate([
             'monetary_value' => 'required',
             'branch_id' => 'required'
         ]);
 
         if($this->selected_id <= 0){ //se esta creando un registro
             //creamos registro
             $record = add_monetary_fund::create([
                 'monetary_value' => $this->monetary_value,
                 'branch_id' => $this->branch_id,
             ]);
         }
         else
         {
             //buscamos el registro
             $record = add_monetary_fund::find($this->selected_id);
             //actualizamos la inf
             $record->update([
                 'monetary_value' => $this->monetary_value,
                 'branch_id' => $this->branch_id,
             ]);
         }
 
         //notificar al usuario
         if($this->selected_id)
             session()->flash('message', 'add_monetary_fund Updated');
         else
             session()->flash('message', 'add_monetary_fund Created');
 
         //limpiar los campos
         $this->resetInput();
     }
 
      //eliminar registros
      public function destroy($id)
      {
          if($id)
          {
              $record = add_monetary_fund::where('id', $id);
              $record->delete();
              $this->resetInput();
          }
      }
 
     //listeners / escuchar eventos y ejecutar acciones
     protected $listeners = [
         'deleteRow' => 'destroy'
     ];
 

}
