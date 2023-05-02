<?php

namespace App\Http\Livewire;

use Livewire\WithPagination; //las librerias para las paginaciones
use Livewire\Component;
use App\Models\Weight; //modelo

class WeightController extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    //public properties
    public $relacion_lb; //campos de la tabla weights
    public $name; //campos de la tabla weights
    public $selected_id, $search;
    public $action = 1; //permtir movernos entre forms
    private $pagination = 5;

    public function mount()
    {}

    public function render()
    {
        if(strlen($this->search) > 0) //validar que la variable search tenga algun valor
       {
            $info = Weight::where('name','like', '%' . $this->search  . '%')->paginate($this->pagination);
            return view('livewire.weight.component', [
                'info' => $info,
            ]);
       }
       else{
            return view('livewire.weight.component', [
                'info' => Weight::paginate($this->pagination), //orderBy('name', 'DESC')
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
        $this->relacion_lb = null;
        $this->name = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    //mostrar el registro a editar
    public function edit($id)
    {
        $record = Weight::findOrFail($id);

        $this->relacion_lb = $record->relacion_lb;
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->action = 2;
    }

    //crear y/o editar
    public function StoreOrUpdate()
    {
        //validar descripcion
        $this->validate([
            'name' => 'required|max:5',
            'relacion_lb' => 'required|max:6'
        ]);

        //validar si existe otro registro con el mismo nombre en descripcion
        if($this->selected_id > 0)
        {
            $existe = Weight::where('name', $this->name)->where('id', '<>', $this->selected_id)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }
        else
        {
            $existe = Weight::where('name', $this->name)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }

        if($this->selected_id <= 0){ //se esta creando un registro
            //creamos registro
            $record = Weight::create([
                'name' => $this->name,
                'relacion_lb' => $this->relacion_lb
            ]);
        }
        else
        {
            //buscamos el registro
            $record = Weight::find($this->selected_id);
            //actualizamos la inf
            $record->update([
                'name' => $this->name,
                'relacion_lb' => $this->relacion_lb
            ]);
        }

        //notificar al usuario
        if($this->selected_id)
            session()->flash('message', 'Weight Updated');
        else
            session()->flash('message', 'Weight Created');

        //limpiar los campos
        $this->resetInput();
    }

     //eliminar registros
     public function destroy($id)
     {
         if($id)
         {
             $record = Weight::where('id', $id);
             $record->delete();
             $this->resetInput();
         }
     }

    //listeners / escuchar eventos y ejecutar acciones
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

}
