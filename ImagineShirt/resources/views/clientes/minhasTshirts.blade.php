@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Editar Cliente')

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
                        <span style = "font-weight: bold;">Gerir Minhas T-Shirts</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Breadcrumb Section End -->
<div class="row mb-5 mt-5 justify-content-md-center" >
    <div class="col-10">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
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
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header d-flex justify-content-center">
                        <h5 class="card-title mb-0">T-Shirts</h5>
                    </div>
                    <div class="card-body">
                    @if(count($t_shirts) != 0)
                        <table class="table table-hover table-bordered table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Data Criação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($t_shirts as $tshirt)
                                    <tr>
                                        <td><img src="{{ route('imagem_user', ['image_url' => $tshirt->image_url, 'user_id' => $tshirt->customer_id, 'nome_tshirt' => $tshirt->name]) }}" alt="{{ $tshirt->name }}" width="128" height="128"></td>
                                        <td><span class="font-weight-bold text-uppercase">{{$tshirt->name}}</span></td>
                                        <td>{{$tshirt->description}}</td>
                                        <td>{{$tshirt->created_at}}</td>
                                        <td>
                                            <button type="button" class="btn btn-info rounded-pill"><span>Editar</span></button>
                                            <button type="button" class="btn btn-danger rounded-pill"><span>Eliminar</span></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <span>Não foram encontradas T-Shirts.</span>
                    @endif
                    </div>
                </div>
                {{ $t_shirts->links() }}
            </div>
        </div>
    </div>
</div>

@endsection