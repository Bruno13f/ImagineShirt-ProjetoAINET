@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Alterar Password')

@section('main')

<div class="row mb-5 justify-content-md-center" >
    <div class="col-5">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Alterar Palavra-Passe</h5>
                    </div>
                    <div class="row justify-content-center">
                        <div class="card-body">
                            <form method="POST" action="{{ route('password.change.store') }}" novalidate>
                                @csrf
                                <div class="row mb-3">
                                    <label for="currentpassword" class="col-md-4 col-form-label text-md-end">Palavra-Passe Atual</label>

                                    <div class="col-md-6">
                                        <input id="currentpassword" type="password"
                                            class="form-control @error('currentpassword') is-invalid @enderror"
                                            name="currentpassword" required>
                                        @error('currentpassword')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Nova Palavra-Passe</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar
                                    Palavra-Passe</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary" style="background-color:rgba(230, 51, 52, 0.8); border-color:rgba(230, 51, 52, 0.8)">
                                            Alterar Palavra-Passe
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection