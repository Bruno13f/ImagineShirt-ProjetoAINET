@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Editar Cor')

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
                        <a href="{{ route('user', $user) }}">Perfil</a>
                        <a href="{{ route('user.gerirCores', $user) }}">Gerir Cores</a>
                        <span style = "font-weight: bold;">Editar Cor</span>
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
                            <h5 class="card-title mb-0">Editar Cor</h5>
                        </div>
                        <form id="form_cor" novalidate class="needs-validation" method="POST"
                        action="{{ route('cor.update', $cor)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value = "{{ old('name', $cor->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }} 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputCode">Código</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="inputCode" value = "{{ old('code', $cor->code) }}">
                                @error('code')
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
                                            <button type="submit" name="ok" form="form_cor" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">
                                            Guardar Alterações</button>   
                                        </a>
                                    </div> 
                                    </form>
                                    <div class="col-md-6 justify-content-center" style = "display:flex">
                                        <a href="{{ route('user.gerirCores', $user) }}"> 
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