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
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account"
                            role="tab">
                            Conta
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#password"
                            role="tab">
                            Palavra-Passe
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#encomendas" role="tab">
                            Encomendas
                            <span class="badge badge-primary badge-pill badge-light">numero</span>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#tshirts" role="tab">
                            T-Shirts
                            <span class="badge badge-primary badge-pill badge-light">numero</span>
                        </a>
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <img alt="{{$user->name}}"
                                                    src="{{$user->fullPhotoUrl}}"
                                                    class="rounded-circle img-responsive mt-2" width="128" height="128">
                                                <div class="mt-2">
                                                    <label for="formFile" class="form-label">Mostrar quando se clica no editar</label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                                <small>Inidicado: 128px por 128px</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-12 justify-content-center" style = "display:flex">
                                            <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color: rgba(230, 51, 52, 0.8)" >Editar</button>   
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card" style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informação Privada</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="inputName">Nome</label>
                                        <input type="text" class="form-control" id="inputName" value = "{{$user->name}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4" value = "{{$user->email}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Morada</label>
                                        <input type="text" class="form-control" id="inputAddress" value = "{{$user->cliente->address}}" readonly>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3" style="display:flex; align-items: center;">
                                            <span>Método de Pagamento</span>
                                        </div>
                                        <div class="form-group col-md-3" style="display:flex; align-items: center;">
                                            <select id="inputMetodoPagamento" disabled>
                                                <option {{empty($user->cliente->default_payment_type) ? 'selected' : ''}}></option>
                                                <option value="Paypal" {{ $user->cliente->default_payment_type === 'PAYPAL' ? 'selected' : ''}}>Paypal</option>
                                                <option value="MC" {{$user->cliente->default_payment_type === 'MC' ? 'selected' : ''}}>MC</option>
                                                <option value="Visa" {{ $user->cliente->default_payment_type === 'Visa' ? 'selected' : ''}}>Visa</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputRef">Referência de Pagamento</label>
                                            <input type="text" class="form-control" id="inputRef" value="{{$user->cliente->default_payment_ref}}" readonly>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-12 justify-content-center" style = "display:flex">
                                            <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Editar</button>   
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Palavra Passe</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="inputPasswordCurrent">Palavra Passe Atual</label>
                                        <input type="password" class="form-control" id="inputPasswordCurrent">
                                        <small><a href="#">Esqueceu-se da passowrd?</a></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordNew">Nova Palavra Passe</label>
                                        <input type="password" class="form-control" id="inputPasswordNew">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordNew2">Repita a Nova Palavra Passe</label>
                                        <input type="password" class="form-control" id="inputPasswordNew2">
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-12 justify-content-center" style = "display:flex">
                                            <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Alterar Palavra-Passe</button>   
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="encomendas" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Encomendas</h5>
                            </div>
                            <div class="card-body">
                            </div>
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