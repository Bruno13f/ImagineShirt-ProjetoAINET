<a class="list-group-item list-group-item-action active" data-toggle="list" href="#account" role="tab">
    Conta
</a>
@can ('alterarPasse', App\Models\User::class)
<a class="list-group-item list-group-item-action" data-toggle="list" href="#password" role="tab">
    Palavra-Passe
</a>
@endcan

<a class="list-group-item list-group-item-action" href="{{ route('user.encomendas', $user) }}">
    Encomendas
    <span class="badge badge-primary badge-pill badge-light">{{$numencomendas}}</span>
</a>

@can ('verPropriasTShirts', App\Models\User::class)
<a class="list-group-item list-group-item-action" data-toggle="list" href="#tshirts" role="tab">
    T-Shirts
    <span class="badge badge-primary badge-pill badge-light">numero</span>
</a>
@endcan

@can ('fazerGestao', App\Models\User::class)
<a class="list-group-item list-group-item-action" href="{{ route('user.gerirUsers', $user) }}">
    Utilizadores
    <span class="badge badge-primary badge-pill badge-light">{{$numutilizadores}}</span>
</a>
<a class="list-group-item list-group-item-action" href="{{ route('user.gerirCategorias', $user) }}">
    Categorias
    <span class="badge badge-primary badge-pill badge-light">{{$numCategorias}}</span>
</a>
<a class="list-group-item list-group-item-action" data-toggle="list" href="#precos" role="tab">
    Preços Catálogo
</a>
<a class="list-group-item list-group-item-action" href="{{ route('user.gerirCores', $user) }}">
    Cores T-Shirts
    <span class="badge badge-primary badge-pill badge-light">{{$numCores}}</span>
</a>
@endcan