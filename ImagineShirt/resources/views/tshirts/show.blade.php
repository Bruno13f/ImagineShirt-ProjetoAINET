@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => 'class = active',
                                        'active3' => '',
                                        'active4' => '']])


@section('titulo',' | T-Shirts')

@section('main')

<!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('root') }}">Página Inicial</a>
                            <a href="{{ route('t-shirts') }}">T-Shirts</a>
                            <span>{{ empty($tshirt->name) ? 'Detalhes T-Shirt' : $tshirt->name}}</span>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-lg-5 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img style="max-width: 300px; height: auto;" src="/storage/tshirt_images/{{$tshirt->image_url}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ empty($tshirt->name) ? 'T-Shirt Sem Nome' : $tshirt->name }}</h4>
                            <div class="rating">
                            </div>
                            <h3>{{$tshirt->price}}<!-- DESCONTO <span>70.00</span>--></h3> 
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Tamanho:</span>
                                    <label for="xsm">xs
                                        <input type="radio" id="xsm">
                                    </label>
                                    <label for="sm">s
                                        <input type="radio" id="sm">
                                    </label>
                                    <label for="m">m
                                        <input type="radio" id="m">
                                    </label>
                                    <label for="l">l
                                        <input type="radio" id="l">
                                    </label>
                                    <label class="radio" for="xl">xl
                                        <input type="radio" id="xl">
                                    </label>
                                </div>
                            </div>
                            <div class="product__details__option">
                                <div class="product__details__option__color" style = "max-width: 550px; overflow-x: auto">
                                    <span>Cores:</span>
                                    @foreach($cores as $cor)
                                        <label class = "c-1" for="{{$cor->name}}" style="background-color: #{{$cor->code}}">
                                            <input type="radio" title="{{$cor->name}}">
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                                <a href="#" class="primary-btn">Adicionar ao Carrinho</a>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Checkout Seguro</span></h5>
                                <img src="{{ asset('img/payment.png')}} " alt="">
                                <ul>
                                    <li><h6 style="font-weight: bold;">Categoria: {{ empty($categoria[0]) ? 'Sem Categoria' : $categoria[0] }}</h6></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" style="font-size: 1.6rem;" data-toggle="tab" href="#tabs-5"
                                    role="tab">Descrição</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">{{ $tshirt->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

@endsection