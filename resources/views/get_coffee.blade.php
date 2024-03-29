@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
    <h2 class="service-description text-center">הטענת ארנק דיגיטלי בכרטיס אשראי</h2>
    <hr>
    @if(session('message'))
        <div>{{ session('message') }}</div>
    @endif
    {{ Form::open(['route' => ['getCoffee']])}}
    @csrf
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">בחר מכונה</h4></label>
        <select id="month" name="month" class="col-9 form-control{{ $errors->has('machine') ? ' is-invalid' : '' }}" value="{{ old('machine') }}" required>
            <option value="2">ווסטון</option>
        </select>
    </div>

    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">הערות</h4></label>
        <input id="comment" name="comment" type="text" maxlength="50" class="col-9 form-control" placeholder="הערות (עד 50 תווים)" >

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