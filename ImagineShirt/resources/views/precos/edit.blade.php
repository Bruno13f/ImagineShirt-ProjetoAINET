@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Editar Categoria')

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
                        <a href="{{ route('user', $user) }}">Gerir Preços</a>
                        <span style = "font-weight: bold;">Editar Preços</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container p-0" style = "margin-top: 50px; margin-bottom: 50px">
    <div class="row justify-content-center">
        <div class="col-md-7 col-xl-8">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="account" role="tabpanel">
                    <div class="card" style="margin-top: 20px">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Editar Preços</h5>
                        </div>
                        <form id="form_preco" novalidate class="needs-validation" method="POST"
                        action="{{ route('precos.update', $precos['id']) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputPrecoCatalogo">Preço Catálogo</label>
                                <input type="text" class="form-control @error('precoCatalogo') is-invalid @enderror" name="precoCatalogo" id="inputPrecoCatalogo" value = "{{ old('precoCatalogo', $precos['unit_price_catalog']) }}">
                                @error('precoCatalogo')
                                    <div class="invalid-feedback">
                                        {{ $message }} 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPrecoCatalogoDisc">Preço Catálogo Desconto</label>
                                <input type="text" class="form-control @error('precoCatalogoDisc') is-invalid @enderror" name="precoCatalogoDisc" id="inputPrecoCatalogoDisc" value = "{{ old('precoCatalogoDisc', $precos['unit_price_catalog_discount']) }}">
                                @error('precoCatalogoDisc')
                                    <div class="invalid-feedback">
                                        {{ $message }} 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPrecoCliente">Preço Cliente T-Shirt</label>
                                <input type="text" class="form-control @error('precoCliente') is-invalid @enderror" name="precoCliente" id="inputPrecoCliente" value = "{{ old('precoCliente', $precos['unit_price_own']) }}">
                                @error('precoCliente')
                                    <div class="invalid-feedback">
                                        {{ $message }} 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPrecoClienteDisc">Preço Cliente T-Shirt Desconto</label>
                                <input type="text" class="form-control @error('precoClienteDisc') is-invalid @enderror" name="precoClienteDisc" id="inputPrecoClienteDisc" value = "{{ old('precoClienteDisc', $precos['unit_price_own_discount']) }}">
                                @error('precoClienteDisc')
                                    <div class="invalid-feedback">
                                        {{ $message }} 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputQuantDesc">Quantidade Desconto</label>
                                <input type="text" class="form-control @error('quantDesc') is-invalid @enderror" name="quantDesc" id="inputQuantDesc" value = "{{ old('quantDesc', $precos['qty_discount']) }}">
                                @error('quantDesc')
                                    <div class="invalid-feedback">
                                        {{ $message }} 
                                    </div>
                                @enderror
                            </div>
                            <!-- <input type="hidden" name="code_valid" value="validate('transparent')"> -->
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 justify-content-center" style = "display:flex">
                                        <a href=""> 
                                            <button type="submit" name="ok" form="form_preco" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">
                                            Guardar Alterações</button>   
                                        </a>
                                    </div> 
                                    </form>
                                    <div class="col-md-6 justify-content-center" style = "display:flex">
                                        <a href="{{ route('user', $user) }}"> 
                                            <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Cancelar</button>   
                                        </a>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection