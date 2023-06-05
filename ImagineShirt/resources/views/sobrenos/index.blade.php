@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => '',
                                        'active4' => 'class = active']]) 

@section('titulo',' | Sobre Nos')

@section('main')

<section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Sobre nós</h4>
                        <div class="breadcrumb__links">
                            <a href="./paginaInicial.html">Página Inicial</a>
                            <span>Sobre nós</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about__pic">
                        <img src="img/about/about-us.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Quem somos ?</h4>
                        <p>...</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>O que fazemos ?</h4>
                        <p>...</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Porque escolher-nos?</h4>
                        <p>...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Counter Section Begin -->
    <section class="counter spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number">
                            <h2 class="cn_num">102</h2>
                        </div>
                        <span>Total de<br />Clientes</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number">
                            <h2 class="cn_num">30</h2>
                        </div>
                        <span>Total de <br />Categorias</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number">
                            <h2 class="cn_num">102</h2>
                        </div>
                        <span>No <br />País</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number">
                            <h2 class="cn_num">98</h2>
                            <strong>%</strong>
                        </div>
                        <span>Clientes <br />Satisfeitos</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- Client Section Begin -->
    <section class="clients spad" style = "margin-top: 2%;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Parceiros</span>
                        <h2>Clientes Satisfeitos</h2>
                    </div>
                </div>
            </div>
            <div class="row" style = "justify-content: center;">
                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                    <a href="#" class="client__item"><img src="img/clients/client-1.png" alt=""></a>
                </div>
            </div>
        </div>
    </section>
    <!-- Client Section End -->

@endsection
