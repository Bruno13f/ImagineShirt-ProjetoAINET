<!DOCTYPE html>
<html lang="PT">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="ImagineShirt Website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ImagineShirt {{ ucfirst($dados['titulo'] ?? '') }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])

    <!-- Css Styles 
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">-->
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
            @guest
                <a href="{{route('login')}}">Login</a>
                <a href="{{route('register')}}">Registar</a>
            @else
            <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle img-responsive" style="margin-left: 10px; max-width: 70px; border: solid #e63334 1px" alt="Avatar"/>
            @endguest
            </div>
            <div class="offcanvas__top__hover">
                <span>EUR €</span>
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="{{ route('logout') }}"><img src="img/icon/cart.png" alt=""> <span>0</span></a>
            <div class="price">0.00€</div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Bem vindo à <span style="font-weight: bolder;">ImagineShirt</span></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">
                            @guest
                                <a href="{{route('login')}}">Login</a>
                                <a href="{{route('register')}}">Registar</a>
                            @else
                                <a href="{{route('logout')}}">Logout</a>
                            @endguest
                            </div>
                            <div class="header__top__hover">
                                <span>EUR €</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="{{ route('root') }}"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li {{ ucfirst($dados['active1'] ?? '') }}><a href="{{ route('root') }}">Página Inicial</a></li>
                            <li {{ ucfirst($dados['active2'] ?? '') }}><a href="{{ route('t-shirts') }}">T-Shirts</a></li>
                            <li {{ ucfirst($dados['active3'] ?? '') }}><a href="./contactos.html">Contactos</a></li>
                            <li {{ ucfirst($dados['active4'] ?? '') }}><a href="./about.html">Sobre Nós</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a><img src="img/icon/cart.png" alt=""><span>0</span></a>
                        <div class="price">0.00€</div>
                    @guest
                    @else
                        <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle img-responsive" style="margin-left: 10px; max-width: 60px; border: solid #e63334 1px" alt="Avatar"/>
                    @endguest
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

    @yield('main')

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="img/footer-logo.png" alt=""></a>
                        </div>
                        <p>O cliente é o coração da nossa loja</p>
                        <a href="#"><img src="img/payment.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Loja</h6>
                        <ul>
                            <li><a href="{{ route('t-shirts') }}">T-Shirts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Informações</h6>
                        <ul>
                            <li><a href="./contactos.html">Localização</a></li>
                            <li><a href="./contactos.html">Contactos</a></li>
                            <li><a href="./contactos.html">Envio</a></li>
                            <li><a href="./about.html">Sobre Nós</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewsLetter</h6>
                        <div class="footer__newslatter">
                            <p>Sê o primeiro a ser notificado das novidades da loja</p>
                            <form action="#">
                                <input type="text" placeholder="Email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            - All rights reserved
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Pesquisar.....">
            </form>
        </div>
    </div>
    <!-- Search End -->
</body>

</html>