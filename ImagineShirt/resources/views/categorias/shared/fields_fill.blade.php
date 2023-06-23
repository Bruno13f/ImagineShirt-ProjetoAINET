<div class="container p-0" style = "margin-top: 50px; margin-bottom: 50px">
    <div class="row justify-content-center">
        <div class="col-md-7 col-xl-8">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="account" role="tabpanel">
                    <div class="card" style="margin-top: 20px">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ $allowCreate ? 'Criar Categoria' : 'Editar Categoria'}}</h5>
                        </div>
                        <form id="form_categoria" novalidate class="needs-validation" method="POST"
                        action="{{ $allowCreate ? route('categoria.store') : route('categoria.update', $categoria)}}" enctype="multipart/form-data">
                        @csrf
                        @if($allowCreate)
                            @method('POST') 
                        @else   
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value = "{{ old('name', $categoria->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }} 
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 justify-content-center" style = "display:flex">
                                        <a href=""> 
                                            <button type="submit" name="ok" form="form_categoria" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">
                                            {{ $allowCreate ? 'Criar Categoria' : 'Guardar Alterações'}}</button>   
                                        </a>
                                    </div> 
                                    </form>
                                    <div class="col-md-6 justify-content-center" style = "display:flex">
                                        <a href="{{ route('user.gerirCategorias', $user) }}"> 
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