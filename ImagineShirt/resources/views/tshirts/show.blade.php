@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => 'class = active',
                                        'active3' => '',
                                        'active4' => '']])


@section('titulo',' | T-Shirts')

@section('main')

<!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic" style="background-color:white; margin-bottom: 0px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('root') }}">Página Inicial</a>
                            <a href="{{ route('t-shirts') }}">T-Shirts</a>
                            <span>{{ empty($t_shirt->name) ? 'Detalhes T-Shirt' : $t_shirt->name}}</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 40px">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <div id="tshirtBaseEsq" class="product__thumb__pic set-bg" data-setbg="/storage/tshirt_base/{{$cores[0]->code}}.jpg"></div>
                                </a>
                            </li>
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
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="canvas-container">
                                    <img id="tshirtBase" src = "/storage/tshirt_base/{{$cores[0]->code}}.jpg" alt="">
                                    <canvas id="myCanvas"></canvas>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="{{ empty($t_shirt->customer_id) ? "/storage/tshirt_images/{$t_shirt->image_url}" : 
                    route('imagem_user', ['image_url' => $t_shirt->image_url, 'user_id' => $t_shirt->customer_id, 'nome_tshirt' => $t_shirt->name])}}" alt="" style="object-fit: contain; max-width: 100%; max-height: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row justify-content-md-center" style="margin-top: 40px">
                    <div class="col-lg-5 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <div class="canvas-container">
                                        <img id="tshirtBase" src = "/storage/tshirt_base/{{$cores[0]->code}}.jpg" alt="">
                                        <canvas id="myCanvas"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ empty($t_shirt->name) ? 'Sem Nome' : $t_shirt->name }}</h4>
                            <div class="rating">
                            </div>
                            <h3>{{$t_shirt->price}}<!-- DESCONTO <span>70.00</span>--></h3> 
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Tamanho:</span>
                                    <label class="radio" for="xsm">xs
                                        <input type="radio" id="xsm">
                                    </label>
                                    <label class="radio" for="sm">s
                                        <input type="radio" id="sm">
                                    </label>
                                    <label class="radio" for="m">m
                                        <input type="radio" id="m">
                                    </label>
                                    <label class="radio" for="l">l
                                        <input type="radio" id="l">
                                    </label>
                                    <label class="radio" for="xl">xl
                                        <input type="radio" id="xl">
                                    </label>
                                </div>
                            </div>
                            <div class="product__details__option">
                                <div class="product__details__option__color" style = "max-width: 550px;">
                                    <span>Cores:</span>
                                    @foreach($cores as $cor)
                                        <label onclick="changeOpacity(this); changeImg(this)" class="cor-label" title="{{$cor->name}}" for="{{$cor->code}}" 
                                        style="background-color:#{{$cor->code}}; opacity:{{$cor->code === $cores[0]->code ? '1' : '0.4'}}">
                                            <input type="radio" class ="cor-radio" name="cor" id="{{$cor->code}}">
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                                <a href="#" class="primary-btn">Adicionar ao Carrinho</a>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Checkout Seguro</span></h5>
                                <img src="{{ asset('img/payment.png')}} " alt="">
                                <ul>
                                    <li><h6 style="font-weight: bold;">Categoria: {{ empty($t_shirt->categoria->name) ? 'Sem Categoria' : $t_shirt->categoria->name}}</h6></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" style="font-size: 1.6rem;" data-toggle="tab" href="#tabs-5"
                                    role="tab">Descrição</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">{{ $t_shirt->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
            function changeOpacity(label) {
                const labels = document.querySelectorAll('.cor-label');

                labels.forEach(l => {
                    if (l === label) {
                        l.style.opacity = 1; // Altera a opacidade da label clicada para 1 (100%)
                    } else {
                        l.style.opacity = 0.4; // Redefine a opacidade das outras labels para 0.4 (40%)
                    }
                });
            }

            function changeImg(label){
                var shirtImageEsq = document.getElementById('tshirtBaseEsq');
                var shirtImage = document.getElementById('tshirtBase');
                var path = "/storage/tshirt_base/" + label.htmlFor + ".jpg";
                shirtImageEsq.style.backgroundImage = `url(${path})`
                console.log(path)
                shirtImage.src = path
            }

            window.addEventListener('load', function() {

                var canvas = document.getElementById('myCanvas');
                var canvasContainer = document.querySelector('.canvas-container');
                var img = document.querySelector('.canvas-container img');
                var context = canvas.getContext("2d");

                var imagem = new Image();
                var id = "{{$t_shirt->customer_id}}";

                imagem.src = "{{ empty($t_shirt->customer_id) ? "/storage/tshirt_images/{$t_shirt->image_url}" : 
                    route('imagem_user', ['image_url' => $t_shirt->image_url, 'user_id' => $t_shirt->customer_id, 'nome_tshirt' => $t_shirt->name])}}";
                
                canvas.width = img.offsetWidth / 2;
                canvas.height = img.offsetHeight / 2;
                
                imagem.onload = function() {
                    var ratio = Math.min(canvas.width / imagem.width, canvas.height / imagem.height);
                    var newWidth = imagem.width * ratio;
                    var newHeight = imagem.height * ratio;
                    var offsetX = (canvas.width - newWidth) / 2;
                    var offsetY = (canvas.height - newHeight) / 2;

                    context.drawImage(imagem, 0, 0, imagem.width, imagem.height, offsetX, offsetY, newWidth, newHeight);
                };

            });
    </script>
    <!-- Shop Details Section End -->
@endsection