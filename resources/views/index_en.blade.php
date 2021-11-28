<!DOCTYPE html>
<html   lang="en" >

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>My Bill</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Favicons -->
    <link href="{{ asset('assets/frontend/assets/img/icon-mybill.png')}}" rel="icon">
    <link href="{{ asset('assets/frontend/assets/img/icon-mybill.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/frontend/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/frontend/glightbox/css/glightbox.min.css')}}">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/frontend/assets/css/style.css')}}" rel="stylesheet">

</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <h1><a href="{{route('index_en')}}"><img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" alt=""> <span style="font-size: 20px;">MY BILL</span></a></h1>
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#features">Features</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#about">Slides</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#team">who are we</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#why">why us</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#footer">Contact Us</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="{{route('index')}}"><button type="button" class="btn btn-primary text-light">Arabic</button></a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero">

    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                <div data-aos="zoom-out text-justify">
                    <h1>E-Bill with QR system<br><span>MY BILL</span></h1>
                    <h2>Is a specialized system and application that converts paper bills into electronic invoices using QR rapid response code technology, which helps to reduce the consumption of paper bills, whether bank bills or purchase bills, and the sale of goods and services, among other things, while also preserving the environment</h2>
                    <div class="text-center text-lg-start">
                        <a href="#about" class="btn-get-started scrollto">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-8 col-sm-10  order-1 order-lg-2 hero-img d-flex align-items-center justify-content-center" data-aos="zoom-out" data-aos-delay="300">
                <img src="{{asset('assets/frontend/img/mobile.png')}}" class="img-fluid animated" style="height: 460px; border-radius:25px;" alt="">
            </div>
        </div>
    </div>

    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
        <defs>
            <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
        </defs>
        <g class="wave1">
            <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
        </g>
        <g class="wave2">
            <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
        </g>
        <g class="wave3">
            <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
        </g>
    </svg>

</section><!-- End Hero -->

