@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Editar Administrador')

@section('main')

@can('update', $user)

    @include('users.shared.fields_editAdminFunc')

@endcan

@endsection