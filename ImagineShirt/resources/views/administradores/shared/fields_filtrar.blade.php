<div class="row d-flex">
    <div class="col-1"></div>
    <div class="col-3 mt-5 mb-0 align-middle">
        <div class="shop__sidebar__search">
            <form method="GET" id="pesquisa-form">
                <input id = "pesquisa" type="text" maxlength="50" name="pesquisa" value = "{{old('pesquisa', $pesquisaFiltro)}}" placeholder="Pesquisar por cliente ou numero encomenda ...">
                <button type="submit"><span class="icon_search"></span></button>
            </form>
        </div>
    </div>
    <div class="col-4 mt-5 mb-0 align-middle">
        <div class="shop__product__option">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="shop__product__option__left">
                    </div>
                </div>
                <div class="col-lg-10 col-md-6 col-sm-6">
                    <div class="shop__product__option__right">
                        <p>Selecionar: </p>
                        <select id="selecionar" onchange="updateQuery('selecionar')" name="selecionar">
                        @if($encomendas)
                            <option value="todas" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'todas' ? 'selected' : '' }}>Todas</option>
                            <option value="pending" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="paid" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'paid' ? 'selected' : '' }}>Paga</option>
                            <option value="closed" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'closed' ? 'selected' : '' }}>Fechada</option>
                            <option value="canceled" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'canceled' ? 'selected' : '' }}>Anulada</option>
                        @else
                            <option value="todos" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'todos' ? 'selected' : '' }}>Todos</option>
                            <option value="A" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'A' ? 'selected' : '' }}>Administradores</option>
                            <option value="E" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'E' ? 'selected' : '' }}>Funcionários</option>
                            <option value="C" value="date_desc" {{ old('ordenar', $selecionarFiltro) == 'C' ? 'selected' : '' }}>Clientes</option>
                        @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 mt-5 mb-0 align-middle">
        <div class="shop__product__option">
            <div class="row d-flex justify-content-end">
                <div class="col-lg-10 col-md-6 col-sm-6">
                    <div class="shop__product__option__right">
                        <p>Ordernar: </p>
                        <select id="ordenar" onchange="updateQuery('ordenar')" name="ordenar">
                        @if($encomendas)
                            <option value="date_desc" {{ old('ordenar', $ordenarFiltro) == 'date_desc' ? 'selected' : '' }}>Mais Recente</option>
                            <option value="date_asc" {{ old('ordenar', $ordenarFiltro) == 'date_asc' ? 'selected' : '' }}>Mais Antiga</option>
                            <option value="preco_desc" {{ old('ordenar', $ordenarFiltro) == 'preco_desc' ? 'selected' : '' }}>Preço Descendente</option>
                            <option value="preco_asc" {{ old('ordenar', $ordenarFiltro) == 'preco_asc' ? 'selected' : '' }}>Preço Ascendente</option>
                        @else
                            <option value="date_desc" {{ old('ordenar', $ordenarFiltro) == 'date_desc' ? 'selected' : '' }}>Data Criação Mais Recente</option>
                            <option value="date_asc" {{ old('ordenar', $ordenarFiltro) == 'date_asc' ? 'selected' : '' }}>Data Criação Mais Antiga</option>
                        @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function updateQuery (string){
        let query = window.location.search;  // parametros url
        let parametros = new URLSearchParams(query);
        parametros.delete(string);  // se ja existir delete
        parametros.append(string, document.getElementById(string).value); // adicionar ordenação
        document.location.href = "?" + parametros.toString(); // refresh
    }

</script>