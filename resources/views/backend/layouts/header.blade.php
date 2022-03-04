<!DOCTYPE html>
<html lang="en">
<?php
    $guard = "";
    $name = "";
    if (Auth::guard('web')->check()) {
        $guard = 'web';
        $name = auth('web')->user()->username;
    } else if (Auth::guard('vendor')->check()) {
        $guard = 'vendor';
        $name = auth('vendor')->user()->name;
    }
?>
<head>
    <title>QR Dashboard</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Flash Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords"
          content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Flash Able, Flash Able bootstrap admin template">
    <meta name="author" content="Codedthemes" />
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{'/assets/images/favicon.ico'}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{'/assets/fonts/fontawesome/css/fontawesome-all.min.css'}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{'/assets/plugins/animation/css/animate.min.css'}}">
    <!-- Chart JS -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/chart-morris/css/morris.css')}}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{'/assets/css/style.css'}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="">
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar menupos-fixed menu-light brand-blue ">
    <div class="navbar-wrapper ">
        <div class="navbar-brand header-logo">
            <a href="index.html" class="b-brand text-light font-weight-bold">
                QR-Commerce
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar" style="font-size: 18px">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>
                <li class="nav-item">
                    @if (auth('web')->check())
                        <a href="{{route('admin.dashboard')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    @elseif (auth('vendor')->check())
                        <a href="{{route('admin-vendor.dashboard')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    @endif
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Menu</label>
                </li>
                <li class="nav-item">
                    @if($guard == 'web' && in_array('admin.create', $userAuthPermission))
                        <a href="{{route('admin.create')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">Admin</span></a>
                    @elseif($guard == 'vendor' && in_array('admin-vendor.create', $userAuthPermission))
                        <a href="{{route('admin-vendor.create')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">Admin</span></a>
                    @endif
                </li>
                <li class="nav-item">
                    @if($guard == 'web' && in_array('user.create', $userAuthPermission))
                        <a href="{{route('user.create')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">User</span></a>
                    @endif
                </li>
                <li class="nav-item">
                    @if(in_array('vendor.create', $userAuthPermission))
                        <a href="{{route('vendor.create')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-map"></i></span><span class="pcoded-mtext">Vendor</span></a>
                    @endif
                </li>
                @if(in_array('banner.create', $userAuthPermission))
                    <li class="nav-item">
                        <a href="{{route('banner.create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-list-alt"></i></span><span class="pcoded-mtext">Banner</span></a>
                    </li>
                @endif
                @if(in_array('role.create', $userAuthPermission) || in_array('permission.create', $userAuthPermission) || in_array('role-permission.create', $userAuthPermission))
                <li class="nav-item pcoded-hasmenu">
                    <a class="nav-link" style="cursor:pointer;"><span class="pcoded-micon"><i class="feather icon-star"></i></span><span class="pcoded-mtext">Roles & Permissions</span></a>
                    <ul class="pcoded-submenu">
                        @if(in_array('role.create', $userAuthPermission))
                            <li class=""><a href="{{route('role.create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-tasks"></i></span><span class="pcoded-mtext">Role</span></a></li>
                        @endif
                        @if(in_array('permission.create', $userAuthPermission))
                            <li class=""><a href="{{route('permission.create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-lock"></i></span><span class="pcoded-mtext">Permission</span></a></li>
                        @endif
                        @if(in_array('role-permission.create', $userAuthPermission))
                        <li class=""><a href="{{route('role-permission.index')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-user-lock"></i></span><span class="pcoded-mtext">Role Permissions</span></a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(in_array('category.create', $userAuthPermission))
                <li class="nav-item">
                    <a href="{{route('category.create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-list-alt"></i></span><span class="pcoded-mtext">Category</span></a>
                </li>
                @endif
                @if(in_array('product.create', $userAuthPermission))
                <li class="nav-item">
                    <a href="{{route('product.create')}}" class="nav-link"><span class="pcoded-micon"><i class="fa fa-product-hunt"></i></span><span class="pcoded-mtext">Product</span></a>
                </li>
                @endif
                @if(in_array('invoice.create', $userAuthPermission))
                <li class="nav-item">
                    <a href="{{route('invoice.index')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-file-invoice"></i></span><span class="pcoded-mtext">Invoice</span></a>
                </li>
                @endif
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="feather icon-lock"></i></span><span class="pcoded-mtext">Authentication</span></a>
                    <ul class="pcoded-submenu">
                        <li class="">
                            <a>
                                <form action="{{route('logout')}}" method="post">
                                    @csrf
                                    <button type="submit" class="bg-transparent border-0 dud-logout"><i class="feather icon-log-out"></i> logout</button>
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="card text-center">
            </div>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->

<!-- [ Header ] start -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
        <a href="index.html" class="b-brand">
            <img src="../assets/images/logo.svg" alt="" class="logo images">
            <img src="../assets/images/logo-icon.svg" alt="" class="logo-thumb images">
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#!">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <a href="#!" class="mob-toggler"></a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <div class="main-search open">
                    <div class="input-group">
                        <input type="text" id="m-search" class="form-control" placeholder="Search . . .">
                        <a href="#!" class="input-group-append search-close">
                            <i class="feather icon-x input-group-text"></i>
                        </a>
                        <span class="input-group-append search-btn btn btn-primary">
								<i class="feather icon-search input-group-text"></i>
							</span>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
{{--            <li>--}}
{{--                <div class="dropdown">--}}
{{--                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-right notification">--}}
{{--                        <div class="noti-head">--}}
{{--                            <h6 class="d-inline-block m-b-0">Notifications</h6>--}}
{{--                            <div class="float-right">--}}
{{--                                <a href="#!" class="m-r-10">mark as read</a>--}}
{{--                                <a href="#!">clear all</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <ul class="noti-body">--}}
{{--                            <li class="n-title">--}}
{{--                                <p class="m-b-0">NEW</p>--}}
{{--                            </li>--}}
{{--                            <li class="notification">--}}
{{--                                <div class="media">--}}
{{--                                    <img class="img-radius" src="../assets/images/user/avatar-1.jpg" alt="Generic placeholder image">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p><strong>{{$name}}</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>--}}
{{--                                        <p>New ticket Added</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="n-title">--}}
{{--                                <p class="m-b-0">EARLIER</p>--}}
{{--                            </li>--}}
{{--                            <li class="notification">--}}
{{--                                <div class="media">--}}
{{--                                    <img class="img-radius" src="../assets/images/user/avatar-2.jpg" alt="Generic placeholder image">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>10 min</span></p>--}}
{{--                                        <p>Prchace New Theme and make payment</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="notification">--}}
{{--                                <div class="media">--}}
{{--                                    <img class="img-radius" src="../assets/images/user/avatar-3.jpg" alt="Generic placeholder image">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>12 min</span></p>--}}
{{--                                        <p>currently login</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="notification">--}}
{{--                                <div class="media">--}}
{{--                                    <img class="img-radius" src="../assets/images/user/avatar-1.jpg" alt="Generic placeholder image">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>--}}
{{--                                        <p>Prchace New Theme and make payment</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="notification">--}}
{{--                                <div class="media">--}}
{{--                                    <img class="img-radius" src="../assets/images/user/avatar-3.jpg" alt="Generic placeholder image">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>1 hour</span></p>--}}
{{--                                        <p>currently login</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="notification">--}}
{{--                                <div class="media">--}}
{{--                                    <img class="img-radius" src="../assets/images/user/avatar-1.jpg" alt="Generic placeholder image">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>2 hour</span></p>--}}
{{--                                        <p>Prchace New Theme and make payment</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <div class="noti-footer">--}}
{{--                            <a href="#!">show all</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon feather icon-settings"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/2048px-User_icon_2.svg.png" class="img-radius" alt="User-Profile-Image">
                            <span>{{$name}}</span>
                            <form action="{{route('logout')}}" method="post">
                                @csrf
                                <button type="submit" class="bg-transparent border-0 dud-logout"><i class="feather icon-log-out"></i></button>
                            </form>
                        </div>
                        <ul class="pro-body">
                            <li><a href="{{route('profile.show')}}" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<!-- [ Header ] end -->
