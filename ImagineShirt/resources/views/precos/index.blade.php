@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Gerir Preços')

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
                        <span style = "font-weight: bold;">Gerir Preços</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row mb-5 mt-5 justify-content-md-center" >
    <div class="col-8">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="precos" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Preços Catálogo</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Preço catálogo</th>
                                    <th>Preço cliente</th>
                                    <th>Preço desconto catálogo</th>
                                    <th>Preço desconto cliente</th>
                                    <th>Quantidade necessária para desconto</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($precos) !== 0)
                                    <tr>
                                        <td>{{$precos[0]['unit_price_catalog']}}</td>
                                        <td>{{$precos[0]['unit_price_own']}}</td>
                                        <td>{{$precos[0]['unit_price_catalog_discount']}}</td>
                                        <td>{{$precos[0]['unit_price_own_discount']}}</td>
                                        <td>{{$precos[0]['qty_discount']}}</td>
                                        <td>
                                            <a href="{{ route('precos.edit', $precos[0]['id']) }}">
                                                <button type="button" class="btn btn-info rounded-pill">Editar Preços</button>
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