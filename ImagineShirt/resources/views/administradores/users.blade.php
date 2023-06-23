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
<div class="row mb-5 mt-4 justify-content-center" >
    <div class="col-10">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <div class="row d-flex justify-content-center">
                    @can('create', App\Models\User::class)
                        <div class="col-4 d-flex justify-content-center mb-4">
                            <a href="{{ route('user.create') }}"><button type="button" class="btn btn-success btn-lg"><span>Criar User</span></button></a>
                        </div>
                    @endcan
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <h5 class="card-title mb-0">Utilizadores</h5>
                    </div>
                    <div class="card-body">
                    @if(count($utilizadores) != 0)
                        <table class="table table-hover table-bordered table-light">
                            <tbody>
                                @foreach($utilizadores as $utilizador)
                                @php    
                                switch($utilizador->user_type){
                                    case 'A':
                                        $tipoUser = 'Administrador';
                                        break;
                                    case 'E':
                                        $tipoUser = 'Funcionario';
                                        break;
                                    case 'C':
                                        $tipoUser = 'Cliente';
                                        break;
                                }
                                @endphp
                                    <tr>
                                        <td><img id="imagemGestaoUser"src="{{ $utilizador->fullPhotoUrl }}" alt="{{ $utilizador->name }}" width="128" height="128"></td>
                                        <td><span class="font-weight-bold text-uppercase">{{$tipoUser}}</span><br>{{$utilizador->name}}</td>
                                        <td><span class="font-weight-bold text-uppercase">{{is_null($utilizador->email_verified_at) ? 'Por verificar' : 'Verificado'}}</span><u><br>{{$utilizador->email}}</u></td>
                                        <td>Criação: <br>{{$utilizador->created_at}}</td>
                                        <td>
                                        @can('update', $utilizador)
                                            <a href="{{ route('user.edit', $utilizador) }}"><button type="button" class="btn btn-info rounded-pill"><span>Editar</span></button></a>
                                        @endcan

                                        @can('block', $utilizador)
                                        <form id="form_block_user_{{$utilizador->id}}" novalidate class="needs-validation" method="POST"
                                        action="{{ route('user.updateStatusBlock', $utilizador) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                            <input type="hidden" name="blocked" value="{{ $utilizador->blocked ? '0' : '1'}}">
                                            <button type="submit" name="ok" form="form_block_user_{{$utilizador->id}}" class="btn btn-warning rounded-pill mt-2"><span>
                                                {{ $utilizador->blocked ? 'Desbloquear' : 'Bloquear'}}</span></button>
                                        </form>
                                        @endcan

                                        @can('delete', $utilizador)
                                        <form id="form_delete_user_{{$utilizador->id}}" novalidate class="needs-validation" method="POST"
                                        action="{{ route('user.destroy', $utilizador) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" name="ok" form="form_delete_user_{{$utilizador->id}}" class="btn btn-danger rounded-pill mt-2"><span>Eliminar</span></button>
                                        </form>
                                        @endcan
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
                {{ $utilizadores->links() }}
            </div>
        </div>
    </div>
</div>
@endsection