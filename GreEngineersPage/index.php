<?php
    session_start();
    if($_SESSION['user'] != 0){
        $stateSesion = 1;
    }
    else{
        $stateSesion = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">

    <title>GreEngineer</title>

    <!--

Breezed Template

https://templatemo.com/tm-543-breezed

-->
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-breezed.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css">

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky" style="background-color: #f7f7f7; width: auto; height: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">
                            GreEngineer's
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Inicio</a></li>
                            <li class="scroll-to-section"><a href="#about">Nosotros</a></li>
                            <li class="scroll-to-section"><a href="#projects">Entre todos</a></li>
                            <li class="submenu">
                                <a href="javascript:;">Tienda</a>
                                <ul>
                                    <li><a href="tienda-online-section.html">Tienda Online</a></li>
                                    <li><a href="suscripciones-section.html">Suscripciones</a></li>
                                    <li><a href="eventos-section.html">Eventos</a></li>
                                    <li><a href="cursos-section.html">Cursos</a></li>
                                </ul>
                            </li>
                            <li class="scroll-to-section"><a href="#contact-us">Contactanos</a></li>
                            <div class="search-icon">
                                <a href="#search"><i class="fa fa-search" style="color: #5fb759; margin-top: 11px;"></i></a>
                            </div>
                            <div class="market-icon">
                                <a href=""><i class="fa fa-cart-plus" style="color: #5fb759; margin-right: 10px;"></i></a><label style="color: orange;">0</label>
                            </div>
                            <div class="market-icon">
                                <a href="login.php"><i class="fa fa-user" style="color: <?php if($stateSesion == 1) {echo "#5fb759";} else {echo "black";} ?> ; margin-right: 10px; margin-top: 11px;"></i></a>
                            </div>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Search Area ***** -->
    <div id="search">
        <button type="button" class="close">×</button>
        <form id="contact" action="#" method="get">
            <fieldset>
                <input type="search" name="q" placeholder="Palabra(s) Clave" aria-label="Search through site content">
            </fieldset>
            <fieldset>
                <button type="submit" class="main-button">Buscar</button>
            </fieldset>
        </form>
    </div>

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner header-text" id="top">
        <div class="Modern-Slider">
            <!-- Item -->
            <div class="item">
                <div class="img-fill">
                    <img src="assets/images/slide-01.png" alt="">
                    <div class="text-content">
                        <h5>¡Bienvenido!</h5>
                        <a href="#" class="main-filled-button">Suscribete</a>
                    </div>
                </div>
            </div>
            <!-- // Item -->
            <!-- Item -->
            <div class="item">
                <div class="img-fill">
                    <img src="assets/images/slide-02.png" alt="">
                    <div class="text-content">
                        <a href="#projects" class="main-filled-button">Explora más</a>
                    </div>
                </div>
            </div>
            <!-- // Item -->
            <!-- Item -->
            <div class="item">
                <div class="img-fill">
                    <img src="assets/images/slide-03.png" alt="">
                    <div class="text-content">
                        <a href="#about" class="main-filled-button">Acerca de...</a>
                    </div>
                </div>
            </div>
            <!-- // Item -->
        </div>
    </div>
    <div class="scroll-down scroll-to-section"><a href="#about"><i class="fa fa-arrow-down"></i></a></div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Nosotros</h6>
                            <h2>No somos una empresa, somos una comunidad</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/service-item-02.png" alt="">
                                    <h4>Confiable</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/service-item-03.png" alt="">
                                    <h4>Responsable</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/service-item-04.png" alt="">
                                    <h4>Emprendedora</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/service-item-01.png" alt="">
                                    <h4>Innovadora</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="right-text-content">
                        <p>“Una Planta a la Vez” no somos una empresa de 4 personas, somos una comunidad que comparte el
                            gusto por las plantas, la creencia ferviente de que los pequeños cambios hacen la diferencia
                            y que lo bueno tiene raíces tan largas como se puede imaginar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <!-- ***** Features Big Item End ***** -->


    <!-- ***** Projects Area Starts ***** -->
    <section class="section" id="projects">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="section-heading">
                        <h6>Entre todos</h6>
                        <h2>Unete como colaborador</h2>
                    </div>
                    <div class="filters">
                        <ul>
                            <li class="active" data-filter="*">Todo</li>
                            <li data-filter=".des">Selección</li>
                            <li data-filter=".dev">Siembra</li>
                            <li data-filter=".gra">Cosecha</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="filters-content">
                        <div class="row grid">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 all des">
                                <div class="item">
                                    <a href="assets/images/seleccion-item-01.jpeg" data-lightbox="image-1"
                                        data-title="Proyecto: Entre Todos"><img
                                            src="assets/images/seleccion-item-01.jpeg" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 all dev">
                                <div class="item">
                                    <a href="assets/images/siembra-item-01.jpeg" data-lightbox="image-1"
                                        data-title="Proyecto: Entre Todos"><img src="assets/images/siembra-item-01.jpeg"
                                            alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 all gra">
                                <div class="item">
                                    <a href="assets/images/cosecha-item-01.jpeg" data-lightbox="image-1"
                                        data-title="Proyecto: Entre Todos"><img src="assets/images/cosecha-item-01.jpeg"
                                            alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 all dev">
                                <div class="item">
                                    <a href="assets/images/siembra-item-02.jpeg" data-lightbox="image-1"
                                        data-title="Proyecto: Entre Todos"><img src="assets/images/siembra-item-02.jpeg"
                                            alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 all des">
                                <div class="item">
                                    <a href="assets/images/seleccion-item-02.jpeg" data-lightbox="image-1"
                                        data-title="Proyecto: Entre Todos"><img
                                            src="assets/images/seleccion-item-02.jpeg" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 all gra">
                                <div class="item">
                                    <a href="assets/images/cosecha-item-02.jpeg" data-lightbox="image-1"
                                        data-title="Proyecto: Entre Todos"><img src="assets/images/cosecha-item-02.jpeg"
                                            alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Projects Area Ends ***** -->

    <!-- ***** Testimonials Starts ***** -->
    <section class="section" id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2 style="color: black;">Miembros</h2>
                        <h2 style="color: black;">"young and talented members"</h2>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mobile-bottom-fix-big"
                    data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                    <div class="owl-carousel owl-theme">
                        <div class="item author-item">
                            <div class="member-thumb">
                                <img src="assets/images/member-item-01.jpeg" alt="">
                                <div class="hover-effect">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h4 style="color: black;">.01 Ana Herrera</h4>
                            <span style="color: black;">Digital Marketer</span>
                        </div>
                        <div class="item author-item">
                            <div class="member-thumb">
                                <img src="assets/images/member-item-02.jpeg" alt="">
                                <div class="hover-effect">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h4 style="color: black;">.02 Salma Odalys</h4>
                            <span style="color: black;">Site Analyst</span>
                        </div>
                        <div class="item author-item">
                            <div class="member-thumb">
                                <img src="assets/images/member-item-03.jpeg" alt="">
                                <div class="hover-effect">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h4 style="color: black;">.03 Juan</h4>
                            <span style="color: black;">Digital Influencer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Testimonials Ends ***** -->

    <!-- ***** Contact Us Area Starts ***** -->
    <section class="section" id="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Contactanos</h6>
                            <h2>Mandanos tu duda o tus experiencias</h2>
                        </div>
                        <ul class="contact-info">
                            <li><img src="assets/images/contact-info-01.png" alt="">449-990-6696</li>
                            <li><img src="assets/images/contact-info-02.png" alt="">salma_9910@hotmail.com</li>
                            <li><img src="assets/images/contact-info-03.png" alt="">www.unaplantalavez.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-xs-12">
                    <div class="contact-form">
                        <form id="contact" action="" method="get">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" id="name" placeholder="Tu nombre *" required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="phone" type="text" id="phone" placeholder="Tu teléfono"
                                            required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="email" id="email"
                                            placeholder="Tu correo electronico *" required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="subject" type="text" id="subject" placeholder="Asunto">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" id="message" placeholder="Mensaje"
                                            required=""></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button-icon">Mandar mensaje
                                            <i class="fa fa-arrow-right"></i></button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Contact Us Area Ends ***** -->

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="left-text-content">
                        <p>Copyright &copy; 2021 GreEngineer's

                            - Design: <a rel="nofollow noopener" href="https://templatemo.com">TemplateMo</a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <div class="right-text-content">
                        <ul class="social-icons">
                            <li>
                                <p>Síguenos </p>
                            </li>
                            <li><a rel="nofollow" href="https://fb.com/templatemo"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a rel="nofollow" href="https://fb.com/templatemo"><i class="fa fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/isotope.js"></script>

    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

    <script>

        $(function () {
            var selectedClass = "";
            $("p").click(function () {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function () {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);

            });
        });

    </script>

</body>

</html>