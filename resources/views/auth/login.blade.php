<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="admin/img/favicon.png">

    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <style>
        .customizer-links {
            display: none;
        }
    </style>
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <!-- <div class="login-logo logo-normal" style="max-width: 100px">
                            <img src="{{ asset('logo-light.png') }}" alt="img">
                        </div> -->
                        <!-- <a href="" class="login-logo logo-white">
                             <img src="{{ asset('logo-light.png') }}" alt="img">
                        </a> -->
                        <div class="login-userheading">
                            <h3>Sign In </h3>
                            <h4>Please login to your account</h4>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    {{-- <input type="text" placeholder="Enter your email address"> --}}
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <img src="{{ asset('admin/images/mail.svg') }}" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    {{-- <input type="password" class="pass-input" placeholder="Enter your password"> --}}
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- <span class="fas toggle-password fa-eye-slash"></span> --}}
                                </div>
                            </div>
                            {{-- <div class="form-login">
                                <div class="alreadyuser">
                                    <h4><a href="" class="hover-a">Forgot Password?</a></h4>
                                </div>
                            </div> --}}
                            <div class="form-login">
                                <button class="btn btn-login" type="submit">Sign In</button>
                            </div>
                        </form>
                        {{-- <div class="signinform text-center">
                                <h4>Don’t have an account? <a href=" signup.html" class="hover-a">Sign Up</a></h4>
                            </div>
                            <div class="form-setlogin">
                                <h4>Or sign up with</h4>
                            </div>
                            <div class="form-sociallink">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <img src=" admin/img/icons/google.png" class="me-2" alt="google">
                                            Sign Up using Google
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <img src=" admin/img/icons/facebook.png" class="me-2" alt="google">
                                            Sign Up using Facebook
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                    </div>
                </div>
                <div class="login-img">
                    <img src="{{ asset('admin/images/login.jpg') }}" alt="img">
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('admin/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('admin/js/feather.min.js') }}"></script>

    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/js/script.js') }}"></script>
</body>


</html>
