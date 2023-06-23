@extends('template.layout', ['dados' => ['active1' => 'class = active',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('main')
    @if (session('alert-msg'))
    <div class="row justify-content-center" style="margin-top: 20px">
        <div class="col-lg-6">
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
                {{ session('alert-msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Nova Coleção!</h6>
                                <h2>Coleção Primavera - Verão</h2>
                                <p>Comprometidos em oferecer uma experiência de compra única e inesquecível. 
                                Com a maior atenção ao detalhe.</p>
                                <a href="{{ route('t-shirts') }}" class="primary-btn">Catálogo <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="img/hero/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Nova Novidade!</h6>
                                <h2>Poderá personalizar T-Shirts ao seu gosto!</h2>
                                <p>De modo a providenciar uma interação mais próxima com o cliente.
                                Nunca colocando os nossos altos padrões de qualidade em causa.</p>
                                <a href="#" class="primary-btn">Customizar <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-1.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Coleção Verão</h2>
                            <a href="{{ route('t-shirts') }}">Catálogo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul id = "listaFiltros" name="filtro" class="filter__controls">
                        <li id="populares" class="active" data-filter=".populares">Populares</li>
                        <li id="recentes" data-filter=".recentes">Recentes</li>
                        <li id="tshirtsmaisVendidas" data-filter=".tshirtsmaisVendidas">Mais vendidos</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter populares">
                <!-- Product Section End Populares-->
                @forelse ($populares as $popular)
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix">
                    <div class="product__item">
                        <div class="rounded" style="background-color: #D3D3D3">
                            <a href="{{ route('t-shirts.show', $popular)}}">
                                <div class="product__item__pic set-bg" data-setbg="/storage/tshirt_images/{{ $popular->image_url}}" style = "background-size: contain">
                                </div>
                            </a>
                        </div>
                        <div class="product__item__text">
                            <h6 style = "font-size: 1.2rem;font-weight: bolder">{{ empty($popular->name) ? 'T-Shirt Sem Nome' : $popular->name }}</h6>
                            <a href="#" class="add-cart" style="font-size: 1.1rem">+ Adicionar ao Carrinho</a>
                            <h5>{{$precoLoja->unit_price_catalog}} €</h5>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-lg-9" style="text-align:center"><h6 style = "font-size: 1rem;font-weight: bolder;">Não foi encontrada nenhuma T-Shirt</h6></div>    
                @endforelse
            </div>

            <div class="row product__filter recentes" style="display:none">
                @forelse ($recentes as $recente)
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix">
                     <div class="product__item">
                        <div class="rounded" style="background-color: #D3D3D3">
                            <a href="{{ route('t-shirts.show', $recente)}}">
                                <div class="product__item__pic set-bg" data-setbg="/storage/tshirt_images/{{ $recente->image_url}}" style = "background-size: contain">
                                    <span class="label" style = "color: red">Novo</span>
                                </div>
                            </a>
                        </div>
                        <div class="product__item__text">
                            <h6 style = "font-size: 1.2rem;font-weight: bolder">{{ empty($recente->name) ? 'T-Shirt Sem Nome' : $recente->name }}</h6>
                             <a href="#" class="add-cart" style="font-size: 1.1rem">+ Adicionar ao Carrinho</a>
                            <h5>{{$precoLoja->unit_price_catalog}} €</h5>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-lg-9" style="text-align:center"><h6 style = "font-size: 1rem;font-weight: bolder;">Não foi encontrada nenhuma T-Shirt</h6></div>
                @endforelse
            </div>

            <div class="row product__filter tshirtsmaisVendidas" style="display:none">
                @forelse ($tshirtsmaisVendidas as $maisVendido)
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix">
                    <div class="product__item">
                        <div class="rounded" style="background-color: #D3D3D3">
                            <a href="{{ route('t-shirts.show', $maisVendido)}}">
                                <div class="product__item__pic set-bg" data-setbg="/storage/tshirt_images/{{ $maisVendido->image_url}}" style = "background-size: contain">
                                    <span class="label" style = "color: red">Hot</span>
                                </div>
                            </a>
                        </div>
                        <div class="product__item__text">
                            <h6 style = "font-size: 1.2rem;font-weight: bolder">{{ empty($maisVendido->name) ? 'T-Shirt Sem Nome' : $maisVendido->name }}</h6>
                            <a href="#" class="add-cart" style="font-size: 1.1rem">+ Adicionar ao Carrinho</a>
                            <h5>{{$precoLoja->unit_price_catalog}} €</h5>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-lg-9" style="text-align:center"><h6 style = "font-size: 1rem;font-weight: bolder;">Não foi encontrada nenhuma T-Shirt</h6></div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
