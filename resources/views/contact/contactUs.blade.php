@extends('layouts.master')

@section('page-style')
    <link href="{{env('APP_URL')}}/css/create.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <h2 class="service-description text-center">צור קשר</h2>
    <hr>
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    @if(Auth::user())
        {{ Form::open(['route' => ['contact-us.send']]) }}
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">שם</h4></label>
            <input type="text" id="username" type="text" class="col-9 form-control" name="username" value="{{ $user->first_name. ' ' .$user->last_name }}" readonly>
        </div>
        <br>
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">מייל</h4></label>
            <input type="email" id="email" type="text" class="col-9 form-control" name="user-email" value="{{ $user->email }}" readonly>
        </div>
        <br>
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">הודעה</h4></label>
            <textarea rows="4" cols="30" id="user-message" type="text" class="col-9 form-control" name="user-message" value="{{ old('user-message') }}" required></textarea>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                {!! app('captcha')->render(); !!}
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn login-btn" value="שלח הודעה">שלח הודעה!</button>
        </div>

        {!! Form::close() !!}
    @else
        {{ Form::open(['route' => ['contact-us.send']]) }}
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">שם</h4></label>
            <input type="text" id="username" type="text" class="col-9 form-control" name="username" placeholder="שם מלא" required>
        </div>
        <br>
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">מייל</h4></label>
            <input type="email" id="email" type="text" class="col-9 form-control" name="user-email" placeholder="כתובת אימייל שנוכל להחזיר תשובה" required>
        </div>
        <br>
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">הודעה</h4></label>
            <textarea rows="4" cols="30" id="user-message" type="text" class="col-9 form-control" name="user-message" value="{{ old('user-message') }}" required></textarea>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                {!! app('captcha')->render(); !!}
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn login-btn" value="שלח הודעה">שלח הודעה!</button>
        </div>
        {!! Form::close() !!}
    @endif

    {{--More details to contact us--}}
    <br><br>
    <div style="text-align: center"; align="center">
    <strong style="text-align: center; font-size: 22px">פרטים נוספים ליצירת קשר</strong>
    <br>
    <table style="text-align: center"; align="center">
        <tr>
            <td style="text-align: left">
                <strong>כתובת</strong>
            </td>
            <td style="text-align: right">
                רבחנו ירוחם 12, תל אביב-יפו
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                <strong>טלפון</strong>
            </td>
            <td style="text-align: right">
                03-6817011
            </td>
        </tr>
    </table>
    </div>
@endsection