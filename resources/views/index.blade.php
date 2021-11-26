<!DOCTYPE html>
<html  dir="rtl" lang="ar" >

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
            <h1><a href="{{route('index')}}"><img src="{{asset('assets/frontend/img/my_bill_logo.png')}}"  alt=""> <span style="font-size: 20px;">MY BILL</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar navbar-mobile_ar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">الرئيسية</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#features">المميزات</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#about">النقاط توضـيحية</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#team">من نحن</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#why">لماذا نحن</a></li>
                <li><hr></li>
                <li><a class="nav-link scrollto" href="#footer">أتصل بنا</a></li>
                <li><hr></li>

                <li><a class="nav-link scrollto" href="{{route('index_en')}}"><button type="button" class="btn btn-primary text-light">الأنجليزية</button></a></li>
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
                <div data-aos="zoom-out">
                    <h1>الفاتورة الإلكترونية بنظام الـ QR <br><span>MY BILL</span></h1>
                    <h2 class="mt-5 text-justify">عبارة عن نظام و تطبيق متخصص بتحويل الفاتورة الورقية الى فاتورة
                        إلكترونية عبر تقنية QR رمز االستجابة السريع, وذلك يساعد على توفير استهالك
                        الفواتير الورقية سواء كانت فواتير البنوك المصرفية أو فواتير الشراء وبيع السلع
                        وغيرها عدا عن المحافظة على البيئة .</h2>
                    <div class="text-center text-lg-end">
                        <a href="#about" class="btn-get-started scrollto">ابدأ الآن</a>
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
                <h2></h2>
                <p>المميزات</p>
            </div>

            <div class="row" data-aos="fade-left">
                <div class="col-lg-3 col-md-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="50">
                        <i class="ri-bill-line" style="color: #ffbb2c;"></i>
                        <h3><a href="">حفظ الفواتير إلكترونياً</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                        <i class="ri-printer-line" style="color: #5578ff;"></i>
                        <h3><a href="">توفير تكاليف الطباعة</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="150">
                        <i class="ri-hand-coin-line" style="color: #e80368;"></i>
                        <h3><a href="">صديق للبيئة</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-lg-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
                        <i class="ri-smartphone-line" style="color: #e361ff;"></i>
                        <h3><a href="">حفظ الفواتير الورقية في التطبيق</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="250">
                        <i class="ri-apps-line" style="color: #47aeff;"></i>
                        <h3><a href="">متوفر على جميع الهواتف الذكية</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
                        <i class="ri-todo-fill" style="color: #ffa76e;"></i>
                        <h3><a href="">يساعد على ادارة أموالك</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="350">
                        <i class="ri-barcode-line" style="color: #11dbcf;"></i>
                        <h3><a href="">خدمة ماسح الباركود للمنتجات</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="400">
                        <i class="ri-qr-code-line" style="color: #4233ff;"></i>
                        <h3><a href="">خدمة ماسح الQR للفاتورة</a></h3>
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

                <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5"  data-aos="fade-left">
                    <h3>النقاط توضـيحية</h3>
                    <!-- <p>Esse voluptas cumque vel exercitationem. Reiciendis est hic accusamus. Non ipsam et sed minima temporibus laudantium. Soluta voluptate sed facere corporis dolores excepturi. Libero laboriosam sint et id nulla tenetur. Suscipit aut voluptate.</p> -->

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">

                        <h4 class="title"><a href="">بدون الحاجة الى تسجيل المستخدم</a></h4>
                        <p class="description">لا يحتاج الى تسجيل مسبق عند مزودي الفاتورة كل ما يحتاجه
                            المستخدم فقط التسجيل في التطبيق وحفظ بياناته</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">

                        <h4 class="title"><a href="">سهولة في التعامل</a></h4>
                        <p class="description">بالنسبة لمزودي الفواتير فقط يتطلب الأمر حصولهم على لوحة تحكم
                            تحول بيانات الفاتورة الى QR ومن ثم يقوم المستخدم بمسح الكود
                            فتظهر له الفاتورة,ولكل مستخدم باركود خاص به </p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">

                        <h4 class="title"><a href="">المرونة في الأعدادت</a></h4>
                        <p class="description">يمكن لمزودي الخدمة استخدام عده قوالب للفاتورة وإمكانية إضافة
                            جميع المعلومات الخاصة بمنشأته من شعار وموقع إلكتروني وروابط
                            خارجية</p>
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
                    <h3>ماي بل تستخدم ايضا لتحويل الفواتير الورقية لدى البنوك الى فواتير إلكترونية فقط ألجهزة الصراف ATM
                        حيث تمكنك الخدمة من اختيار تحميل اإليصال إلكترونيا عن طريق مسح الـ QR</h3>
                    <p class="fst-italic mt-4 fst-italic-content">
                        دمج جميع الخدمات ONLINE في منصة وتطبيق واحد. <br>
                        دمج البطاقات البالستيكية منها البنكية ومنها التجارية في بطاقة
                        رقمية عبر تقنية QR.

                    </p>
                    <ul>
                        <li class="font-weight"><i class="bi bi-check"></i> أمان</li>
                        <li class="font-weight"><i class="bi bi-check"></i> حماية</li>
                        <li class="font-weight"><i class="bi bi-check"></i>سرعة</li>
                    </ul>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="{{asset('assets/frontend/assets/img/details-2.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-5 order-2 order-md-1 p-4" data-aos="fade-up">
                    <h3>يصبح الجوال عبر تقنية ال CODE QR هو المصدر الوحيد للفاتورة الإلكترونية والتجارة وتداول
                        األموال عبر الجوال </h3>
                    <br> <p class="fst-italic fst-italic-content">
                        تحويل المتاجر التقليدية لمتاجر ذكية دون تكاليف باهضة وتعقيدات تقنية وذلك عبر تطبيق ماي بل الذي
                        يوفر خوارزميات جديدة تدخل جميع متاجر الهايبر خانة المتاجر الذكية عبر الـ QR
                    </p>
                    <p>

                    </p>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 " data-aos="fade-right">
                    <img src="{{asset('assets/frontend/assets/img/details-3.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-3 mt-5 p-4" data-aos="fade-up">
                    <br><br><br><h3>عامل للتسويق</h3> <br>
                    <p class="fst-italic-content">
                        يمكن استخدام التطبيق ألغراض تسويقية وتعزيز العالمة التجارية بين الشركات وعمالئها من خالل
                        افكار تسويقية حديثة ومدروسة
                    </p>
                    <br>
                    <br>
                    <p class="fst-italic-content">تقنية الـ QR ستصبح استخدام يومي الحتياجات
                        الناس ألنها توفر الوقت والجهد والمال وتوفر تداول الوريقات
                        وتحمي الجميع من مالمسة المواد العينية باإلضافة الى األمان
                        الصحي ويمكن دمج العديد من الخدمات في المستقبل.</p>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="{{asset('assets/frontend/assets/img/details-4.png')}}" class="img-fluid" alt="">
                </div>

                <div class="col-md-8 pt-3 order-2 order-md-1 p-4" data-aos="fade-up">
                    <br><br><br><h3>المتاجر الذكية</h3>
                    <p class=" fw-normal smart-store-content mt-4">
                        يمكن لتطبيق BILL MY انشاء تعامالت شراء ذكية حيث يحول المتاجر
                        التقليدية الى متاجر ذكية حيث يمكن للمستخدم ان يقوم بالتسوق داخل المتجر
                        ويقوم بمسح المنتجات حيث سيقوم النظام بعرض خيارين على المستخدم
                        عرض تفاصيل المنتج او إضافة المنتج لعربة التسوق االلكتروني وعند
                        االنتهاء من التسوق يستطيع المستخدم دفع الفاتورة دون الذهاب للكاشير
                        حيث ان عملية التحقق سوق تتم بظهور باركود اخضر ان العميل قام بدفع
                        قيمة جميع المنتجات التي يحملها في السلة حيث يقوم جهاز مثبت في اعلى
                        عربة التسوق يقوم بمسح تلقائي الي منتج يدخل في العربة. واللون األحمر
                        يعطي ان المتسوق لم يقم بتسديد الفاتورة
                    </p>
                    <br>
                    <p>
                        تطبيق BILL MY يتيح للمستخدمين الحصول على فواتيرهم
                        األصلية عبر تقنية CODE QR مما يتيح الحصول على الفاتورة
                        مباشرة دون الحاجة لتسجيل أي بيانات خاصة للمستخدم.
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
                  <h3>تصميم الجرافيك</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>برمجة الويب و التطبيقات</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>برمجة الانظمة و التطبيقات</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>برمجة الانظمة الالكترونية</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>انتاج المحتوى</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>التسويق الالكتروني</h3>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="testimonial-img" style="width: 100px; height:100px; background-color: white;">
                        <img src="{{asset('assets/frontend/img/my_bill_logo.png')}}" style="width: 50px; height:80px;" alt="">
                    </div>
                  <h3>ادارة المحتوى الالكتروني</h3>
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
                        <p>العملاء</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                    <div class="count-box">
                        <i class="bi bi-journal-richtext"></i>
                        <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                        <p>المشاريع</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-headset"></i>
                        <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
                        <p>عدد ساعات الخدمة</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-people"></i>
                        <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
                        <p>الموظفين</p>
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
                <p>من نحن</p>
            </div>

            <div class="row text-lg-center p4 fw-light" data-aos="fade-left">
                <p class="fw-light about-us-content">
                    شركة سعودية متخصصة منذ عام 2013م في مجال الإعلام والتقنية من تصميم وبرمجة مواقع إلكترونية و أنظمة وتطبيقات الهواتف الذكية نحن في شهرة نسعى دائما نحو هدف محدد وواضح وهو جذب أكثر عدد ممكن من العملاء لشركتك وإشهارها وزيادة أرباحها وذلك من خلال خبراتنا في التسويق و الإعلام الإلكتروني، نحن نستند في عملنا على الإبداع والتميز من خلال فريقنا الحالي والذي يتمتع بخبرة و إحترافية عالية في مجال الإعلام الإلكتروني الممول و الذي كانت بدايته في العام 2010م .
                </p>

                <p class="fw-light about-us-content mt-5">
                    أيضا بتصاميمنا الإحترافية وهذه الصفات هي التي جعلتنا متميزين في مجال الإعلام الإلكتروني داخل المملكة العربية السعودية. في مجال البرمجة فنحن نمتلك فريق من المبرمجين المحترفين في برمجة المواقع و الأنظمة الإلكترونية وتطبيقات الهواتف الذكية. باختيارك شهرة تكون قد حققت لنفسك شريكا يقدم لك حلول متكاملة مصممة حسب طلبك وامكانياتك تساعدك على تحقيق أهدافك بشكل مباشر وسريع.
                </p>

                <p class="fw-light about-us-content">
                    نحن في مهمة لصناعة المحتوى الأكثر إبداعا وابتكارا نفتخر بتقديم خدماتنا في التسويق الإلكتروني وتصميم الجرافيك وبرمجة الأنظمة الإلكترونية والتطبيقات.
                </p>
            </div>
        </div>
    </section><!-- End Team Section -->

    <section id="why" class="team">
        <div class="container">

            <div class="section-title text-center"text-center data-aos="fade-up">
                <!-- <h2>Team</h2> -->
                <h2></h2>
                <p>لماذا نحن الأفضل</p>
            </div>

            <div class="row text-lg-center p4 fw-light" data-aos="fade-left">
                <p class="fw-light about-us-content">
                    فريق عمل مبدع
                    تعمل شهرة بلس على توطيد العلاقات وبتقوية روابط التواصل الفعال وتوثيق الشراكات الاستراتيجية لبناء مشاريع احترافية. إننا نجمع الكفاءات المنالكلية معا وفي الوقت المناسب لمشاريعكم
                    تساهيل الدفع
                    تقدم شهرة بلس إطار تنظيمية وهيكلة أسعار واضحة وشفافة لضمان عدم وجود اي تكاليف خفية تتعلق بالتاسيل أو التشغيل. وتكوين رؤية المشروع المناسبة لميزانيتكم
                    تواصل دائم
                    تتوفر شهرة بلس على كافة وسائل التواصل التي تناسبكم. بالإضافة إلي استحداث الوسائل الأكثر تيسيرا لكم فقط لنبقي على تواصل دائم معكم دائم.
                </p>




            </div>

        </div>
    </section><!-- End Team Section -->




    <section id="soon" class="soon">
        <div class="container">

            <div class="section-title text-center" data-aos="fade-up">
                <!-- <h2>Features</h2> -->
                <h2></h2>
                <p>متوفر حاليا</p>
            </div>

            <div class="row">
                <div class="col-md-6 p-3 ">
                    <h3 class="fw-light"> تطبيق  MY BILL متوفر حاليا على جميع الهواتف الذكية</h3>
                    <div class="app d-flex flex-column align-items-center justify-content-center">
                        <a href=""><img src="{{asset('assets/frontend/img/app (1).png')}}" alt="" class="img-fluid mt-5 d-block"></a>
                        <a href=""><img src="{{asset('assets/frontend/img/app (2).png')}}" alt="" class="img-fluid "></a>

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
                        <p class="pb-3"><em>الفاتورة الإلكترونية بنظام الـ QR</em></p>
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
                    <h4>الروابط</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">الرئيسية</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">من نحن</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">الخدمات</a></li>

                        <li><i class="bx bx-chevron-right"></i> <a href="#">سياسة الخصوصية</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>الخدمات</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">تصميم الجرافيك</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">برمجة الويب والتطبيقات</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">برمجة الأنظمةوالتطبيقات</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">برمجة الأنظمة الإلكترونية </a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">انتاج الفيديو</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">التسويق الإلكتروني</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">ادارة المحتوى الإلكتروني</a></li>
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
