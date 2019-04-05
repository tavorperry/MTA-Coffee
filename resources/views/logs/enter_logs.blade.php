@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
    <h2 class="service-description text-center">כניסה ללוגים</h2>
    <hr>
    @if(session('message'))
        <div>{{ session('message') }}</div>
    @endif
    {{ Form::open(['route' => ['enterLogs']])}}
    @csrf
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">מהי מילת הקסם?</h4></label>
        <input id="password" name="password" type="password" maxlength="50" required class="col-9 form-control" placeholder="סיסמת כניסה ללוגים" >
        </input>
        @if ($errors->has('password'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>הכנס סיסמא תקינה!מאדאפאקה!</strong>
                </span>
        @endif
    </div>
    <br>
    <div class="container">
        <div class="text-center">
            {{--{!! app('captcha')->render(); !!}--}}
            <button type="submit" class="btn login-btn" value="הכנס ללוגים!">הכנס ללוגים!</button>
        </div>
    </div>
    {!! Form::close() !!}

@endsection

@section('page-scripts')

@endsection