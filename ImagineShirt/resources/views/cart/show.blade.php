@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Carrinho')

@section('main')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Carrrinho</h4>
                        <div class="breadcrumb__links">
                            <a href="{{route('root')}}">Página Inicial</a>
                            <a href="{{route('t-shirts')}}">T-Shirts</a>
                            <span>Carrrinho</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                @if(!empty($cart))
                <div class="col-lg-12">
                    <!-- <form id="formUpdate" method="POST" action="{{ route('cart.update') }}">
                    @csrf
                    @method('PUT') -->
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Tamanho</th>
                                    <th>Cor</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $precoTotal = 0;
                                    $num_cliente_disc = 0;
                                    $num_loja_disc = 0;
                                    $counter = 0;
                                @endphp

                                @foreach ($cart as $cartItem)

                                <form id="formAddTshirt_{{$cartItem[0]->id}}_{{$cartItem[1]}}_{{$cartItem[2]}}_{{$cartItem[3]}}" method="POST" action="{{ route('cart.update')}}">
                                @csrf
                                @method('PUT')
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <div class="container-tshirt-img-cart" style="background-color:#{{$cartItem[1]}}">
                                                <img class="imgCartTShirt" src="{{empty($cartItem[0]->customer_id) ? '/storage/tshirt_images/'.$cartItem[0]->image_url : route('imagem_user', ['image_url' => $cartItem[0]->image_url, 'user_id' => $cartItem[0]->customer_id, 'nome_tshirt' => $cartItem[0]->name])}}" 
                                                width="128" height="128" alt="">
                                            </div>
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$cartItem[0]->name}}</h6>
                                            @php
                                                $preco = empty($cartItem[0]->customer_id) ? $precos[0]['unit_price_catalog'] : $precos[0]['unit_price_own'];
                                            @endphp
                                            <h5>{{$preco}} €</h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2">
                                                <input name="qty" id="quantidade" type="text" value="{{$cartItem[3]}}">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="" name="size" id="inputSize">
                                                @foreach($tamanhos as $tamanho)
                                                    <option value="{{$tamanho}}" {{$tamanho == $cartItem[2] ? 'selected' : '' }}>{{$tamanho}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                    <div class="form-group">
                                        <select class="" name="color_code" id="inputColorCode">
                                            @foreach ($cores as $cor)
                                                <option value="{{$cor->code}}" {{$cor->code == $cartItem[1] ? 'selected' : '' }}>{{$cor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </td>
                                    <input type="hidden" value="{{$counter}}" name="id">
                                    <td class="cart__price">{{$preco * $cartItem[3]}} €</td>
                                    <td class="cart__close"><button type="submit" name="ok" form="formAddTshirt_{{$cartItem[0]->id}}_{{$cartItem[1]}}_{{$cartItem[2]}}_{{$cartItem[3]}}" class="btn rounded-pill"><i class="fa fa-refresh" aria-hidden="true"></i></button></td>
                                    </form>
                                    <form id="formDeleteTshirt_{{$cartItem[0]->id}}_{{$cartItem[1]}}_{{$cartItem[2]}}_{{$cartItem[3]}}" method="POST" action="{{ route('cart.remove', $cartItem[0]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" value="{{$counter}}" name="id">
                                    <td class="cart__close"><button type="submit" name="clear" form="formDeleteTshirt_{{$cartItem[0]->id}}_{{$cartItem[1]}}_{{$cartItem[2]}}_{{$cartItem[3]}}" class="btn rounded-pill"><i class="fa fa-close"></i></button></td>
                                    </form>
                                </tr>
                                @php
                                    $counter += 1;
                                    $precoTotal += $preco * $cartItem[3];
                                
                                    if (is_null($cartItem[0]->customer_id) && $cartItem[3] >= $precos[0]['qty_discount']){
                                        $num_loja_disc += $cartItem[3];
                                    }else

                                    if (!is_null($cartItem[0]->customer_id) && $cartItem[3] >= $precos[0]['qty_discount']){
                                        $num_cliente_disc += $cartItem[3];
                                    }

                                @endphp
                                @endforeach

                                @php
                                    $descontoLoja = $precos[0]['unit_price_catalog'] - $precos[0]['unit_price_catalog_discount'];
                                    $descontoCliente = $precos[0]['unit_price_own'] - $precos[0]['unit_price_own_discount'];
                                    $desconto = ($num_loja_disc * $descontoLoja)+($num_cliente_disc * $descontoCliente);
                                @endphp
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><span class="font-weight-bold h6">Preço Sem Desconto</span></td>
                                    <td><span class="font-weight-bold h6">{{$precoTotal}} €</span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="font-weight-bold h6">Desconto</td>
                                    <td><span class="font-weight-bold h6">{{$desconto}} €</span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="font-weight-bold h5">Preço Total</td>
                                    <td><span class="font-weight-bold h5">{{$precoTotal - $desconto}} €</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 d-flex justify-content-start" style="align-items: center">
                                <button type="button" form="formUpdate" name="ok" class="btn btn-dark btn-square btn-lg rounded-0 d-flex justify-content-center" style="background-color:black"
                    onclick="document.forms[{{is_null(Auth::user()) ? '0' : '2'}}].submit()">
                                <span class="carrinhoBtn">Atualizar Carrinho</span>
                                </button>
                        </div>
                        <!-- </form> -->
                        <div class="col-lg-4 col-md-4 col-sm-4 d-flex justify-content-center" style="align-items: center">
                            <form id="formDeleteCart" method="POST" action="{{ route('cart.destroy') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" form="formDeleteCart" name="clear" class="btn btn-dark btn-square btn-lg rounded-0 d-flex justify-content-center" style="background-color:black">
                                <span class="carrinhoBtn">Eliminar Carrinho</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 d-flex justify-content-end" style="align-items: center">
                            <a href="{{route('cart.checkout')}}"><button type="submit" form="formStore" name="ok" class="btn btn-dark btn-square btn-lg rounded-0 d-flex justify-content-center" style="background-color:black">
                                <span class="carrinhoBtn">Confirmar Carrinho</span>
                            </button></a>
                        </div>
                    </div>
                </div>
                @else
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 d-flex justify-content-center">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            Carrinho vazio</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

@endsection