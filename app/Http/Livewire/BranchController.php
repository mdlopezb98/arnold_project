<?php

namespace App\Http\Livewire;

use Livewire\WithPagination; //paginations
use App\Models\Branch; //model
use App\Models\User; //model
use Livewire\Component;

class BranchController extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    //public properties
    public $users;
    public $user_id = null; //campos de la tabla Branchs
    public $description; //campos de la tabla Branchs
    public $name; //campos de la tabla Branchs
    public $selected_id, $search;
    public $action = 1; //permtir movernos entre forms
    private $pagination = 5;

    public function mount()
    {}

    public function render()
    {
        //esto es para cargar los usuarios y poder asignarlos al select
        $users = User::all();

        if(strlen($this->search) > 0) //validar que la variable search tenga algun valor
       {
            $info = Branch::where('name','like', '%' . $this->search  . '%')->paginate($this->pagination);
            return view('livewire.Branch.component', [
                'info' => $info, 'data' => $users
            ]);
       }
       else{
            return view('livewire.Branch.component', [
                'info' => Branch::paginate($this->pagination),'data' => $users //orderBy('name', 'DESC')
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
        $this->user_id = null;
        $this->description = null;
        $this->name = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    //mostrar el registro a editar
    public function edit($id)
    {
        $record = Branch::findOrFail($id);

        $this->user_id = $record->user_id;
        $this->description = $record->description;
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->action = 2;
    }

    //crear y/o editar
    public function StoreOrUpdate()
    {
        //validar descripcion
        $this->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:100',
            'user_id' => 'required'
        ]);

        //validar si existe otro registro con el mismo nombre en descripcion
        if($this->selected_id > 0)
        {
            $existe = Branch::where('name', $this->name)->where('id', '<>', $this->selected_id)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }
        else
        {
            $existe = Branch::where('name', $this->name)->select('name')->get();

            if($existe->count() > 0)
            {
                session()->flash('msg-error', 'Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }

        if($this->selected_id <= 0){ //se esta creando un registro
            //creamos registro
            $record = Branch::create([
                'name' => $this->name,
                'description' => $this->description,
                'user_id' => $this->user_id,
            ]);
        }
        else
        {
            //buscamos el registro
            $record = Branch::find($this->selected_id);
            //actualizamos la inf
            $record->update([
                'name' => $this->name,
                'description' => $this->description,
                'user_id' => $this->user_id,
            ]);
        }

        //notificar al usuario
        if($this->selected_id)
            session()->flash('message', 'Branch Updated');
        else
            session()->flash('message', 'Branch Created');

        //limpiar los campos
        $this->resetInput();
    }

     //eliminar registros
     public function destroy($id)
     {
         if($id)
         {
             $record = Branch::where('id', $id);
             $record->delete();
             $this->resetInput();
         }
     }

    //listeners / escuchar eventos y ejecutar acciones
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

}
