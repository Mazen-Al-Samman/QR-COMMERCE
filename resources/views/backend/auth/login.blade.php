<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/animation/css/animate.min.css')}}">
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

</head>

<!-- [ auth-signin ] start -->
<div class="container login-container">
    <div class="row">
        <div class="col-md-6 login-form-1">
            <h3>Login as Admin</h3>
            <form method="POST" action="{{ route('admin.login.submit') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your Email *" name="email" autofocus autocomplete="false" />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" />
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Login" />
                </div>
                <div class="form-group">
                    <a href="#" class="ForgetPwd" value="Login">Forget Password?</a>
                </div>
            </form>
        </div>
        <div class="col-md-6 login-form-2">
            <h3>Login as Vendor</h3>
            <form method="POST" action="{{ route('vendor.login.submit') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control @error('vendor-email') is-invalid @enderror" placeholder="Your Email *" name="vendor-email" autofocus autocomplete="false" />
                    @error('vendor-email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="vendor-password" class="form-control @error('vendor-password') is-invalid @enderror" placeholder="Password" />
                    @error('vendor-password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Login" />
                </div>
                <div class="form-group">
                    <a href="#" class="ForgetPwd" value="Login">Forget Password?</a>
                </div>
            </form>
            @error('inactive-vendor')
                <p class="text-danger font-weight-bold" style="font-size: 20px">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->

<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chart-morris/js/raphael.min.js')}}"></script>
<script src="{{ asset('assets/plugins/chart-morris/js/morris.min.js')}}"></script>
<script src="{{ asset('assets/js/pages/chart-morris-custom.js')}}"></script>
</body>

</html>
