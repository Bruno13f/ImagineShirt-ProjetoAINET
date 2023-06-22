@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => 'class = active',
                                        'active3' => '',
                                        'active4' => '']])


@section('titulo',' | T-Shirts')

@section('main')

<section class="shop-details">
        <div class="product__details__pic" style="background-color:white; margin-bottom: 0px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('root') }}">Página Inicial</a>
                            <a href="{{ route('t-shirts') }}">T-Shirts</a>
                            <span>Criar T-Shirt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                @include('tshirts.shared.fields_fill', ['post' => true])
            </div>
        </div>
    </section>

@endsection