<main id="main">


    <!-- ======= Features Section ======= -->
    <section id="features" class="features pt-3">
        <div class="container">

            <div class="section-title text-center" data-aos="fade-up">
                <!-- <h2>Features</h2> -->
                <h2></h2>
                <p>Features</p>
            </div>

            <div class="row" data-aos="fade-left">
                <div class="col-lg-3 col-md-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="50">
                        <i class="ri-bill-line" style="color: #ffbb2c;"></i>
                        <h3><a href="">Invoice electronically save</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                        <i class="ri-printer-line" style="color: #5578ff;"></i>
                        <h3><a href="">lowering printing costs</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="150">
                        <i class="ri-hand-coin-line" style="color: #e80368;"></i>
                        <h3><a href="">ecologically friendly</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-lg-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
                        <i class="ri-smartphone-line" style="color: #e361ff;"></i>
                        <h3><a href="">app to save paper bills</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="250">
                        <i class="ri-apps-line" style="color: #47aeff;"></i>
                        <h3><a href="">All smartphones are supported.</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
                        <i class="ri-todo-fill" style="color: #ffa76e;"></i>
                        <h3><a href="">service for tracking user expenses</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="350">
                        <i class="ri-barcode-line" style="color: #11dbcf;"></i>
                        <h3><a href="">Barcode scanner service for products</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="400">
                        <i class="ri-qr-code-line" style="color: #4233ff;"></i>
                        <h3><a href="">Invoice QR Scanner Service</a></h3>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Features Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch" style="background: url({{asset('assets/frontend/img/img2.png')}}) center center no-repeat;" data-aos="fade-right">
                    <a href="#" class="glightbox venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>
                </div>

                <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5" data-aos="fade-left">
                    <h3>Slides</h3>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">

                        <h4 class="title"><a href="">There is no need for users to register.</a></h4>
                        <p class="description">It is not necessary to register with the invoicing providers ahead of time. All the user has to do is sign up for the app and save their information</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">

                        <h4 class="title"><a href="">Handling easiness</a></h4>
                        <p class="description">Only billing providers require a control panel that converts invoice data to QR, after which the user scans the code and displays the invoice, and each user has their own barcode</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">

                        <h4 class="title"><a href="">Flexibility in Settings</a></h4>
                        <p class="description">Service providers can use several invoice templates and can add all information about its facility from a logo, website and external links</p>
                    </div>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
        <div class="container">

            <div class="row content">
                <div class="col-md-4 " data-aos="fade-right">
                    <img src="{{asset('assets/frontend/assets/img/details-1.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-5  p-4 " data-aos="fade-up">
                    <h3 style="font-size:18px !important">My bill is also used to convert paper bank bills into electronic invoices, but only at ATMs where you can choose to download the receipt electronically by scanning the QR code</h3>
                    <p class="fst-italic">
                        All ONLINE services be integrated into a single platform and application <br>
                        Using QR technology, integrating plastic cards, including banking and commercial cards, into a digital card.
                    </p>
                    <ul>
                        <li class="font-weight"><i class="bi bi-check"></i>Speed</li>
                        <li class="font-weight"><i class="bi bi-check"></i> Safety</li>
                        <li class="font-weight"><i class="bi bi-check"></i>rotection</li>
                    </ul>

                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="{{asset('assets/frontend/assets/img/details-2.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-5 order-2 order-md-1 p-4" data-aos="fade-up">
                    <h3>The QR code mobile becomes the sole source of e-bill, trade, and mobile money trading.</h3>
                    <br> <p class="fst-italic">
                        My Bill app, which provides new algorithms that enter all hypermarkets smart stores via QR code, converts traditional stores to smart stores without incurring high costs or technical complexities.
                    </p>
                    <p>

                    </p>

                </div>
            </div>

            <div class="row content">
                <div class="col-md-4" data-aos="fade-right">
                    <img src="{{asset('assets/frontend/assets/img/details-3.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-3 mt-5 p-4" data-aos="fade-up">
                    <br><br><br><h3>For Marketing purposes</h3> <br>
                    <p>Through modern and thoughtful marketing ideas, the application can be used for marketing purposes and to improve the business process between companies and their customers</p>
                    <p>

                    </p>
                    <br>
                    <br>
                    <p>QR technology will become a daily use of people's needs because it saves time, effort, and money, provides paper circulation, and protects everyone from contact with in-kind materials, in addition to health safety, and can integrate many services in the future</p>

                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="{{asset('assets/frontend/assets/img/details-4.png')}}" class="img-fluid" alt="">
                </div>

                <div class="col-md-8 pt-3 order-2 order-md-1 p-4" data-aos="fade-up">
                    <br><br><br><h3>Smart Stores</h3>
                    <p class=" fw-normal smart-store-content mt-4 ">
                        MY Bill can create smart purchase transactions by converting traditional stores into smart stores where the user can shop in-store and scan products where the system will offer the user two options to display product details or add the product to the electronic shopping cart and when the user is finished shopping the user can pay the bill without going to the cashier because the market verification process is carried out with the appearance of a green barcode that the customer paid for all the products in the basket where a device installed at the top of the shopping cart automatically scans to a product entering the cart. Furthermore, the red color indicates that the shopper did not pay the bill.
                    </p>
                    <br>
                    <p class="smart-store-content mt-4">
                        BILL MY allows users to obtain their original invoices using CODE QR technology, allowing you to obtain the invoice without having to record any user-specific data.
                    </p>

                </div>
            </div>

        </div>
    </section><!-- End Details Section -->

     <!-- ======= Testimonials Section ======= -->
     <section id="testimonials" class="testimonials">
        <div class="container">

          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                    <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                  </div>
                  <h3>Graphic design</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>Web and applications Development</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>System Development</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>Elctronic systems Development</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>Making and Editing videos</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>Online marketing</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>Content moderating</h3>
                </div>
              </div><!-- End testimonial item -->

            </div>
            <div class="swiper-pagination"></div>
          </div>

        </div>
      </section><!-- End Testimonials Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container">

            <div class="row" data-aos="fade-up">

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-emoji-smile"></i>
                        <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Customer</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                    <div class="count-box">
                        <i class="bi bi-journal-richtext"></i>
                        <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Projects</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-headset"></i>
                        <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
                        <p>hours of support</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-people"></i>
                        <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Hard Workers</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Counts Section -->




    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
        <div class="container">

            <div class="section-title text-center"text-center data-aos="fade-up">
                <!-- <h2>Team</h2> -->
                <h2></h2>
                <p>What are we exactly?</p>
            </div>

            <div class="row text-lg-center p4 fw-light" data-aos="fade-left">
                <p class="fw-light about-us-content p-3 m-2" style="font-size: 19px; !important">Since 2013, we have been a Saudi company specializing in media and technology, designing and programming websites, systems, and applications for smartphones. We are in the early media and are always looking for a specific and clear goal, which is to attract as many customers as possible to your company, publicize it, and increase profits. We are founded on creativity and excellence in marketing and electronic media by our current team, which has extensive experience and professionalism in the field of funded electronic media since its beginnings in 2010.
                </p>
                <p class="fw-light about-us-content p-3 m-2" style="font-size: 19px; !important">
                    We have also distinguished ourselves in the field of electronic media in Saudi Arabia due to our professional designs and these qualities. We have a team of expert programmers in web development, electronic systems, and smartphone applications.You have gained a partner who can provide you with integrated solutions tailored to your needs as well as capabilities that will assist you in achieving your goals in a direct and timely manner by selecting the first media.We are on a mission to create the most creative and innovative content possible, and we are proud to offer our services in e-marketing, graphic design, electronic systems programming, and applications
                </p>
                <br><br>

            </div>

        </div>
    </section><!-- End Team Section -->

    <section id="why" class="team">
        <div class="container">

            <div class="section-title text-center"text-center data-aos="fade-up">
                <!-- <h2>Team</h2> -->
                <h2></h2>
                <p>What distinguishes us?</p>
            </div>

            <div class="row text-lg-center p4 fw-light" data-aos="fade-left">
                <p class="fw-light about-us-content" style="font-size: 19px; !important">A Sohora puls group that works to build professional projects by fortifying relationships, improving communication, and documenting strategic alliances. We bring together competencies in time for your projects to facilitate payment and provide a well-known plus clear and transparent price structure to ensure that there are no hidden costs associated with establishment or operation.In addition, develop a project vision that is appropriate for your budget. Continuous
                </p>




            </div>

        </div>
    </section><!-- End Team Section -->


    <!-- ======= F.A.Q Section ======= -->



    <section id="soon" class="soon">
        <div class="container">

            <div class="section-title text-center" data-aos="fade-up">
                <p>Available</p>
            </div>



            <div class="row">
                <div class="col-md-6 p-3 ">
                    <h3 class="fw-light">MY BILL will is now available on Androind and IOS Devices</h3>
                    <div class="app d-flex flex-column align-items-center justify-content-center">
                        <a href="https://www.google.com"><img src="{{asset('assets/frontend/img/app (1).png')}}" alt="" class="img-fluid mt-5 d-block"></a>
                        <a href="https://www.youtube.com"><img src="{{asset('assets/frontend/img/app (2).png')}}" alt="" class="img-fluid "></a>

                    </div>


                </div>
                <div class="col-md-6 d-flex justify-content-center align-items-center">

                    <img src="{{asset('assets/frontend/img/mobile.png')}}" alt="" class="img-fluid" style="height: 460px; border-radius:25px;" >

                </div>
            </div>



        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <h3>MY BILL</h3>
                        <p class="pb-3"><em>E-Bill With QR system</em></p>
                        <p>
                            Amman
                            <br>
                            Riyadh
                            <br>
                            USA
                            <br>
                            <br>
                            <strong>Phone:</strong> +966565185991<br>
                            <strong>Email:</strong> manager@jo-mybill.com<br>
                        </p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 footer-links align-items-center">
                    <h4>links</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">About</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Features</a></li>

                        <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>ٍServices</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">graphic design</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Web and applications Development</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">System Development</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Elctronic systems Development</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Making and Editing videos</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Online marketing</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">content moderating</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>MY BILL</span></strong>. All Rights Reserved
        </div>

    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="{{asset('assets/frontend/assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('assets/frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('assets/frontend/assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('assets/frontend/assets/vendor/purecounter/purecounter.js')}}"></script>
<script src="{{asset('assets/frontend/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/glightbox/js/glightbox.min.js')}}"></script>
<script>
    const lightbox = GLightbox({
        'href': 'https://youtu.be/GNu6sfchg6Q',
        'type': 'video',
        'source': 'youtube', //vimeo, youtube or local
        'width': 900,
    });
</script>

<!-- Template Main JS File -->
<script src="{{asset('assets/frontend/assets/js/main.js')}}"></script>

</body>

</html>
