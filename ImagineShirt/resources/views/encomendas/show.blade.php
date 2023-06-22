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
                <h5 class="text-muted mb-0 font-weight-bold">Obrigado pela sua encomenda, <span style="color: #e63334;">{{ $encomendaData->name }}</span>!</h5>
              </div>
              <div class="col md-4 d-flex justify-content-end">
                <a href="{{ route('encomendas.recibo', $encomenda) }}"><button type="button" class="btn rounded-pill" style="background-color: #e63334;"><span style="color: white;">Recibo</span></button></a>
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
                @foreach ($itemsData as $item)
                <div class="card shadow-0 border mb-4">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 d-flex justify-content-center" style="background-color: #{{$item->code_color}}">
                        <img src="/storage/tshirt_images/{{ $item->image_url }}" class="img-fluid" alt="{{ $item->name }}" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">{{ $item->name }}</p>
                        </div>
                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center"> 
                        <span class="text-muted mb-0 mr-2">{{ $item->color_name }}</span>
                        </div>
                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center "> 
                        <button class="btn rounded-circle" style="background-color: #{{$item->code_color}}; width: 40px; height: 40px"></button>
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
                    @if (!is_null($item->customer_id) && $item->qty >= $quantdesconto)
                        @php
                            $customer_tshirt++;
                        @endphp
                    @endif

                    @if (is_null($item->customer_id) && $item->qty >= $quantdesconto)
                        @php
                            $catalogo_tshirt++;
                        @endphp
                    @endif
                @endforeach
                <div class="d-flex justify-content-between pt-2">
                    <p class="fw-bold mb-0 h6">Detalhes da encomenda</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Total sem desconto</span>{{$encomendaData->total_price + (($catalogo_tshirt * $descontocatalogo)+($customer_tshirt * $descontoown))}}€</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">NIF cliente:</span>{{ $encomendaData->nif }}</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Desconto:</span>{{($catalogo_tshirt * $descontocatalogo)+($customer_tshirt * $descontoown) }} €</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Data:</span> {{ $encomendaData->date }}</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Total</span>{{ $encomendaData->total_price }} €</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Método de Pagamento:</span>
                        @if ($encomendaData->payment_type == 'MC')
                            MasterCard
                        @else
                            {{ $encomendaData->payment_type }}
                        @endif
                    </p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Referencia de Pagamento:</span>{{ $encomendaData->payment_ref }}</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Notas:</span>{{ empty($encomendaData->notes) ? 'Sem Notas' : $encomendaData->notes }}</p>
                </div>
                <div class="d-flex justify-content-between pt-2 mb-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-1">Endereço de envio:</span>{{ $encomendaData->address }}</p>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection