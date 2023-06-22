<div class="row" style="margin-top: 40px">
    <div class="col-lg-3 col-md-3">
        <ul class="nav nav-tabs" role="tablist">
            @if(!$edit)
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                    <div id="tshirtBaseEsq" class="product__thumb__pic set-bg" data-setbg="/storage/tshirt_base/{{$cores[0]->code}}.jpg"></div>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                    <div class="product__thumb__pic set-bg" data-setbg="{{ empty($t_shirt->customer_id) ? "/storage/tshirt_images/{$t_shirt->image_url}" : 
    route('imagem_user', ['image_url' => $t_shirt->image_url, 'user_id' => $t_shirt->customer_id, 'nome_tshirt' => $t_shirt->name])}}">
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-6 col-md-9">
        <div class="tab-content">
            @if(!$edit)
            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <div class="canvas-container">
                    <img id="tshirtBase" src = "/storage/tshirt_base/{{$cores[0]->code}}.jpg" alt="">
                    <canvas id="myCanvas"></canvas>
                </div>
            </div>
            @endif
            <div class="tab-pane {{$edit ? 'active' : ''}}" id="tabs-2" role="tabpanel">
                <div class="product__details__pic__item">
                    <img src="{{ empty($t_shirt->customer_id) ? "/storage/tshirt_images/{$t_shirt->image_url}" : 
    route('imagem_user', ['image_url' => $t_shirt->image_url, 'user_id' => $t_shirt->customer_id, 'nome_tshirt' => $t_shirt->name])}}" alt="" style="object-fit: contain; max-width: 100%; max-height: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>