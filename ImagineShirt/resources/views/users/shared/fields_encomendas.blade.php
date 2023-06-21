<div class="tab-pane fade" id="encomendas" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Encomendas</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered table-light">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Preço</th>
                    </tr>
                </thead>
                <tbody>
                @if (!empty($encomendas))
                    @foreach ($encomendas as $encomenda)

                    @php    
                    switch($encomenda->status){
                        case 'closed':
                            $btn = 'dark';
                            $estado = 'Fechado';
                            break;
                        case 'canceled':
                            $btn = 'danger';
                            $estado = 'Cancelado';
                            break;
                        case 'pending':
                            $btn = 'warning';
                            $estado = 'Pendente';
                            break;
                        case 'paid':
                            $btn = 'success';
                            $estado = "Pago";
                            break;
                    }
                    @endphp
                    
                        <tr>
                            <th scope="row">Encomenda: {{ $encomenda->date }}</th>
                            <td><button type="button" class="btn btn-{{$btn}} rounded-pill" disabled><span>{{ $estado }}</span></button></td>
                            <td>{{ $encomenda->total_price }}€</td>
                        </tr>
                        
                    @endforeach
                @else
                    <td colspan="3">$msgNotFound</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    {{ $encomendas->links() }}
</div>