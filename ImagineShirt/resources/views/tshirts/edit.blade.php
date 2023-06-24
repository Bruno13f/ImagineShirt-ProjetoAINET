@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => 'class = active',
                                        'active3' => '',
                                        'active4' => '']])


@section('titulo',' | Editar T-Shirt')

@section('main')

<!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic" style="background-color:white; margin-bottom: 0px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('root') }}">Página Inicial</a>
                            <a href="{{ route('t-shirts') }}">T-Shirts</a>
                            <a href="{{ route('t-shirts.show', $t_shirt) }}">{{empty($t_shirt->name) ? 'Detalhes T-Shirt' : $t_shirt->name}}</a>
                            <span>Editar</span>
                        </div>
                    </div>
                </div>
                @include('tshirts.shared.fields_img', ['edit' => true])
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                @include('tshirts.shared.fields_fill', ['post' => false])
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->
@endsection