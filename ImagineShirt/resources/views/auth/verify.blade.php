@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div style="font-size: 1.1rem; font-weight: bold;" class="card-header text-center">{{ __('Verifique o seu email') }}</div>

                <div class="card-body text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Verificação do email enviada! Verifique a sua caixa de correio') }}
                        </div>
                    @endif

                    {{ __('Antes de puder aceder ao seu perfil verifique o seu email!') }}
                    {{ __('Caso não tenha recebido') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link link-offset-3 p-0 m-0 align-baseline">{{ __('Enviar novamente o email de confirmação') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
