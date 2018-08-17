@extends('layouts.index')

@section('content')
  {{--  <script>
        function validateForm() {
            var checkbox = document.getElementById("terms");
            console.log(checkbox);
                if(checkbox.checked == false){
                    alert("חובה לאשר את תנאי השימוש ומדיניות הפרטיות");
                    return false;
                }
        }
    </script>--}}
    <?php
            if (   !($errors->has('first_name')) && !($errors->has('last_name'))  && !($errors->has('email')) && !($errors->has('password'))  )
                Alert::success(' מלבד שם ודוא"ל, איננו אוספים שום פרטים אישיים מחשבון הגוגל :)','אנו ממליצים להירשם דרך גוגל להרשמה מהירה')->autoclose(4000);
    ?>
    <div id="main_div" class="row justify-content-center position-relative" style="bottom:10px">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header text-center">{{ ('הרשמה') }}</div>
                <div class="card-body" style="padding-top: 5px;">
                        <a id="googlebtn" href="{{ route('login.google') }}" onclick="return validateForm()" class="gpsignin" style="color: white;margin-top:13px">  הרשמה דרך גוגל  </a>
                        <br>
                    <div id="normal_btn">
                        <button onclick="openForm()" class="btn login-btn">
                            {{ __('הרשמה רגילה  ') }}
                        </button>
                    <br>
                    <br>
                    </div>
                    <div class="form-popup" id="form">
                    <form name="register" class="" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-4 to-the-right">{{ __('שם פרטי') }}</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class=" form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required>
                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4  to-the-right">{{ __('שם משפחה') }}</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class=" form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 to-the-right">{{ __('כתובת מייל') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class=" form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4  to-the-right">{{ __('סיסמא') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class=" form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4  to-the-right">{{ __('סיסמא בשנית') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control " name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="text-center col">
                            <span style="font-size: 14px">אני מסכים/ה
                            <a href="{{env('APP_URL')}}/terms"> לתנאי השימוש ולמדיניות </a>הפרטיות</span>
                            <input type="checkbox" id="terms" name="terms" required style="width: 15px; height: 15px;">
                        </div>
                        <div class="form-group row mb-0" style="margin-top: 8px">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn login-btn">
                                    {{ __('תרשמו אותי!') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
