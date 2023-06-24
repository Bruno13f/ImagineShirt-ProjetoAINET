@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Checkout')

@section('main')

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Checkout</h4>
                    <div class="breadcrumb__links">
                        <a href="{{route('root')}}">Página Inicial</a>
                        <a href="{{route('t-shirts')}}">T-Shirts</a>
                        <a href="{{route('cart.show')}}">Carrinho</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <form id="formStore" method="POST" action="{{ route('cart.store') }}">
                    @csrf
                    @method('POST')
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <h6 class="checkout__title">Detalhes Envio</h6>
                        <div class="form-group">
                            <label for="inputNif">NIF</label>
                            <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif" value = "{{ old('nif', $user->cliente->nif )}}">
                            @error('nif')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Morada</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress" value = "{{ old('address', $user->cliente->address) }}">
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Notas</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="notas" id="inputNotas" value = "{{ old('notas') }}">
                            @error('notas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="inputRef">Referência de Pagamento</label>
                                <input type="text" class="form-control @error('default_payment_ref') is-invalid @enderror" name="default_payment_ref" id="inputRef" value="{{ old('default_payment_ref', $user->cliente->default_payment_ref)}}">
                                @error('default_payment_ref')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group" style="display:flex; align-items: center;">
                                <span>Método de Pagamento</span>
                            </div>
                            <div class="form-group" style="display:flex; align-items: center;">
                                <select class="@error('default_payment_type') is-invalid @enderror" name="default_payment_type" id="inputMetodoPagamento">
                                    <option {{empty($user->cliente->default_payment_type) ? 'selected' : ''}}></option>
                                    <option value="PAYPAL" {{ old('default_payment_type', $user->cliente->default_payment_type) === 'PAYPAL' ? 'selected' : ''}}>Paypal</option>
                                    <option value="MC" {{ old('default_payment_type', $user->cliente->default_payment_type) === 'MC' ? 'selected' : ''}}>Mastercard</option>
                                    <option value="VISA" {{ old('default_payment_type', $user->cliente->default_payment_type)  === 'VISA' ? 'selected' : ''}}>Visa</option>
                                </select>
                                @error('default_payment_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4 class="order__title">Resumo</h4>
                            <div class="checkout__order__products">T-Shirts<span>Total</span></div>
                            <ul class="checkout__total__products">
                                @php
                                    $precoTotal = 0;
                                    $num_cliente_disc = 0;
                                    $num_loja_disc = 0;
                                    $counter = 0
                                @endphp

                                @foreach($cart as $cartItem)
                                    @php 
                                        $preco = empty($cartItem['tshirt']->customer_id) ? $precos[0]['unit_price_catalog'] : $precos[0]['unit_price_own'];
                                        $counter += 1
                                    @endphp
                                    <li>0{{$counter}}. {{$cartItem['tshirt']->name}}<span>{{$preco * $cartItem['qty']}} €</span></li>
                                    @php
                                        $precoTotal += $preco * $cartItem['qty'];
                                    
                                        if (is_null($cartItem['tshirt']->customer_id) && $cartItem['qty'] >= $precos[0]['qty_discount']){
                                            $num_loja_disc += $cartItem['qty'];
                                        }else

                                        if (!is_null($cartItem['tshirt']->customer_id) && $cartItem['qty'] >= $precos[0]['qty_discount']){
                                            $num_cliente_disc += $cartItem['qty'];
                                        }
                                    @endphp
                                @endforeach
                            </ul>
                            @php
                                $descontoLoja = $precos[0]['unit_price_catalog'] - $precos[0]['unit_price_catalog_discount'];
                                $descontoCliente = $precos[0]['unit_price_own'] - $precos[0]['unit_price_own_discount'];
                                $desconto = ($num_loja_disc * $descontoLoja)+($num_cliente_disc * $descontoCliente);
                            @endphp
                            <ul class="checkout__total__all">
                                <li>Total Sem Desconto<span>{{$precoTotal}} €</span></li>
                                <li>Desconto<span>{{$desconto}} €</span></li>
                                <li>Total<span>{{$precoTotal - $desconto}} €</span></li>
                            </ul>
                            <button type="submit" name="ok" form="formStore" class="site-btn">ENCOMENDAR</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
    <!-- Checkout Section End -->
@endsection