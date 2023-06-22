@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Detalhes Encomenda')

@section('main')

<section>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-10 col-xl-8">
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
                
                @foreach ($itemsData as $item)
                <div class="card shadow-0 border mb-4">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                        <img src="/storage/tshirt_images/{{ $item->image_url }}" class="img-fluid" alt="{{ $item->name }}" style="max-width: 75px; max-height: 75px;">
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">{{ $item->name }}</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 small">{{ $item->color_name }}</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 small">Qty: {{ $item->qty }}</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 small">{{ $item->unit_price }} €</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 small">{{ $item->sub_total }} €</p>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
                <div class="d-flex justify-content-between pt-2">
                    <p class="fw-bold mb-0 ml-1">Detalhes da encomenda</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span>{{ $encomendaData->total_price }} €</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-4">NIF cliente:</span>{{ $encomendaData->nif }}</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Data:</span>{{ $encomendaData->date }}</p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Método de Pagamento:</span>
                        @if ($encomendaData->payment_type == 'MC')
                            MasterCard
                        @else
                            {{ $encomendaData->payment_type }}
                        @endif
                    </p>
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Referencia de Pagamento:</span>{{ $encomendaData->payment_ref }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Notas:</span>{{ $encomendaData->notes }}</p>
                </div>
                <div class="d-flex justify-content-between mb-5">
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Endereço de envio:</span>{{ $encomendaData->address }}</p>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection