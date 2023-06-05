@extends('template.layout', ['dados' => ['active1' => '',
                                        'active2' => '',
                                        'active3' => 'class = active',
                                        'active4' => '']]) 

@section('titulo',' | Contactos')

@section('main')

 <!-- Map Begin -->
 <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3068.2627557403466!2d-8.823936573542053!3d39.73374824692402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22735a4e067afb%3A0xcfaf619f4450fa76!2sPolit%C3%A9cnico%20de%20Leiria%20%7C%20ESTG%20-%20Escola%20Superior%20de%20Tecnologia%20e%20Gest%C3%A3o_Edif%C3%ADcio%20D!5e0!3m2!1spt-PT!2spt!4v1685374159399!5m2!1spt-PT!2spt" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-- Map End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__text">
                        <div class="section-title">
                            <span>Informação</span>
                            <h2>Contacte-nos</h2>
                            <p>Para obter informação sobre o envio e politicas de devolução.</p>
                        </div>
                        <ul>
                            <li>
                                <h4>Portugal</h4>
                                <p>Campus 2 - Morro do Lena, Alto do Vieiro, Apt 4163, Edifício D, 2411-901 Leiria <br />+351 244820300</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Nome">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Email">
                                </div>
                                <div class="col-lg-12">
                                    <textarea placeholder="Messagem"></textarea>
                                    <button type="submit" class="site-btn">Enviar Mensagem</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection