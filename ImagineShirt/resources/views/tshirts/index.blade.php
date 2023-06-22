@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => 'class = active',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | T-Shirts')

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
                            <form method="GET" id="pesquisa-form">
                                <input id = "pesquisa" type="text" maxlength="50" name="pesquisa" value = "{{old('pesquisa', $pesquisaFiltro)}}" placeholder="Pesquisar...">
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
                                                <ul style="overflow-y:auto">
                                                    <li><a 
                                                        @if (!str_contains(request()->fullUrl(),'categoria'))
                                                            style = "color:black; font-weight: bold;"
                                                        @endif                                                    
                                                        href="{{route('t-shirts',request()->except('categoria'))}}">Todas
                                                    </a></li>
                                                    @can('viewMinhas', \App\Models\TShirts::class)
                                                        <li><a 
                                                        @if (request()->query('categoria') === 'user')
                                                            style = "color:black; font-weight: bold;"
                                                        @endif  
                                                        href="{{request()->fullUrlWithQuery(['categoria' => 'user', 'pagina' => '1'])}}">Próprias T-Shirts</a></li>
                                                    @endcan

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
                                @can('create', App\Models\TShirts::class)
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <a href=""><button type="button" class="btn btn-success">Criar T-Shirt</button></a>
                                    </div>
                                </div>
                                @endcan
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
                                            <option {{ old('ordenar', $ordenarFiltro) == 'rec_desc' ? 'selected' : '' }} value="rec_desc">Mais Recente</option>
                                            <option {{ old('ordenar', $ordenarFiltro) == 'rec_asc' ? 'selected' : '' }} value="rec_asc">Mais Antigo</option>
                                            <option {{ old('ordenar', $ordenarFiltro) == 'name_asc' ? 'selected' : '' }} value="name_asc">Nome (Ascendente)</option>
                                            <option {{ old('ordenar', $ordenarFiltro) == 'name_desc' ? 'selected' : '' }} value="name_desc">Nome (Descendente)</option>

                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($tshirts as $tshirt)
                        <div class="col-lg-4 col-md-6 col-sm-6" style="margin-top: 20px">
                            <div class="product__item">
                                <a href="{{ route('t-shirts.show', $tshirt->slug)}}">
                                    <div class="product__item__pic set-bg" data-setbg="
                                    {{ empty($tshirt->customer_id) ? "/storage/tshirt_images/{$tshirt->image_url}" : route('imagem_user', ['image_url' => $tshirt->image_url, 'user_id' => $tshirt->customer_id, 'nome_tshirt' => $tshirt->name])}}
                                    " style = "background-size: contain; background-color: #d9d9d9; border-radius: 15%">   
                                    </div>
                                </a> 
                                <div class="product__item__text">
                                    <h6 style = "font-size: 1.2rem;font-weight: bolder">{{ empty($tshirt->name) ? 'T-Shirt Sem Nome' : $tshirt->name }}</h6>
                                    <a href="#" class="add-cart" style="font-size: 1.1rem">+ Adicionar ao Carrinho</a>
                                    <p style="opacity: 0.8;">{{ empty($tshirt->description) ? 'Sem Descrição' : $tshirt->description }}</p>
                                    <h5>{{$precos['unit_price_catalog']}} €</h5>
                                </div>
                            </div>
                            
                                <div style = "display: flex; justify-content: space-evenly">
                                @can('update', $tshirt)
                                    <a href="{{route('t-shirts.edit', $tshirt)}}"><button type="button" class="btn btn-success">Editar</button></a>
                                @endcan
                                @can('delete', $tshirt)
                                    <a href="" style = "margin-bottom: 10px"><button type="button" class="btn btn-danger">Eliminar</button></a>
                                @endcan
                                </div>
                            
                        </div>
                        @empty
                            <div class="col-lg-9" style="text-align:center"><h6 style = "font-size: 1rem;font-weight: bolder;">Não foi encontrada nenhuma T-Shirt</h6></div>
                        @endforelse
                    </div>
                    <div class="row" style = "margin-top: 40px">
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
    let formpesquisa =  document.getElementById('pesquisa-form');   
    if (formpesquisa){
        document.getElementById('pesquisa-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Impede o envio do formulário

        var form = this;
        var url = new URL(window.location.href);
        var pesquisa = form.elements.pesquisa.value;
        // reset pagina
        url.searchParams.set('pagina', '1');

        if (pesquisa) {
            url.searchParams.set('pesquisa', pesquisa);
        } else {
            url.searchParams.delete('pesquisa');
        }

        window.location.href = url.href;
        });
    }
    

    function updateQuery (){
        let query = window.location.search;  // parametros url
        let parametros = new URLSearchParams(query);
        parametros.delete('ordenar');  // se ja existir delete
        parametros.append('ordenar', document.getElementById("ordenar").value); // adicionar ordenação
        document.location.href = "?" + parametros.toString(); // refresh
    }

    </script>
@endsection