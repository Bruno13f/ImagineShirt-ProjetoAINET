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

@include('administradores.shared.fields_filtrar', ['encomendas' => true])

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
                                <th scope="col">Numero Encomenda</th>
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
                                        <th scope="row">{{ $encomenda->order_id }}</th>
                                        <td>{{ $encomenda->created  }}</td>
                                        <td><span class="font-weight-bold">{{ $estado }}</span></td>
                                        @can('changeStatus', $encomenda)
                                            @can('isAdmin')
                                                <td>
                                                    <span>{{$encomenda->name}}<span>
                                                    <p><small>{{$encomenda->email}}</small></p>
                                                </td>
                                                <td>
                                                    @if ($estado == 'PENDENTE' || $estado == 'PAGO')
                                                    <form id="form_change_status_{{$encomenda->order_id}}" novalidate class="needs-validation" method="POST"
                                                    action="{{ route('encomendas.changeStatus', $encomenda->order_id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                        <input type="hidden" name="status" value="{{$alterarEstado}}">
                                                        <button type="submit" name="ok" form="form_change_status_{{$encomenda->order_id}}" class="btn btn-{{$btnAlterar}} rounded-pill"><span>{{$alterarEstado}}</span></button>
                                                    </form>
                                                    @endif
                                                
                                                    @if($estado != 'ANULADO')
                                                    <form id="form_cancelar_{{$encomenda->order_id}}" novalidate class="needs-validation" method="POST"
                                                    action="{{ route('encomendas.changeStatus', $encomenda->order_id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                        <input type="hidden" name="status" value="canceled">
                                                        <button type="submit" name="ok" form="form_cancelar_{{$encomenda->order_id}}" class="btn btn-danger rounded-pill mt-2"><span>Anular</span></button>
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
                                                    <form id="form_change_status_{{$encomenda->order_id}}" novalidate class="needs-validation" method="POST"
                                                    action="{{ route('encomendas.changeStatus', $encomenda) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                        <input type="hidden" name="status" value="{{$alterarEstado}}">
                                                        <button type="submit" name="ok" form="form_change_status_{{$encomenda->order_id}}" class="btn btn-{{$btnAlterar}} rounded-pill"><span>{{$alterarEstado}}</span></button>
                                                    </form>
                                                @endif
                                                </td>
                                            @endcan
                                        @endcan
                                        <td>{{ $encomenda->total_price }} €</td>
                                        <td>
                                        @if($encomenda->status == 'closed' || $encomenda->status == 'canceled')
                                        <a href="{{ route('encomendas.pdf', $encomenda->order_id) }}"><button type="button" class="btn btn-info rounded-pill"><span>Descarregar PDF</span></button></a>
                                        @endif
                                        <a href="{{ route('encomendas.show', $encomenda->order_id) }}"><button type="button" class="btn btn-info rounded-pill"><span>Detalhes</span></button></a>
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