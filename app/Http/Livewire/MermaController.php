<?php

namespace App\Http\Livewire;

use Livewire\WithPagination; //las librerias para las paginaciones
use App\Models\Product; //modelo
use App\Models\Weight; //modelo
use App\Models\Merma; //modelo

use Livewire\Component;

class MermaController extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

     //public properties
     public $products;
     public $weight;
 
     public $product_id = '';
     public $weight_id = ''; 
 
    //atributos del producto
    public $cant, $description;


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
        $products = Product::all();
        $weight = Weight::all();

        if(strlen($this->search) > 0) //validar que la variable search tenga algun valor
       {
            $info = Merma::where('description','like', '%' . $this->search  . '%')->paginate($this->pagination);
            return view('livewire.merma.component', [
                'info' => $info, 'data_product' => $products, 'data_weight' => $weight
            ]);
       }
       else{
            return view('livewire.merma.component', [
                'info' => Merma::paginate($this->pagination), 'data_product' => $products, 'data_weight' => $weight //orderBy('description', 'DESC')
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
        $this->description = '';


        $this->product_id = '';
        $this->weight_id = '';

        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Merma::findOrFail($id);

        $this->cant = $record->cant;
        $this->description = $record->description;

        $this->product_id = $record->product_id;
        $this->weight_id = $record->weights_id;

        $this->selected_id = $record->id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        //validar descripcion
        $this->validate([
            'description' => 'required|max:150',
            'cant' => 'required',
            'weight_id' => 'required',
            'product_id' => 'required'
        ]);

        if($this->selected_id <= 0){ //se esta creando un registro
            //creamos registro
            $record = Merma::create([
                'description' => $this->description,
                'cant' => $this->cant,
                'weights_id' => $this->weight_id,
                'product_id' => $this->product_id
            ]);

            $prod = Product::find($this->product_id); //restarle al producto la cantidad por perdida
           
            $prod->update([
                'cant' => $prod['cant'] - $this->cant
            ]);
        }
        else
        {
            //buscamos el registro
            $record = Merma::find($this->selected_id);
            
            $prod = Product::find($this->product_id); //actualizo el producto
           
            $dif = $record['cant'] - $this->cant;
                $prod->update([
                'cant' => $prod['cant'] + $dif
            ]);
           
            //actualizamos la inf
            $record->update([
                'description' => $this->description,
                'cant' => $this->cant,
                'weights_id' => $this->weight_id,
                'product_id' => $this->product_id
            ]);

        }

        //notificar al usuario
        if($this->selected_id)
            session()->flash('message', 'Merma Updated');
        else
            session()->flash('message', 'Merma Created');

        //limpiar los campos
        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id)
        {
            $record = Merma::find($id);
           
            $prod = Product::find($record['product_id']);
            
            $prod->update([
                'cant' => $prod['cant'] + $record['cant']
            ]);

            $record = Merma::where('id', $id);
            $record->delete();
            $this->resetInput();
        }
    }

   protected $listeners = [
       'deleteRow' => 'destroy'
   ];
}
