<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="utf-8">
    <!-- Primary Meta Tags -->
    <title>{{ __('seo.landing_page.title') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="title" content="{{ __('seo.landing_page.meta_title') }}">
    <meta content="{{ __('seo.landing_page.meta_keywords') }}" name="keywords">
    <meta name="description" content="{{ __('seo.landing_page.meta_description') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://krepsinislauke.lt/">
    <meta property="og:title" content="{{ __('seo.landing_page.meta_title') }}">
    <meta property="og:description" content="{{ __('seo.landing_page.meta_description') }}">
    <meta property="og:image" content="{{ asset('img/basketball-evening.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="{{ asset('img/basketball-evening.jpg') }}">
    <meta property="twitter:url" content="https://krepsinislauke.lt/">
    <meta property="twitter:title" content="{{ __('seo.landing_page.meta_title') }}">
    <meta property="twitter:description" content="{{ __('seo.landing_page.meta_description') }}">
    <meta property="twitter:image" content="{{ asset('img/basketball-evening.jpg') }}">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('img/favicon.ico') }}" rel="shortcut icon">

    <!-- Bootstrap CSS File -->
    <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="{{ asset('lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H07DPEC7BN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-H07DPEC7BN');
    </script>

    <!-- Main Stylesheet File -->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
</head>

<body>

<!--==========================
  Header
============================-->
<header id="header">
    <div class="container-fluid">

        <div id="logo" class="pull-left">
            <h1><a href="#intro" class="scrollto">KREPSINISLAUKE.LT</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
        </div>

        <nav id="nav-menu-container">
            <ul class="nav-menu">
                <li><a href="/login"><i class="fa fa-user fa-icon"></i> {{ __('main.login') }}</a></li>
                <li><a href="/register"><i class="fa fa-user-plus fa-icon"></i> {{ __('main.register') }}</a></li>
            </ul>
        </nav><!-- #nav-menu-container -->
    </div>
</header><!-- #header -->

<!--==========================
  Intro Section
============================-->
<section id="intro">
    <div class="intro-container">
        <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

            <ol class="carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

                <div class="carousel-item active">
                    <div class="carousel-background"><img src="{{ asset('img/basketball-evening.jpg') }}" alt="Krepsinis lauke"></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2>Krepšinio aikštelių aprašymai</h2>
                            <p>Prisijungę prie sistemos rasite detaliai aprašytas krepšinio aikšteles.</p>
                            <a href="/register" class="btn-get-started">Registruotis <i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="carousel-background"><img src="{{ asset('img/one-player.jpg') }}" alt="Krepsinio organizavimas"></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2>Atsibodo vienam mėtyti į krepšį?</h2>
                            <p>Prisijunk prie mūsų sistemos ir surasi bendraminčių.</p>
                            <a href="/register" class="btn-get-started">Registruotis <i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
</section><!-- #intro -->

<main id="main">

    <!--==========================
      Featured Services Section
    ============================-->
    <section id="featured-services">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 box">
                    <i class="ion-ios-albums-outline"></i>
                    <h4 class="title"><a href="">Krepšinio aikštelių sąrašai</a></h4>
                    <p class="description">Prisijungę rasite detalius krepšinio aikštelių aprašymus.</p>
                </div>

                <div class="col-lg-4 box box-bg">
                    <i class="ion-ios-cloud-outline"></i>
                    <h4 class="title"><a href="">Oras krepšiniui?</a></h4>
                    <p class="description">Prisijungę galite pasitikrinti ar oras tinkamas krepšiniui.</p>
                </div>

                <div class="col-lg-4 box">
                    <i class="ion-ios-calendar-outline"></i>
                    <h4 class="title"><a href="">Susiplanuokite iš anksto</a></h4>
                    <p class="description">Prisijungę galėsite matyti žaidėjų srautus prie kiekvienos aikštelės.</p>
                </div>

            </div>
        </div>
    </section><!-- #featured-services -->
    <section id="about">
        <div class="container">

            <header class="section-header">
                <h3>Krepšinio aikštelių pristatymas</h3>
                <p>Trumpa informacija apie keletą atsitiktinių krepšinio aikštelių aprašytų mūsų kataloge.</p>
            </header>

            <div class="row about-cols">
                @foreach($courtsCollection as $court)
                    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="about-col">
                            <div class="img">
                                <img src="{{ $court->image_path }}" alt="" class="img-fluid">
                                <div class="icon"><i class="ion-ios-basketball-outline"></i></div>
                            </div>
                            <h2 class="title"><a href="register">{{ $court->name }}</a></h2>
                            @if (!$court->is_eligible_weather)
                                <p>
                                    Šiuo metu oras <b>nėra</b> tinkamas krepšiniui šioje aikštelėje. Daugiau informacijos
                                    rasite prisijungę.
                                </p>
                            @endif
                            <p>
                                {{ $court->description }}
                            </p>
                            <p class="text-center">
                                {{ $court->address }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section><!-- #about -->

    <!--==========================
  Facts Section
============================-->
    <section id="facts"  class="wow fadeIn">
        <div class="container">

            <header class="section-header">
                <h3>Statistika</h3>
                <p>Trumpa statistika apie mūsų sistemoje esančius duomenis.</p>
            </header>

            <div class="row counters">

                <div class="col-lg-4 col-6 text-center">
                    <span data-toggle="counter-up">{{ $userCount }}</span>
                    <p>Vartotojai</p>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <span data-toggle="counter-up">{{ $courtsCount }}</span>
                    <p>Aprašytos krepšinio aikštelės</p>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <span data-toggle="counter-up">{{ $commentsCount }}</span>
                    <p>Komentarai</p>
                </div>

            </div>

            <div class="facts-img">
                <img src="img/facts-img.png" alt="" class="img-fluid">
            </div>

        </div>
    </section><!-- #facts -->
</main>

<!--==========================
  Footer
============================-->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-info">
                    <h3>KREPSINISLAUKE.LT</h3>
                    <p>Detalūs krepšinio aikštelių aprašymai.</p>
                    <p>Sistemos pagalba lengvai išsirinksite krepšinio aikštelę.</p>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Nuorodos</h4>
                    <ul>
                        <li><i class="ion-ios-arrow-right"></i> <a href="/register">Registruotis</a></li>
                        <li><i class="ion-ios-arrow-right"></i> <a href="/login">Prisijungti</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h4>Socialiniai tinklai</h4>
                    <div class="social-links">
                        <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                    </div>

                </div>

                <div class="col-lg-3 col-md-6 footer-newsletter">
                    <h4>Kontaktai</h4>
                    <p>Šiuo metu kontaktinė informacija neteikiama.</p>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; 2020 Copyright <strong>KrepsinisLauke.Lt</strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://krepsinislauke.lt/">KrepsinisLauke.lt</a>
        </div>
    </div>
</footer><!-- #footer -->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
<div id="preloader"></div>

<!-- JavaScript Libraries -->
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jquery/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/superfish/hoverIntent.js') }}"></script>
<script src="{{ asset('lib/superfish/superfish.min.js') }}"></script>
<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('lib/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>
<script src="{{ asset('lib/touchSwipe/jquery.touchSwipe.min.js') }}"></script>

<!-- Template Main Javascript File -->
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
