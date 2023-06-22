@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => '']]) 

@section('titulo',' | Editar Cliente')

@section('main')

<section>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-10 col-xl-8">
        <div class="card" style="border-radius: 10px;">
          <div class="card-header px-4 py-5">
            <div class="row">
              <div class="col md-8">
                <h5 class="text-muted mb-0 font-weight-bold">Obrigado pela sua encomenda, <span style="color: #e63334;">NOME</span>!</h5>
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
            <div class="card shadow-0 border mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/13.webp"
                      class="img-fluid" alt="Phone">
                  </div>
                  <div class="col-md-3 text-center d-flex justify-content-center align-items-center">
                    <p class="text-muted mb-0">Samsung Galaxy</p>
                  </div>
                  <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                    <p class="text-muted mb-0 small">White</p>
                  </div>
                  <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                    <p class="text-muted mb-0 small">Qty: 1</p>
                  </div>
                  <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                    <p class="text-muted mb-0 small">$499</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between pt-2">
              <p class="fw-bold mb-0">Order Details</p>
              <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> $898.00</p>
            </div>

            <div class="d-flex justify-content-between pt-2">
              <p class="text-muted mb-0">Invoice Number : 788152</p>
              <p class="text-muted mb-0"><span class="fw-bold me-4">Discount</span> $19.00</p>
            </div>

            <div class="d-flex justify-content-between">
              <p class="text-muted mb-0">Invoice Date : 22 Dec,2019</p>
              <p class="text-muted mb-0"><span class="fw-bold me-4">GST 18%</span> 123</p>
            </div>

            <div class="d-flex justify-content-between mb-5">
              <p class="text-muted mb-0">Recepits Voucher : 18KU-62IIK</p>
              <p class="text-muted mb-0"><span class="fw-bold me-4">Delivery Charges</span> Free</p>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>

@endsection