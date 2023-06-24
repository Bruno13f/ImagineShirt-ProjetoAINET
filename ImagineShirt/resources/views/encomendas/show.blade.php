@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Detalhes Encomenda')

@section('main')

<section>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-10 col-xl-10">
        <div class="card" style="border-radius: 10px;">
          <div class="card-header px-4 py-5">
            <div class="row">
              <div class="col md-8">
                <h5 class="text-muted mb-0 font-weight-bold">Obrigado pela sua encomenda, <span style="color: #e63334;">{{ $encomenda->clientes->user->name }}</span>!</h5>
              </div>
              <div class="col md-4 d-flex justify-content-end">
                <a href="{{ route('encomendas') }}"><button type="button" class="btn rounded-pill mr-2" style="background-color: #e63334;"><span style="color: white;">Voltar</span></button></a>
                @if($encomenda->status == 'closed' || $encomenda->status == 'canceled')
                <a href="{{ route('encomendas.recibo', $encomenda) }}"><button type="button" class="btn rounded-pill" style="background-color: #e63334;"><span style="color: white;">Recibo</span></button></a>
                @endif  
              </div>
            </div>
          </div> 
                <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="lead fw-normal mb-0 font-weight-bold" style="color: #e63334;">Detalhes Encomenda</p>
                </div>
                @php
                    $customer_tshirt = 0;
                    $catalogo_tshirt = 0;
                @endphp
                @foreach ($encomenda->itensEncomenda as $item)
                <div class="card shadow-0 border mb-4">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 d-flex justify-content-center rounded" style="background-color: #{{ $item->color_code}}">
                        <img src="{{empty($item->tshirts->customer_id) ? '/storage/tshirt_images/'.$item->tshirts->image_url : route('imagem_user', ['image_url' => $item->tshirts->image_url, 'user_id' => $item->tshirts->customer_id, 'nome_tshirt' => $item->tshirts->name])}}" 
                        class="img-fluid" alt="{{ $item->tshirts->name }}" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">{{ $item->tshirts->name }}</p>
                        </div>
                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center"> 
                        <span class="text-muted mb-0 mr-2">{{ $item->cores->name }}</span>
                        </div>
                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center "> 
                        <button class="btn rounded-circle" style="background-color: #{{$item->color_code}}; width: 40px; height: 40px"></button>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 ">Quant: {{ $item->qty }}</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">{{ $item->unit_price }} €</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">{{ $item->sub_total }} €</p>
                        </div>
                    </div>
                    </div>
                </div>
                    @if (!is_null($item->customer_id) && $item->qty >= $descontos['quantdesconto'])
                        @php
                            $customer_tshirt= $customer_tshirt + $item->qty;
                        @endphp
                    @endif

                    @if (is_null($item->customer_id) && $item->qty >= $descontos['quantdesconto'])
                        @php
                            $catalogo_tshirt = $catalogo_tshirt + $item->qty;
                        @endphp
                    @endif
                @endforeach
                <div class="d-flex justify-content-between pt-2">
                    <p class="fw-bold mb-0 h6">Detalhes da encomenda {{$encomenda->id}}</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Total sem desconto</span>{{$encomenda->total_price + (($catalogo_tshirt * $descontos['descontocatalogo'])+($customer_tshirt * $descontos['descontoown']))}}€</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">NIF cliente:</span>{{ $encomenda->nif }}</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Desconto:</span>{{($catalogo_tshirt * $descontos['descontocatalogo'])+($customer_tshirt * $descontos['descontoown']) }} €</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Data:</span> {{ $encomenda->date }}</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Total</span>{{ $encomenda->total_price }} €</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Status:</span>{{ $encomenda->status }}</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Método de Pagamento:</span>
                        @if ($encomenda->payment_type == 'MC')
                            MasterCard
                        @else
                            {{ $encomenda->payment_type }}
                        @endif
                    </p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Referencia de Pagamento:</span>{{ $encomenda->payment_ref }}</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Notas:</span>{{ empty($encomenda->notes) ? 'Sem Notas' : $encomenda->notes }}</p>
                </div>
                <div class="d-flex justify-content-between pt-2 mb-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Endereço de envio:</span>{{ $encomenda->address }}</p>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection