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
use Illuminate\Support\Facades\Mail;
use App\Mail\CriadaEncomendaMail;

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

        $this->authorize('checkout', TShirts::class);

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

            if (count($cart) != 0){
                foreach($cart as $key => $cartItem){
                    if ($cartItem['tshirt']->id == $t_shirt->id && $cartItem['color_code'] == $request->color_code && $cartItem['size'] == $request->size){
                        $cart[$key]['qty'] += $request->qty;

                        $request->session()->put('cart', $cart);
                        Alert::success('T-Shirt adicionada!','Foi adicionada a t-shirt ao carrinho!');
                        return back();
                    }
                }
            }

            $itemCart = array(
                'tshirt' => $t_shirt,
                'color_code' => $request->color_code,
                'size' => $request->size,
                'qty' => $request->qty);

            $cart[] = $itemCart;
            
            $request->session()->put('cart', $cart);
            Alert::success('T-Shirt adicionada!','Foi adicionada a t-shirt ao carrinho!');
            return back();
            
            

        }catch(\Exception $error){
            Alert::error('Não foi possivel adicionar a t-shirt','Ocorreu um erro e não foi possivel adicionar a t-shirt ao carrinho!');
            return back();
        }

    }

    public function updateCart(Request $request): RedirectResponse{

        if (!is_null(Auth::user())){
            $this->authorize('updateCart', TShirts::class);
        }

        $parametros = $request->all();

        // token e metodo
        if(count($parametros) == 2){
            Alert::info('Carrinho vazio!','Não é possivel atualiza-lo');
            return back();
        }

        $cart = session('cart', []);

        if ($request->qty == 0){
            unset($cart[$request->id]);
        }else{
            $cart[$request->id]['color_code'] = $request->color_code;
            $cart[$request->id]['size'] = $request->size;
            $cart[$request->id]['qty'] = $request->qty;
        }

        if (count($cart) > 1){

            for($i = 0; $i < count($cart); $i++){

                if ($i == $request->id)
                    continue;
    
                if ($cart[$i]['tshirt']->id == $cart[$request->id]['tshirt']->id && $cart[$i]['color_code'] == $request->color_code && $cart[$i]['size'] == $request->size){
                    $cart[$i]['qty'] += $request->qty;
    
                    unset($cart[$request->id]);
                }
            }
        }
        

        session()->put('cart', $cart);

        Alert::success('Carrinho atualizado','Detalhes da T-Shirt foram atualizados');
        return back();
    }

    public function store(CheckoutRequest $request): RedirectResponse{

        $this->authorize('createOrder', TShirts::class);

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
                $newOrderItem->tshirt_image_id = $cartItem['tshirt']->id;
                $newOrderItem->color_code = $cartItem['color_code'];
                $newOrderItem->size = $cartItem['size'];
                $newOrderItem->qty = $cartItem['qty'];

                if (is_null($cartItem['tshirt']->customer_id)){

                    // loja
                    if ($cartItem['qty'] >= $precos[0]['qty_discount']){
                        $newOrderItem->unit_price = $precos[0]['unit_price_catalog_discount'];
                    }else{
                        $newOrderItem->unit_price = $precos[0]['unit_price_catalog'];
                    }

                }else{

                    // cliente
                    if ($cartItem['qty'] >= $precos[0]['qty_discount']){
                        $newOrderItem->unit_price = $precos[0]['unit_price_own_discount'];
                    }else{
                        $newOrderItem->unit_price = $precos[0]['unit_price_own'];
                    }
                }

                $newOrderItem->sub_total = $newOrderItem->unit_price * $cartItem['qty'];

                $precoTotal += $newOrderItem->sub_total;

                $newOrderItem->save();

            }

            $newOrder->total_price = $precoTotal;
            $newOrder->save();

            $request->session()->forget('cart');

            $email = new CriadaEncomendaMail($newOrder);

            Mail::to($newOrder->clientes->user->email)->send($email);

            Alert::success('Encomenda criada!','Verifique no seu perfil o estado!');
            return redirect()->route('root');
        }
        
    }

    public function removeFromCart(Request $request, TShirts $t_shirt): RedirectResponse{

        if (!is_null(Auth::user())){
            $this->authorize('removeFromCart', TShirts::class);
        }

        $cart = session('cart', []);
        unset($cart[$request->id]);

        $request->session()->put('cart', $cart);
        Alert::success('Removida com sucesso','A t-shirt foi removida do carrinho!');
        return back();
    }

    public function destroy(Request $request): RedirectResponse
    {

        if (!is_null(Auth::user())){
            $this->authorize('removeCart', TShirts::class);
        }

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
