@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Gerir Categorias')

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
                        <span style = "font-weight: bold;">Gerir Categorias</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Breadcrumb Section End -->
<div class="row mb-5 mt-5 justify-content-md-center" >
    <div class="col-4">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="categorias" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <h5 class="card-title mb-0">Categorias</h5>
                    </div>
                    <div class="card-body">
                    @if(count($categorias) != 0)
                        <table class="table table-hover table-bordered table-light">
                            <tbody>
                                <div class="d-flex justify-content-center mb-4">
                                    <a href="{{route('categorias.create')}}"><button type="button" class="btn btn-success rounded-pill"><span>Criar Categoria</span></button></a></a>
                                </div>
                                @foreach($categorias as $categoria)
                                    <tr>
                                        <td><span class="fs-5">{{$categoria->name}}</span></td>
                                        <td>
                                            <a href="{{route('categorias.edit', $categoria)}}"><button type="button" class="btn btn-info rounded-pill"><span>Editar</span></button></a></a>
                                            <form id="form_delete_category_{{$categoria->id}}" action="{{ route('categorias.destroy', $categoria) }}" method="POST">
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
                    <span>Não foram criadas categorias.</span>
                    @endif
                    </div>
                </div>
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</div>
@endsection