@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Encomendas')

@section('main')
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Perfil - {{$user->name}}</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('root') }}">Página Inicial</a>
                        <a href="{{ route('user', $user) }}">Perfil</a>
                        <span style = "font-weight: bold;">Encomendas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row d-flex">
    <div class="col-1"></div>
    <div class="col-3 mt-5 mb-0 align-middle">
        <div class="shop__sidebar__search">
            <form method="GET" id="pesquisa-form">
                <input id = "pesquisa" type="text" maxlength="50" name="pesquisa" value = "" placeholder="Pesquisar...">
                <button type="submit"><span class="icon_search"></span></button>
            </form>
        </div>
    </div>
    <div class="col-4 mt-5 mb-0 align-middle">
        <div class="shop__product__option">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="shop__product__option__left">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="shop__product__option__right">
                        <p>Selecionar: </p>
                        <select id="selecionar" name="selecionar">
                            <option value="">Todas</option>
                            <option value="">Pendente</option>
                            <option value="">Paga</option>
                            <option value="">Fechada</option>
                            <option value="">Anulada</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 mt-5 mb-0 align-middle">
        <div class="shop__product__option">
            <div class="row d-flex justify-content-end">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="shop__product__option__right">
                        <p>Ordernar: </p>
                        <select id="ordenar" name="ordenar">
                            <option value="">Mais Recente</option>
                            <option value="">Mais Antigo</option>
                            <option value="">Paga</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-1"></div>
</div>

<div class="row mb-5 mt-2 justify-content-md-center" >
    <div class="col-10">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="encomendas" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <h5 class="card-title mb-0">Encomendas</h5>
                    </div>
                    <div class="card-body">
                        @if (count($encomendas) != 0)
                        <table class="table table-hover table-bordered table-light">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">Encomenda Numero</th>
                                <th scope="col">Data</th>
                                <th scope="col">Estado</th>
                                @can('isAdmin')
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Alterar Estado</th>
                                @endcan
                                @can('isFuncionario')
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Alterar Estado</th>
                                @endcan
                                <th scope="col">Preço</th>
                                <th scope="col">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($encomendas as $encomenda)

                                @php    
                                switch($encomenda->status){
                                    case 'closed':
                                        $btn = 'dark';
                                        $estado = 'FECHADO';
                                        $alterarEstado='';
                                        break;
                                    case 'canceled':
                                        $btn = 'danger';
                                        $estado = 'ANULADO';
                                        $alterarEstado='';
                                        break;
                                    case 'pending':
                                        $btn = 'warning';
                                        $estado = 'PENDENTE';
                                        $btnAlterar = 'success';
                                        $alterarEstado = 'Pagar';
                                        break;
                                    case 'paid':
                                        $btn = 'success';
                                        $estado = "PAGO";
                                        $btnAlterar = 'dark';
                                        $alterarEstado = 'Fechar';
                                        break;
                                }
                                @endphp
                                
                                    <tr>
                                        <th scope="row">{{ $encomenda->id }}</th>
                                        <td>{{ $encomenda->date }}</td>
                                        <td><span class="font-weight-bold">{{ $estado }}</span></td>
                                        @can('changeStatus', $encomenda)
                                            @can('isAdmin')
                                                <td>
                                                    <span>{{$encomenda->clientes->user->name}}<span>
                                                    <p><small>{{$encomenda->clientes->user->email}}</small></p>
                                                </td>
                                                <td>
                                                    @if ($estado == 'PENDENTE' || $estado == 'PAGO')
                                                    <form id="form_change_status_{{$encomenda->id}}" novalidate class="needs-validation" method="POST"
                                                    action="{{ route('encomendas.changeStatus', $encomenda) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                        <input type="hidden" name="status" value="{{$alterarEstado}}">
                                                        <button type="submit" name="ok" form="form_change_status_{{$encomenda->id}}" class="btn btn-{{$btnAlterar}} rounded-pill"><span>{{$alterarEstado}}</span></button>
                                                    </form>
                                                    @endif
                                                
                                                    @if($estado != 'ANULADO')
                                                    <form id="form_cancelar_{{$encomenda->id}}" novalidate class="needs-validation" method="POST"
                                                    action="{{ route('encomendas.changeStatus', $encomenda) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                        <input type="hidden" name="status" value="canceled">
                                                        <button type="submit" name="ok" form="form_cancelar_{{$encomenda->id}}" class="btn btn-danger rounded-pill mt-2"><span>Anular</span></button>
                                                    </form>
                                                    @else
                                                        <button type="button" class="btn btn-info rounded-pill"><span>Estado inalterável</span></button>
                                                    @endif
                                                </td>
                                            @endcan
                                            @can('isFuncionario')
                                                <td>
                                                    <span>{{$encomenda->name}}<span>
                                                    <p><small>{{$encomenda->email}}</small></p>
                                                </td>
                                                <td>
                                                @if ($estado == 'PENDENTE' || $estado == 'PAGO')
                                                    <form id="form_change_status_{{$encomenda->id}}" novalidate class="needs-validation" method="POST"
                                                    action="{{ route('encomendas.changeStatus', $encomenda) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                        <input type="hidden" name="status" value="{{$alterarEstado}}">
                                                        <button type="submit" name="ok" form="form_change_status_{{$encomenda->id}}" class="btn btn-{{$btnAlterar}} rounded-pill"><span>{{$alterarEstado}}</span></button>
                                                    </form>
                                                @endif
                                                </td>
                                            @endcan
                                        @endcan
                                        <td>{{ $encomenda->total_price }} €</td>
                                        <td>
                                        @if($encomenda->status != 'pending')
                                        <a href="{{ route('encomendas.pdf', $encomenda) }}"><button type="button" class="btn btn-info rounded-pill"><span>Descarregar PDF</span></button></a>
                                        @endif
                                        <a href="{{ route('encomendas.show', $encomenda->id) }}"><button type="button" class="btn btn-info rounded-pill"><span>Detalhes</span></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <span>Não foram encontradas encomendas.</span>
                        @endif
                    </div>
                </div>
                {{ $encomendas->links() }}
            </div>
        </div>
    </div>
</div>

@endsection