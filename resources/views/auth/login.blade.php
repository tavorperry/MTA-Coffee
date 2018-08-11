@extends('layouts.index')

@section('content')
        <div class="row justify-content-center position-relative" style="bottom:60px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('התחברות') }}</div>
                    <div class="card-body">
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
                                    </button><br>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('login.google') }}" class="text-center">
                            @csrf
                            <input type="image" name="submit" src="{{ URL::to('/') }}/images/btn_google.png" border="0" alt="Submit"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection