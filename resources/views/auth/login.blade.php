@extends('layouts.guest')

@section('title')
    Login
@endsection

@section('content')
    <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 offset-xs-0">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#login" data-toggle="tab">Log in</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#signup" data-toggle="tab">Sign up</a>
        </li>
    </ul>
    <div class="tab-content">

        <!-- LOGIN -->
        <div class="tab-pane active login-custom" id="login">

            <ul class="list-inline log-social">
                <li class="list-inline-item log-social-fb"><a href="{{ url('login/facebook') }}">
                        <svg class="svg-inline--fa fa-facebook-f fa-w-9" aria-hidden="true" data-prefix="fab"
                             data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 264 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"></path>
                        </svg>
                    </a></li>
                <li class="list-inline-item log-social-twitter"><a href="{{ url('login/twitter') }}">
                        <svg class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" data-prefix="fab"
                             data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 512 512"
                             data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                        </svg>
                    </a></li>
                <li class="list-inline-item log-social-google"><a href="{{ url('login/google') }}">
                        <svg class="svg-inline--fa fa-google-plus-g fa-w-20" aria-hidden="true"
                             data-prefix="fab"
                             data-icon="google-plus-g" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 640 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z"></path>
                        </svg>
                    </a></li>
                <li class="list-inline-item log-social-linkedin"><a href="{{ url('login/linkedin') }}">
                        <svg class="svg-inline--fa fa-linkedin-in fa-w-14" aria-hidden="true" data-prefix="fab"
                             data-icon="linkedin-in" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M100.3 480H7.4V180.9h92.9V480zM53.8 140.1C24.1 140.1 0 115.5 0 85.8 0 56.1 24.1 32 53.8 32c29.7 0 53.8 24.1 53.8 53.8 0 29.7-24.1 54.3-53.8 54.3zM448 480h-92.7V334.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V480h-92.8V180.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V480z"></path>
                        </svg>
                    </a></li>
            </ul>

            <div class="log-separator">
                <hr>
                <h5>OR</h5>
            </div>

            <form method="POST" action="{{ route('login') }}" accept-charset="UTF-8">
            @csrf
            <!-- combo -->
                <div class="myaccount-combo">
                    <div class="form-group">
                        <h5>Email</h5>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               placeholder="Email"
                               name="email" type="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <!-- END combo -->

                <!-- combo -->
                <div class="myaccount-combo">
                    <div class="form-group">
                        <h5>Password</h5>
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               placeholder="Password" name="password" type="password" required>
                    </div>
                </div>
                <!-- END combo -->

                <!-- login bot -->
                <div class="login-bot">
                    <div class="row">
                        <div class="col">
                            <!-- check -->
                            <div class="checkbox">
                                <label>
                                    <input name="remember"
                                           type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <p class="login-remember-txt">Remember me</p>
                                </label>
                            </div>
                            <!-- END check -->
                        </div>
                        <div class="col login-right">
                            <a href="{{ route('password.request') }}">Forgot password</a>
                        </div>
                    </div>
                </div>
                <!-- END bot -->

                <button type="submit" class="btn btn-default bt-section-out" role="button">Log in</button>
            </form>
        </div>
        <!-- END login -->


        <!-- SIGN UP -->
        <div class="tab-pane login-custom" id="signup">

            <ul class="list-inline log-social">
                <li class="list-inline-item log-social-fb"><a href="{{ url('login/facebook') }}">
                        <svg class="svg-inline--fa fa-facebook-f fa-w-9" aria-hidden="true" data-prefix="fab"
                             data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 264 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"></path>
                        </svg>
                    </a></li>
                <li class="list-inline-item log-social-twitter"><a href="{{ url('login/twitter') }}">
                        <svg class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" data-prefix="fab"
                             data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 512 512"
                             data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                        </svg>
                    </a></li>
                <li class="list-inline-item log-social-google"><a href="{{ url('login/google') }}">
                        <svg class="svg-inline--fa fa-google-plus-g fa-w-20" aria-hidden="true"
                             data-prefix="fab"
                             data-icon="google-plus-g" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 640 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z"></path>
                        </svg>
                    </a></li>
                <li class="list-inline-item log-social-linkedin"><a href="{{ url('login/linkedin') }}">
                        <svg class="svg-inline--fa fa-linkedin-in fa-w-14" aria-hidden="true" data-prefix="fab"
                             data-icon="linkedin-in" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M100.3 480H7.4V180.9h92.9V480zM53.8 140.1C24.1 140.1 0 115.5 0 85.8 0 56.1 24.1 32 53.8 32c29.7 0 53.8 24.1 53.8 53.8 0 29.7-24.1 54.3-53.8 54.3zM448 480h-92.7V334.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V480h-92.8V180.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V480z"></path>
                        </svg>
                    </a></li>
            </ul>

            <div class="log-separator">
                <hr>
                <h5>OR</h5>
            </div>
            <form method="POST" action="{{ route('register') }}" accept-charset="UTF-8">
            @csrf
            <!-- combo -->
                <div class="myaccount-combo">
                    <div class="form-group">
                        <h5>Email</h5>
                        <input placeholder="mark@coinspy.com" id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                               value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <!-- END combo -->

                <!-- combo -->
                <div class="myaccount-combo">
                    <div class="form-group">
                        <h5>Password</h5>
                        <input placeholder="Password" id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <!-- END combo -->

                <!-- combo -->
                <div class="myaccount-combo">
                    <div class="form-group">
                        <h5>Confirm Password</h5>
                        <input placeholder="Confirm password" id="password-confirm" type="password"
                               class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <!-- END combo -->

                <!-- login bot -->
                <div class="login-bot">
                    <!-- check -->
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" required>
                            <p class="login-remember-txt">I have read and agree to the <a href="{{ route('terms') }}">Terms of
                                    Use</a>
                                as
                                well as <a href="{{ route('privacy') }}">Privacy Policy</a></p>
                        </label>
                    </div>
                    <!-- END check -->
                </div>
                <!-- END bot -->

                <button type="submit" class="btn btn-default bt-section-out" role="button">Sign up</button>
            </form>
        </div>
        <!-- END sign up -->

    </div>
    <script>
        $(function () {
            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });
    </script>
    </div>
@endsection
