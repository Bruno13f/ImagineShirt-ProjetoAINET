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

<div class="row mb-5 mt-5 justify-content-md-center" >
    <div class="col-10">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="encomendas" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Encomendas</h5>
                    </div>
                    <div class="card-body">
                        @if (count($encomendas) != 0)
                        <table class="table table-hover table-bordered table-light">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">Encomenda Numero</th>
                                @can('isAdmin')
                                    <th scope="col">Cliente</th>
                                @endcan
                                <th scope="col">Data</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Preço</th>
                                @can('isAdmin')
                                    <th>Alterar Estado</th>
                                @endcan
                                @can('isFuncionario')
                                    <th>Alterar Estado</th>
                                @endcan
                                <th>Detalhes</th>
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
                                        $estado = 'CANCELADO';
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
                                        @can('isAdmin')
                                            <td>Cliente</th>
                                        @endcan
                                        <td>{{ $encomenda->date }}</th>
                                        <td><span class="font-weight-bold">{{ $estado }}</span></td>
                                        <td>{{ $encomenda->total_price }}€</td>
                                        @can('isAdmin')
                                            <td>
                                                @if ($estado == 'PENDENTE' || $estado == 'PAGO')
                                                    <button type="button" class="btn btn-{{$btnAlterar}} rounded-pill"><span>{{$alterarEstado}}</span></button>
                                                @endif
                                            
                                                @if($estado != 'CANCELADO')
                                                    <button type="button" class="btn btn-danger rounded-pill"><span>Cancelar</span></button>
                                                @else
                                                    <button type="button" class="btn btn-info rounded-pill"><span>Estado inalterável</span></button>
                                                @endif
                                            </td>
                                        @endcan
                                        @can('isFuncionario')
                                            <td>
                                                @if ($estado == 'Pendente' || $estado == 'Pago')
                                                    <button type="button" class="btn btn-{{$btnAlterar}} rounded-pill"><span>{{$alterarEstado}}</span></button>
                                                @endif
                                            </td>
                                        @endcan
                                        <td>A fazer</td>
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