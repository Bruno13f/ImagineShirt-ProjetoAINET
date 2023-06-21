@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Gerir Users')

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
                        <span style = "font-weight: bold;">Gerir Users</span>
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Utilizadores</h5>
                    </div>
                    @if(count($utilizadores) != 0)
                        <table class="table">
                            <tbody>
                                @foreach($utilizadores as $utilizador)
                                    <tr>
                                        <td><img id="imagemPerfil" src="{{ $utilizador->fullPhotoUrl }}" alt="{{ $utilizador->name }}" class="rounded-circle" ></td>
                                        <td>{{$utilizador->name}}</td>
                                        <td>{{$utilizador->email}}</td>
                                        <td>{{$utilizador->created_at}}</td>
                                        <td>
                                            <a href="">
                                                <button type="button" class="btn btn-danger rounded-pill"><span>Editar Utilizador</span></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <span>Não foram encontradas encomendas.</span>
                    @endif
                </div>
                {{ $utilizadores->links() }}
            </div>
        </div>
    </div>
</div>
@endsection