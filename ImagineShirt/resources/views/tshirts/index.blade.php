@extends('template.layout', ['dados' => ['titulo' => ' | T-Shirts', 
                                        'active1' => '',
                                        'active2' => 'class = active',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('main')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Loja</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('root') }}">Página Inicial</a>
                            <span style = "font-weight: bold;">T-Shirts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Pesquisar...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categorias</a>
                                    </div>
                                    <div id="collapseOne" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    <li><a 
                                                        @if (!str_contains(request()->fullUrl(),'categoria'))
                                                            style = "color:black; font-weight: bold;"
                                                        @endif                                                    
                                                        href="{{route('t-shirts',request()->except('categoria'))}}">Todas
                                                    </a></li>
                                                    @foreach ($categorias as $categoria)
                                                        <li><a 
                                                        @if (request()->query('categoria') === $categoria)
                                                            style = "color:black; font-weight: bold;"
                                                        @endif  
                                                        href="{{request()->fullUrlWithQuery(['categoria' => $categoria, 'pagina' => '1'])}}">{{ $categoria }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Filtrar Preço</a>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="#">0.00€ - 10.00€</a></li>
                                                    <li><a href="#">10.00€- 15.00€</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Ordenar: </p>
                                        <select id="ordenar" onchange="updateQuery()" name="ordenar">
                                            <option {{ old('ordenar', $ordenarFiltro) == 'padrao' ? 'selected' : '' }} value="padrao">Padrão</option>
                                            <option {{ old('ordenar', $ordenarFiltro) == 'name_asc' ? 'selected' : '' }} value="name_asc">Nome (Ascendente)</option>
                                            <option {{ old('ordenar', $ordenarFiltro) == 'name_desc' ? 'selected' : '' }} value="name_desc">Nome (Descendente)</option>
                                            <option {{ old('ordenar', $ordenarFiltro) == 'preco_asc' ? 'selected' : '' }} value="preco_asc">Preço Baixo ao Alto</option>
                                            <option {{ old('ordenar', $ordenarFiltro) == 'preco_desc' ? 'selected' : '' }} value="preco_desc">Preço Alto ao baixo</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($tshirts as $tshirt)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="/storage/tshirt_images/{{ $tshirt->image_url}}" style = "background-size: contain">
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ empty($tshirt->name) ? 'T-Shirt Sem Nome' : $tshirt->name }}</h6>
                                    <a href="#" class="add-cart">Adicionar ao Carrinho</a>
                                    <div class="rating">
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <h5>
                                    @if(is_null($tshirt->customer_id))
                                        {{$precos['unit_price_catalog']}}
                                    @else
                                        {{$precos['unit_price_own']}}
                                    @endif
                                    €
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        {{ $tshirts->withQueryString()->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
    <script>
        function updateQuery (){
            let query = window.location.search;  // parametros url
            let parametros = new URLSearchParams(query);
            parametros.delete('ordenar');  // se ja existir delete
            parametros.append('ordenar', document.getElementById("ordenar").value); // adicionar ordenação
            document.location.href = "?" + parametros.toString(); // refresh
        }
    </script>
@endsection