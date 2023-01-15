<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    @include('admin.layout.partials.style')
</head>

<body>
    <div class="out">
        <div class="login">
            <div class="login__container">
                <div class="login__wrap">
                    <div class="login__head">
                        <a class="login__logo" href="#">
                            <img class="login__pic" src="{{ asset('theme/img/logo-white.svg') }}" alt="">
                        </a>
                    </div>
                    <form class="login__form" action="{{ url('register') }}" method="post">
                        @csrf
                        <div class="login__body">
                            <div class="login__title login__title_sm">Register new acount</div>
                            <div class="login__field field">
                                <small class="login__link">{{ $errors->first('email') }}</small>
                            </div>
                            <div class="login__field field">
                                <div class="field__wrap">
                                    <input class="field__input" required value="{{ old('first_name') }}" type="text"
                                        name="first_name" placeholder="Your First Name">
                                </div>
                            </div>
                            <div class="login__field field">
                                <div class="field__wrap">
                                    <input class="field__input" required type="text" value="{{ old('last_name') }}"
                                        name="last_name" placeholder="Your Last Name">
                                </div>
                            </div>
                            <div class="login__field field">
                                <div class="field__wrap">
                                    <input class="field__input" required type="email" value="{{ old('email') }}"
                                        name="email" placeholder="Your email">
                                </div>
                            </div>
                            <div class="login__field field">
                                <small class="login__link">{{ $errors->first('email') }}</small>
                            </div>
                            <div class="login__field field">
                                <small class="login__link">{{ $errors->first('password') }}</small>
                            </div>
                            <div class="login__field field">
                                <div class="field__wrap">
                                    <input class="field__input" required type="password" name="password"
                                        placeholder="Your password">
                                </div>
                            </div>
                            <div class="login__field field">
                                <div class="field__wrap">
                                    <input class="field__input" required type="password" name="password_confirmation"
                                        placeholder="Confirm Password">
                                </div>
                            </div>

                            <button class="login__btn btn btn  rounded-pill text-white "
                                style="background-color:#ff5926 " type="submit">Submit</button>
                            <div class="login__or">or</div>
                            <div class="login__btns">
                                <button class="login__btn btn btn btn_border-gray" type="button">
                                    <img class="btn__pic" src="{{ asset('theme/img/google.svg') }}" alt=""
                                        width="16">
                                    <span class="btn__text">Continue with Google</span>
                                </button>
                                <button class="login__btn btn btn btn_border-gray" type="button">
                                    <img class="btn__pic" src="{{ asset('theme/img/facebook.svg') }}" alt=""
                                        width="16">
                                    <span class="btn__text">Continue with Facebook</span>
                                </button>
                            </div>
                            <ul class="login__links">
                                <li><a class="login__link" href="{{ url('/') }}">Sign in?</a></li>
                            </ul>
                        </div>
                    </form>
                    <div class="login__bottom">
                        <ul class="login__links">
                            <li><a class="login__link" href="#">Privacy policy</a></li>
                            <li><a class="login__link" href="#">Terms of use</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <label class="switch switch_theme">
                <input class="switch__input js-switch-theme" type="checkbox" />
                <span class="switch__in"><span class="switch__box"></span><span class="switch__icon"><svg
                            class="icon icon-moon">
                            <use xlink:href="{{ asset('theme/img/sprite.svg#icon-moon') }}"></use>
                        </svg><svg class="icon icon-sun">
                            <use xlink:href="{{ asset('theme/img/sprite.svg#icon-sun') }}"></use>
                        </svg></span></span>
            </label> --}}
        </div>
    </div>
    @include('admin.layout.partials.script')
</body>

</html>
