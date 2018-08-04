@extends('layouts.index')

@section('content')
    <script>
        function validateForm() {
            var checkbox = document.getElementById("terms");
            console.log(checkbox);
                if(checkbox.checked == false){
                    alert("חובה לאשר את תנאי השימוש ומדיניות הפרטיות");
                    return false;
                }
        }
    </script>
    <div class="row justify-content-center position-relative" style="bottom:60px">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('הרשמה') }}</div>

                <div class="card-body">
                    <form name="register" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-sm-4 col-form-label to-the-right">{{ __('שם פרטי') }}</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label to-the-right">{{ __('שם משפחה') }}</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label to-the-right">{{ __('כתובת מייל') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label to-the-right">{{ __('סיסמא') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label to-the-right">{{ __('סיסמא בשנית') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="text-center">
                        <span>קראתי, הבנתי ואני מסכים/ה
                            <a href="{{env('APP_URL')}}/terms"> לתנאי שימוש ולמדיניות הפרטיות</a></span>
                            <input type="checkbox" id="terms" name="terms" required>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn login-btn">
                                    {{ __('הרשם') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <form action="{{ route('login.google') }}" class="text-center">
                        @csrf
                        <input type="image" name="submit" src="{{ URL::to('/') }}/images/btn_google.png" border="0" alt="Submit" onclick="return validateForm()"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
