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
                        <a href="{{ route('user', Auth::user()) }}">Perfil</a>
                        <span style = "font-weight: bold">Criar User</span>
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
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informação Pessoal</h5>
                        </div>
                        <div class="card-body justify-content-center">
                            @include('users.shared.fields_foto', ['allowFoto' => false, 'allowCreate' => true, 'allowUpload' => false, 'allowElimPhoto' => false])
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informação Privada</h5>
                        </div>
                        <div class="card-body">
                            @include('users.shared.fields_infpriv', ['user' => $user, 'readonlyData' => false])
                            <div class="form-group">
                                <label for="inputPassword">Palavra-Passe</label>
                                <div class="input-group">
                                    <input type="password" id="inputPassword" name="password" class="form-control @error('password') is-invalid @enderror">
                                    <button class="btn btn-outline-danger" type="button" onclick="visibilidadePassword('inputPassword')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group" style="display:flex; align-items: center;">
                                    <span>Tipo de User</span>
                                </div>
                                <div class="form-group">
                                    <select class="@error('userType') is-invalid @enderror" name="userType" id="inputUserType">
                                        <option {{empty($user->user_type) ? 'selected' : ''}}></option>
                                        <option value="A" {{'A' === old('userType',$user->user_type) ? 'selected' : ''}}>Administrador</option> 
                                        <option value="E" {{'E' === old('userType',$user->user_type) ? 'selected' : ''}}>Funcionário</option> 
                                    </select>
                                    @error('userType')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 justify-content-center" style = "display:flex">
                                        <a href=""> 
                                            <button type="submit" name="ok" form="form_user" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">Guardar Alterações</button>   
                                        </a>
                                    </div> 
                                    </form>
                                    <div class="col-md-6 justify-content-center" style = "display:flex">
                                        <a href="{{ route('user.gerirUsers', Auth::user()) }}"> 
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

<script>
    function visibilidadePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

@endsection