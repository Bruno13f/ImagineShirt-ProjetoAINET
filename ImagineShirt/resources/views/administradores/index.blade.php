@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Página Administrador')

@section('main')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Perfil - {{$user->name}}</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('root') }}">Página Inicial</a>
                            <span style = "font-weight: bold;">Perfil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    
    <div class="container p-0" style = "margin-top: 50px; margin-bottom: 50px">
        <div class="row">
            <div class="col-md-5 col-xl-4" style = "margin-bottom: 20px">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Definições Perfil {{$tipoUser}}</h5>
                    </div>
                    <div class="list-group list-group-flush" role="tablist">
                    @include('users.shared.fields_tablist', ['usertipo' => $tipoUser, 'allowUpload' => false, 'numencomendas'  => $numencomendas])
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-xl-8">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informação Pessoal</h5>
                            </div>
                            <div class="card-body justify-content-center">
                                @include('users.shared.fields_foto', ['user' => $user, 'allowUpload' => false, 'allowElimPhoto' => false])
                            </div>
                        </div>
                        <div class="card" style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informação Privada</h5>
                            </div>
                            <div class="card-body">
                                @include('users.shared.fields_infpriv', ['user' => $user, 'readonlyData' => true])
                            </div>
                        </div>
                        @can('update', $user)
                        <div class="card" style="margin-top: 20px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 justify-content-center" style = "display:flex">
                                        <a href = "{{ route('user.edit', ['user' => $user]) }}" >
                                            <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Editar</button>   
                                        </a> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Palavra Passe</h5>
                            </div>
                            <div class="row mt-4 mb-4">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('password.change.show') }}">
                                        <button type="button" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">
                                            Alterar Palavra-Passe
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="categorias" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Categorias</h5>
                            </div>
                            <table class="table">
                                    <tbody>
                                        @if($numCategorias != 0)
                                            @foreach($categorias as $categoria)
                                                <tr>
                                                    <td>{{$categoria->name}}</td>
                                                    <td><a href="">
                                                        <button type="button" class="btn btn-primary btn-sm">Editar Categoria</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>Não existem Categorias cridadas</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                        </div>
                        {{ $categorias->links() }}
                    </div>
                    <div class="tab-pane fade" id="precos" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Preços Catálogo</h5>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Preço catálogo</th>
                                        <th>Preço cliente</th>
                                        <th>Preço desconto catálogo</th>
                                        <th>Preço desconto cliente</th>
                                        <th>Quantidade de desconto</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($precos))
                                        <tr>
                                            <td>{{$precos[0]['unit_price_catalog']}}</td>
                                            <td>{{$precos[0]['unit_price_own']}}</td>
                                            <td>{{$precos[0]['unit_price_catalog_discount']}}</td>
                                            <td>{{$precos[0]['unit_price_own_discount']}}</td>
                                            <td>{{$precos[0]['qty_discount']}}</td>
                                            <td>
                                                <a href="">
                                                    <button type="button" class="btn btn-primary btn-sm">Editar Preço</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="6">Não há preços definidos</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection