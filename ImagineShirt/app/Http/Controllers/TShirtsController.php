<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TShirtRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\TShirts;
use App\Models\Categorias;
use App\Models\Precos;
use App\Models\Cores;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TShirtsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(TShirts::class, 't_shirt');
    }

    public function index(Request $request): View
    {
        //obter tshirts
        $tshirtsQuery = TShirts::query();
        
        //filtar categoria
        $categoriaFiltro = $request->categoria ?? '';
        
        if ($categoriaFiltro !== '' && $categoriaFiltro != 'user'){
            $idCategoriaFiltro = Categorias::where('name','LIKE',$categoriaFiltro)->pluck('id');
            $tshirtsQuery->where('category_id',$idCategoriaFiltro);
        }

        // ordernar entradas - Padrao: data descendente
        $ordenarFiltro = $request->ordenar ?? 'rec_desc';

        if (str_contains($ordenarFiltro,'rec')){
            $ordenarArray = preg_split("/[_\s:]/",$ordenarFiltro);
            $tshirtsQuery->orderBy('created_at',$ordenarArray[1]);
        }elseif(str_contains($ordenarFiltro,'name')){
            $ordenarArray = preg_split("/[_\s:]/",$ordenarFiltro);
            $tshirtsQuery->orderBy($ordenarArray[0],$ordenarArray[1]);
        }

        // string pesquisa
        $pesquisaFiltro = $request->pesquisa ?? '';

        if ($pesquisaFiltro !== ''){
            //primeiro procurar nome -> descrição
            $pesquisaFiltro = strtoupper($pesquisaFiltro);

            // para adicionar os (query)

            $tshirtsQuery->where(function ($query) use ($pesquisaFiltro){
                $query->where('name', 'LIKE', "%$pesquisaFiltro%")
                      ->orWhere('description', 'LIKE', "%$pesquisaFiltro%");
            });

        }
        
        $tshirtsQuery->whereNull('deleted_at');
        // ordernar alfabeticamente default - t-shirts loja

        $user = Auth::user();

        if(!empty($user) && $user->user_type === 'C'){
            $id = $user->id;
            $num_tshirts_user = TShirts::query()->where('customer_id', $id)->count();

            if ($categoriaFiltro === 'user'){

                $tshirtsQuery->where('customer_id', Auth::user()->id);

            }elseif ($num_tshirts_user){
                
                $tshirtsQuery->where(function ($query) {
                    $query->where('customer_id', Auth::user()->id)
                          ->orWhereNull('customer_id');
                });
            }else{
                $tshirtsQuery->whereNull('customer_id');
            }
            
        }else{
            $tshirtsQuery->whereNull('customer_id');
        }

        $tshirts = $tshirtsQuery->paginate(12, ['*'], 'pagina');

        // obter preços - apenas necessario preco loja e customer - desconto relacionado com nº artigos
        $precos = Precos::select(array('unit_price_catalog', 'unit_price_own'))->first()->toArray();
        // obter categorias
        $categorias = Categorias::whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();  

        //logs
        Log::debug('TShirts loaded on TShirtController.', ['$tshirts' => $tshirts]);
        Log::debug('Categorias loaded on TShirtController.', ['$categorias' => $categorias]);
        Log::debug('Prices loaded on TShirtController.', ['$precos' => $precos]);
        
        return view('tshirts.index', compact('tshirts','categorias','precos','categoriaFiltro','ordenarFiltro','pesquisaFiltro'));
    }

    public function show(TShirts $t_shirt): View
    {
        $cores = Cores::whereNull('deleted_at')->orderBy('name')->get();
        return view('tshirts.show', compact('t_shirt', 'cores'));
    }

    public function imagemCliente($nome_tshirt, $user_id, $image_url){
        $path = storage_path('app/tshirt_images_private/' . $image_url);
        
        $image = file_get_contents($path);
        $tipo = mime_content_type($path);

        if (Auth::user()->id != $user_id)
            return redirect()->route('root');
        
        return response($image, 200)->header('Content-Type', $tipo);
    }

    public function edit(TShirts $t_shirt): View{

        $categorias = Categorias::whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();

        return view('tshirts.edit', compact('t_shirt','categorias'));
    }

    public function update(TShirtRequest $request, TShirts $t_shirt): RedirectResponse{

        $user = Auth::user();
        $formData = $request->validated();
        $t_shirt = DB::transaction(function () use ($formData, $t_shirt, $request) {

            $t_shirt->name = $formData['name'];
            $t_shirt->description = $formData['description'];

            $encomendaID = Categorias::where('name', 'LIKE', $formData['category'])->pluck('id')->toArray();
            $t_shirt->category_id = $encomendaID[0];

            $t_shirt->save();
            
            // imagem para admin
            if ($request->hasFile('image') && $user->user_type === 'A') {
                if ($t_shirt->image_url) {
                    Storage::delete('public/tshirt_images' . $t_shirt->image_url);
                }
                $path = $request->image->store('public/tshirt_images');
                $t_shirt->image_url = basename($path);
                $t_shirt->save();
            }

            return $t_shirt;
        });

        $htmlMessage = "A T-Shirt foi alterada com sucesso!";

        Alert::success('Editada com sucesso!', $htmlMessage);

        return redirect()->route('t-shirts.show', $t_shirt->slug);

    }

    public function destroy(TShirts $t_shirt): RedirectResponse{

        $t_shirt->delete();

        $htmlMessage = "A T-Shirt foi eliminada com sucesso!";

        Alert::success('Eliminada com sucesso!', $htmlMessage);

        return redirect()->route('t-shirts', $t_shirt->slug);
    }

    public function create(): View{

        $categorias = Categorias::whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();
        $t_shirt = new TShirts();
        return view('tshirts.create', compact('t_shirt','categorias'));
    }

    public function store(TShirtRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $t_shirt = DB::transaction(function() use ($formData, $request){

            $user = Auth::user();

            $newTShirt = new TShirts();
            $newTShirt->name = $formData['name'];
            $newTShirt->description = $formData['description'];

            $encomendaID = Categorias::where('name', 'LIKE', $formData['category'])->pluck('id')->toArray();
            $newTShirt->category_id = $encomendaID[0];

            // imagem para admin
            if ($user->user_type === 'A'){
                $path = $request->image->store('public/tshirt_images');
                $newTShirt->image_url = basename($path);  
            }

            $newTShirt->save();
            return $newTShirt;
        });

        $htmlMessage = "A T-Shirt foi criada com sucesso!";

        Alert::success('Criada com sucesso!', $htmlMessage);

        return redirect()->route('t-shirts.show', $t_shirt->slug);
    }
}
