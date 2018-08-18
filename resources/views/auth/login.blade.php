@extends('layouts.index')

@section('content')
        <div id="main_div" class="row justify-content-center position-relative" style="bottom:10px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('התחברות') }}</div>
                    <div class="card-body">
                        <a id="googlebtn" href="{{ route('login.google') }}" onclick="return validateForm()" class="gpsignin col-md-12" style="color: white;">  התחברות דרך גוגל  </a>
                        <br>
                        <div id="normal_btn">
                        <button onclick="openForm()" class="btn login-btn">
                            {{ __('התחברות רגילה') }}
                        </button>
                        </div>
                        <div class="form-popup" id="form">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label to-the-right">{{ __('כתובת מייל') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox to-the-right">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('זכור אותי') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn login-btn">
                                        {{ __('התחבר') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            @if(!$errors->isEmpty())
            openForm();
            @endif
            function openForm() {
                document.getElementById("form").style.display = "block";
                document.getElementById("normal_btn").innerHTML = "";
                document.getElementById("googlebtn").style.opacity = "0.5";
                document.getElementById("main_div").style.bottom = "80px";
            }
        </script>
@endsection