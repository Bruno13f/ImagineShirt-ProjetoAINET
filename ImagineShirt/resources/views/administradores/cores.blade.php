@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Gerir Cores')

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
                        <span style = "font-weight: bold;">Gerir Cores</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Breadcrumb Section End -->
<div class="row mb-5 mt-5 justify-content-md-center" >
    <div class="col-6">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="cores" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Cores T-Shirts</h5>
                    </div>
                    <div class="card-body">
                        @if(count($cores) !== 0)
                        <table class="table table-hover table-bordered table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Cor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cores as $cor)
                                <tr>
                                    <td>{{$cor->name}}</td>
                                    <td>
                                        <button class="btn rounded-circle" style="background-color: #{{$cor->code}}; width: 40px; height: 40px"></button>
                                    <td>
                                        <a href="{{ route('cor.edit', $cor) }}">
                                        <button type="button" class="btn btn-info rounded-pill">Editar</button>
                                        </a>
                                        <form id="form_delete_cor_{{$cor->code}}" action="{{ route('cor.destroy', $cor) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger rounded-pill mt-2"><span>Eliminar</span></button></a></a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <span>Não foram definidas cores</span>
                        @endif
                    </div>
                </div>
                {{ $cores->links() }}
            </div>
        </div>
    </div>
</div>
@endsection