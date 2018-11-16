@extends('layouts.master')
@section('content')

        @if(Session::has('success'))
            <div class="alert alert-success text-center">
                {{ Session::get('success') }}
            </div>
        @endif
        <div id="main_div" class="row text-center justify-content-center position-relative" style="bottom:10px">
        <div class="col-sm-8">
        <div class="card">
            <div class="card-header text-center">{{ ('נקודות') }}</div>
            <div class="card-body" style="padding-top: 5px;">
                <div class="mt-4 mb-2">
                    <h2>נקודות:&nbsp;{{ $user->points }}</h2>
                    <?php $level = $user->getLevel() ?>
                    @if($level == '11')
                        <i class="fas fa-trophy user-level user-level-top"></i>
                    @else
                        <i class="fas fa-trophy user-grey"></i>
                        @for($i=1; $i<=10-$level; $i++)
                            <i class="fas fa-coffee user-grey"></i>
                        @endfor
                        @for($i=0; $i<$level; $i++)
                            <i class="fas fa-coffee user-level"></i>
                        @endfor
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <br>
    <div id="main_div" class="row justify-content-center position-relative" style="bottom:10px">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header text-center">{{ ('שינוי פרטים אישיים') }}</div>
                <div class="card-body" style="padding-top: 5px;">
                    <div id="form">
                        <form name="change_details" class="" method="POST" action="{{ route('profile.changeDetails') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-4 to-the-right">{{ __('שם פרטי') }}</label>
                                <div class="col-md-6">
                                    <input id="first_name" type="text" class=" form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{$user->first_name}}" required>
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
                                    <input id="last_name" type="text" class=" form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{$user->last_name}}" required>
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
                                    <input id="email" type="email" class=" form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required readonly>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0" style="margin-top: 8px">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn login-btn">
                                        {{ __('שנה פרטים') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            @if($user->password != null)
                    <div class="card">
                        <div class="card-header text-center">{{ ('שינוי סיסמא') }}</div>
                        <div class="card-body" style="padding-top: 5px;">
                            <div>
                                <form name="change_details" class="" method="POST" action="{{ route('profile.changePassword') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4  to-the-right">{{ __('סיסמא חדשה') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class=" form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required @if($errors->has('password'))autofocus @endif >

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4  to-the-right">{{ __('סיסמא חדשה בשנית') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0" style="margin-top: 8px">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn login-btn">
                                                {{ __('שנה סיסמא') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            @endif
            <div class="text-center">
                <br>
                <form name="change_details" class="" method="POST" action="{{ route('profile.deactivation')}}" onsubmit="return deleteUser()">
                    @csrf
                            <button type="submit" class="btn btn-danger">
                                {{ __('מחיקת המשתמש מהמערכת') }}
                            </button>
                </form>
          </div>
            </div>
        </div>
    <script>
        function deleteUser() {
            if (confirm("פעולה זו תמחק את המשתמש מהמערכת לצמיתות. פעולה זו לא ניתנת לשחזור!! האם את/ה בטוח/ה?")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection


