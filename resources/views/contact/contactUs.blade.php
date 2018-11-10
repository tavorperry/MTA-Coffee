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

    {{ Form::open(['route' => ['contact-us.send']]) }}
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">שם משתמש</h4></label>
        <input type="text" id="username" type="text" class="col-9 form-control" name="username" value="{{ Auth::user()->first_name. ' ' .Auth::user()->last_name }}" readonly>
    </div>
    <br>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">מייל</h4></label>
        <input type="email" id="email" type="text" class="col-9 form-control" name="user-email" value="{{ Auth::user()->email }}" readonly>
    </div>
    <br>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">גוף ההודעה</h4></label>
        <textarea rows="4" cols="30" id="user-message" type="text" class="col-9 form-control" name="user-message" value="{{ old('user-message') }}" required></textarea>
    </div>
    <br>
    <div class="text-center">
        <button type="submit" class="btn login-btn" value="שלח הודעה">שלח הודעה!</button>
    </div>

    {!! Form::close() !!}

@endsection