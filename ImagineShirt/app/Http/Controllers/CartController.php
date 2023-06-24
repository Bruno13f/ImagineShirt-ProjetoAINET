<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\TShirts;
use App\Models\Precos;
use App\Models\Cores;
use App\Models\ItensEncomenda;
use App\Models\Encomendas;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CheckoutRequest;
use Carbon\Carbon;
use Auth;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);
        $precos = Precos::get()->toArray();
        $cores = Cores::get();
        $tamanhos = array('XS','S','M','L','XL');

        return view('cart.show', compact('cart', 'precos', 'cores','tamanhos'));
    }

    public function checkout(){

        $user = Auth::user();
        $cart = session('cart', []);

        if (empty($cart)){
            Alert::warning('Não é possivel processar a encomenda!', 'Não há t-shirts no carrinho');
            return redirect()->route('root');
        }

        $precos = Precos::get()->toArray();

        return view('cart.checkout',compact('user','cart','precos'));
    }

    public function addToCart(Request $request, TShirts $t_shirt): RedirectResponse{

        try{

            if (!is_null(Auth::user())){
                $this->authorize('addToCart', TShirts::class);
            }

            if ($request->size == null){
                Alert::error('Tamanho não escolhido','Necessário escolher tamanho');
                return back();
            }

            if ($request->color_code == null){
                Alert::error('Cor não escolhida','Necessário escolher cor da t-shirt');               
                return back();
            }

            if ($request->qty == 0){
                Alert::error('Quantidade inválida','Necessário escolher quantidade');
                return back();
            }

            $cart = session('cart', []);

            if (array_key_exists($t_shirt->id, $cart)) {

                Alert::info('T-Shirt já no carrinho','Não é possivel adicionar a mesma t-shirt no carrinho');
                return back();

            } else {

                $itemCart = array($t_shirt,$request->color_code,$request->size,$request->qty);

                $cart[$t_shirt->id] = $itemCart;
                
                $request->session()->put('cart', $cart);
                Alert::success('T-Shirt adicionada!','Foi adicionada a t-shirt ao carrinho!');
                return back();
            }
            

        }catch(\Exception $error){
            Alert::error('Não foi possivel adicionar a t-shirt','Ocorreu um erro e não foi possivel adicionar a t-shirt ao carrinho!');
            return back();
        }

    }

    public function updateCart(Request $request): RedirectResponse{

        $parametros = $request->all();

        // token e metodo
        if(count($parametros) == 2){
            Alert::info('Carrinho vazio!','Não é possivel atualiza-lo');
            return back();
        }

        foreach ($parametros as $key => $value) {
            if (strpos($key, 'qty_') === 0) {
                $id = substr($key, strlen('qty_'));
                $tshirts[] = $id;
            }
        }

        $cart = session('cart', []);

        foreach($tshirts as $id){
            if (array_key_exists($id, $cart)){
                $cart[$id]["1"] = $parametros['color_'.$id];
                $cart[$id]["2"] = $parametros['tamanho_'.$id];
                $cart[$id]["3"] = $parametros['qty_'.$id];
            }
        }

        session()->put('cart', $cart);

        Alert::success('Carrinho atualizado','Detalhes das t-shirts foram atualizados');
        return back();
    }

    public function store(CheckoutRequest $request): RedirectResponse{

        $user = $request->user();
        $tipoUser = $user->user_type;

        if($tipoUser == 'A' || $tipoUser == 'E'){
            Alert::error('Não tem permissões','Não é cliente/user anóniomo logo não pode confirmar o carrinho');
            return back();
        }

        $cart = session('cart', []);
        $total = count($cart);

        if ($total < 1) {
            Alert::warning('Não é possivel processar a encomenda!', 'Não há t-shirts no carrinho');
            return back();
        }else {

            $newOrder = new Encomendas();
            $precos = Precos::get()->toArray();
            
            // criar itens encomendas

            // preencher encomenda
            $newOrder->status = 'pending';
            // id cliente = id customer
            $newOrder->customer_id = $user->id;
            $newOrder->date = Carbon::now()->format('Y-m-d');
            $newOrder->total_price = 0;
            $newOrder->notes = $request->notas;
            $newOrder->nif = $request->nif;
            $newOrder->address = $request->address;
            $newOrder->payment_type = $request->default_payment_type;
            $newOrder->payment_ref = $request->default_payment_ref;
            // criar quando encomenda estado fechado
            $newOrder->receipt_url = null; 

            $newOrder->save();

            $precoTotal = 0;

            foreach($cart as $cartItem){

                $newOrderItem = new ItensEncomenda();

                $newOrderItem->order_id = $newOrder->id;
                $newOrderItem->tshirt_image_id = $cartItem[0]->id;
                $newOrderItem->color_code = $cartItem[1];
                $newOrderItem->size = $cartItem[2];
                $newOrderItem->qty = $cartItem[3];

                if (is_null($cartItem[0]->customer_id)){

                    // loja
                    if ($cartItem[3] >= $precos[0]['qty_discount']){
                        $newOrderItem->unit_price = $precos[0]['unit_price_catalog_discount'];
                    }else{
                        $newOrderItem->unit_price = $precos[0]['unit_price_catalog'];
                    }

                }else{

                    // cliente
                    if ($cartItem[3] >= $precos[0]['qty_discount']){
                        $newOrderItem->unit_price = $precos[0]['unit_price_own_discount'];
                    }else{
                        $newOrderItem->unit_price = $precos[0]['unit_price_own'];
                    }
                }

                $newOrderItem->sub_total = $newOrderItem->unit_price * $cartItem[3];

                $precoTotal += $newOrderItem->sub_total;

                $newOrderItem->save();

            }

            $newOrder->total_price = $precoTotal;
            $newOrder->save();

            Alert::success('Encomenda criada!','Verifique no seu perfil o estado!');
            return redirect()->route('root');
        }
        
    }

    public function removeFromCart(Request $request, TShirts $t_shirt): RedirectResponse{

        $cart = session('cart', []);

        if (array_key_exists($t_shirt->id, $cart)) {
            unset($cart[$t_shirt->id]);
        }

        $request->session()->put('cart', $cart);
        Alert::success('Removida com sucesso','A t-shirt foi removida do carrinho!');
        return back();
    }

    public function destroy(Request $request): RedirectResponse
    {

        $cart = session('cart', []);

        if (empty($cart)){
            Alert::info('Carrinho vazio', 'Não há t-shirts no carrinho!');
            return back();  
        }

        $request->session()->forget('cart');
        Alert::success('Carrinho foi limpo', 'As t-shirts foram removidas do carrinho!');
        return back();   
    }
}
