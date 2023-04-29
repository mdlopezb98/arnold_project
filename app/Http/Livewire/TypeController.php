<?php

namespace App\Http\Livewire;

use Livewire\WithPagination; //las librerias para las paginaciones
use Livewire\Component;
use App\Models\Type; //modelo

class TypeController extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    //public properties
    public $relacion_mn; //campos de la tabla money types
    public $description; //campos de la tabla money types
    public $selected_id, $search;
    public $action = 1; //permtir movernos entre forms
    private $pagination = 5;

    public function mount()
    {
        //es el primero que se ejecuta al iniciarce el componente
        //inicializar variables / data
    }


    public function render()
    {
       if(strlen($this->search) > 0) //validar que la variable search tenga algun valor
       {
            $info = Type::where('name','like', '%' . $this->search  . '%')->paginate($this->pagination);
            return view('livewire.type.component', [
                'info' => $info,
            ]);
       }
       else{
            return view('livewire.type.component', [
                'info' => Type::paginate($this->pagination), //orderBy('description', 'DESC')
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
        $this->relacion_mn = null;
        $this->description = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    //mostrar el registro a editar
    public function edit($id)
    {
        $record = Type::findOrFail($id);

        $this->relacion_mn = $record->relacion_mn;
        $this->description = $record->name;
        $this->selected_id = $record->id;
        $this->action = 2;
    }

    //crear y/o editar
    public function StoreOrUpdate()
    {
        //validar descripcion
        $this->validate([
            'description' => 'required|max:5',
            'relacion_mn' => 'required|max:6'
        ]);

        //validar si existe otro registro con el mismo nombre en descripcion
        if($this->selected_id > 0)
        {
            $existe = Type::where('name', $this->description)->where('id', '<>', $this->selected_id)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }
        else
        {
            $existe = Type::where('name', $this->description)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }

        if($this->selected_id <= 0){ //se esta creando un registro
            //creamos registro
            $record = Type::create([
                'name' => $this->description,
                'relacion_mn' => $this->relacion_mn
            ]);
        }
        else
        {
            //buscamos el registro
            $record = Type::find($this->selected_id);
            //actualizamos la inf
            $record->update([
                'name' => $this->description,
                'relacion_mn' => $this->relacion_mn
            ]);
        }

        //notificar al usuario
        if($this->selected_id)
            session()->flash('message', 'Type Updated');
        else
            session()->flash('message', 'Type Created');

        //limpiar los campos
        $this->resetInput();
    }

     //eliminar registros
     public function destroy($id)
     {
         if($id)
         {
             $record = Type::where('id', $id);
             $record->delete();
             $this->resetInput();
         }
     }

    //listeners / escuchar eventos y ejecutar acciones
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

}
