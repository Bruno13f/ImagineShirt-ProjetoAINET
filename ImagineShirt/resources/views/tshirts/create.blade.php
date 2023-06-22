@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => 'class = active',
                                        'active3' => '',
                                        'active4' => '']])


@section('titulo',' | T-Shirts')

@section('main')

<section class="shop-details">
        <div class="product__details__pic" style="background-color:white; margin-bottom: 0px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('root') }}">Página Inicial</a>
                            <a href="{{ route('t-shirts') }}">T-Shirts</a>
                            <span>Criar T-Shirt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__last__option">
                        <form id="form_tshirts" novalidate class="needs-validation" method="POST"
                        action="{{ route('t-shirts.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                            <div class="mt-2">
                                <label for="formImage" class="form-label">Escolha uma imagem</label>
                                <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="formImage">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value = "{{old('name', $t_shirt->name)}}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Descrição</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="inputDescription" value = "{{old('description',$t_shirt->description)}}">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-group" style="display:flex; align-items: center;">
                                    <span>Categoria</span>
                                </div>
                                <div class="form-group">
                                    <select class="@error('category') is-invalid @enderror" name="category" id="inputCategory">
                                        <option {{empty($t_shirt->categoria->name) ? 'selected' : ''}}></option>    
                                        @foreach($categorias as $categoria)
                                        <option value="{{$categoria}}" {{$categoria === old('category',$t_shirt->categoria) ? 'selected' : ''}}>{{$categoria}}</option>  
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <div class="row mb-5">
                                <div class="col-md-6 justify-content-center" style = "display:flex">
                                    <a href=""> 
                                        <button type="submit" name="ok" form="form_tshirts" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Criar T-Shirt</button>   
                                    </a>
                                </div>
                                </form> 
                                <div class="col-md-6 justify-content-center" style = "display:flex">
                                    <a href="{{ route('t-shirts') }}"> 
                                        <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Cancelar</button>   
                                    </a>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection