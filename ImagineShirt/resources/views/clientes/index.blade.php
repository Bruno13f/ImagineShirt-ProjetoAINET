@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Página Cliente')

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
                        @include('users.shared.fields_tablist', ['usertipo' => $tipoUser])
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
                                <form>
                                    @include('users.shared.fields_foto', ['allowUpload' => false])
                                </form>
                            </div>
                        </div>
                        <div class="card" style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informação Privada</h5>
                            </div>
                            <div class="card-body">
                                @include('users.shared.fields_infpriv', ['user' => $user, 'readonlyData' => true])
                                @include('clientes.shared.fields_infpriv', ['user' => $user, 'readonlyData' => true])
                            </div>
                        </div>
                        <div class="card" style="margin-top: 20px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 justify-content-center" style = "display:flex">
                                        <a href = "{{ route('editUser', $user) }}" >
                                            <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Editar</button>   
                                        </a> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Palavra Passe</h5>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="encomendas" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Encomendas</h5>
                            </div>
                            <table class="table">
                            <table class="table">
                                <tbody>
                                @if ($user->cliente->encomendas)
                                    @foreach ($user->cliente->encomendas as $encomenda)
                                        <tr>
                                            <td>Encomenda: {{ $encomenda->date }}</td>
                                            <td>{{ $encomenda->status }}</td>
                                            <td>{{ $encomenda->total_price }}€</td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="3">Não foram encontradas encomendas.</td>
                                </tr>
                                @endif
                                </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tshirts" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Importar Imagem para T-Shirt</h5>
                            </div>
                            <div class="card-body justify-content-center">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <div class="mt-2">
                                                    <label for="formFile" class="form-label"></label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-md-12 justify-content-center" style = "display:flex">
                                            <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color: rgba(230, 51, 52, 0.8)" >Importar</button>   
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card" style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title mb-0">T-Shirts</h5>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection()