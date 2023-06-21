<a class="list-group-item list-group-item-action active" data-toggle="list" href="#account" role="tab">
    Conta
</a>
@if ($usertipo != 'Funcionário')
<a class="list-group-item list-group-item-action" data-toggle="list" href="#password" role="tab">
    Palavra-Passe
</a>
@endif

<a class="list-group-item list-group-item-action" data-toggle="list" href="#encomendas" role="tab">
    Encomendas
    <span class="badge badge-primary badge-pill badge-light">{{$numencomendas}}</span>
</a>

@if ($usertipo == 'Cliente')
<a class="list-group-item list-group-item-action" data-toggle="list" href="#tshirts" role="tab">
    T-Shirts
    <span class="badge badge-primary badge-pill badge-light">numero</span>
</a>
@endif

@if ($usertipo == 'Aadministrador')
<a class="list-group-item list-group-item-action" data-toggle="list" href="#users" role="tab">
    Utilizadores
    <span class="badge badge-primary badge-pill badge-light">numero</span>
</a>
<a class="list-group-item list-group-item-action" data-toggle="list" href="#categorias" role="tab">
    Categorias
    <span class="badge badge-primary badge-pill badge-light">numero</span>
</a>
<a class="list-group-item list-group-item-action" data-toggle="list" href="#precos" role="tab">
    Preços Catálogo
</a>
@endif