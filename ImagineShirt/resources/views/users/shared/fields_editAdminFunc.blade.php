
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
                            <span style = "font-weight: bold;">Editar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

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
                                @include('users.shared.fields_foto', ['allowFoto' => true, 'allowCreate' => false, 'allowUpload' => true, 'allowElimPhoto' => true])
                            </div>
                        </div>
                        <div class="card" style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informação Privada</h5>
                            </div>
                            <div class="card-body">
                                @include('users.shared.fields_infpriv', ['user' => $user, 'readonlyData' => false])
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
                                            <a href="{{ Auth::user() == $user ? route('user', $user) : route('user.gerirUsers', $user)}}"> 
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