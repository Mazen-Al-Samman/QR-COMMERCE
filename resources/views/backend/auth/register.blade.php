<!DOCTYPE html>
<html lang="en">

<head>

    <title>Register</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

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
<div class="auth-wrapper">
    <div class="auth-content container">
        <div class="card">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="card-body">
                        <h2>QR-COMMERCE</h2>
                        <h4 class="mb-3 f-w-400">Login into your account</h4>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                </div>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter Name" required autofocus aria-autocomplete="false">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                </div>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Email address" required autofocus aria-autocomplete="false">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       @error('password') is-invalid @enderror>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                </div>
                                <select name="country" id="country" class="form-control" placeholder="Password"
                                        @error('country') is-invalid @enderror>
                                    <option value="">Amman</option>
                                    <option value="">Amman</option>
                                    <option value="">Amman</option>
                                </select>
                                @error('country')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-primary mb-4">Register</button>
                            <p class="mb-0 text-muted">Do you have an account? <a href="auth-signup.html"
                                                                                  class="f-w-400">Sign in</a></p>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <img src="../assets/images/auth-bg.jpg" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->

<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chart-morris/js/raphael.min.js')}}"></script>
<script src="{{ asset('assets/plugins/chart-morris/js/morris.min.js')}}"></script>

</body>

</html>
