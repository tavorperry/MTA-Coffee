@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
        <h2 class="service-description text-center">הטען ארנק באמצעות כרטיס אשראי</h2>
        <hr>
        {{ Form::open(['route' =>  ['wallet.chargeWithTranzila']]) }}
        @csrf
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">סכום</h4></label>
            <input id="amount" name="amount" type="number" class="col-9 form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" min="{{env("MINIMUM_AMOUNT_TO_MANUALLY_CHARGE")}}" max="{{env('MAXIMUM_AMOUNT_TO_MANUALLY_CHARGE')}}" required placeholder="סכום להטענה">
            </input>
            @if ($errors->has('amount'))
                <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו סכום תקין</strong>
                </span>
            @endif
        </div>
        <br>
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">הערות נוספות</h4></label>
            <input id="comment" name="comment" type="text" maxlength="100" class="col-9 form-control" placeholder="הערות נוספות" >

            </input>
            @if ($errors->has('comment'))
                <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו הערה תקינה. בלי תווים מיוחדים ועד 100 תווים</strong>
                </span>
            @endif
        </div>
        <br>
        <div class="container">
            <div class="text-center">
                {!! app('captcha')->render(); !!}
                <button type="submit" class="btn login-btn" value="דווח!">הטען!</button>
            </div>
        </div>
        {!! Form::close() !!}

@endsection

@section('page-scripts')

@endsection