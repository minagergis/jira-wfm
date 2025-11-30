<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>WFM - Login</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('assets/img/brand/favicon.png')}}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.1.0')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('new-style-assets/auth/css/login.css')}}" type="text/css">
</head>

<body class="bg-default">

<!-- Main content -->
<div class="main-content">
    <div class="card login-card bg-secondary border-0 mb-0">
        <div class="card-header bg-transparent">
            <div class="text-center">
                <h2 class="welcome-text">WELCOME BACK</h2>
                <div class="brand-text">WORK FORCE MANAGEMENT</div>
            </div>
        </div>
        <div class="card-body">
            <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email Address') }}" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" type="password" required autocomplete="current-password">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customCheckLogin">
                        <span>{{ __('Remember Me') }}</span>
                    </label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Footer -->
<footer id="footer-main">
    <div class="container">
        <div class="copyright text-center">
            &copy; <?php echo date('Y')?> <a href="http://wfm.antipiracy.me" target="_blank">Made with love ❤️</a>
        </div>
    </div>
</footer>
<!-- Argon Scripts -->
<!-- Core -->
<script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
<!-- Argon JS -->
<script src="{{asset('assets/js/argon.js?v=1.1.0')}}"></script>
<!-- Demo JS - remove this in your project -->
<script src="{{asset('assets/js/demo.min.js')}}"></script>
</body>

</html>
