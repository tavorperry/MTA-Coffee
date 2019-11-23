@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
    <h2 class="service-description text-center">פתיחת מכונה - קניית קפה</h2>
    <hr>
    @if(session('message'))
        <div>{{ session('message') }}</div>
    @endif
    <form name="getCoffee" id="submit_form" class="" method="POST" action="<?php echo e(route('getCoffee.buy')); ?>" onsubmit="return getCoffeeAlert()">
    @csrf
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">בחר מכונה</h4></label>
        <select id="machineNumber" name="machineNumber" class="col-9 form-control{{ $errors->has('machineNumber') ? ' is-invalid' : '' }}" value="{{ old('machineNumber') }}" required>
            <option value="2">ווסטון</option>
        </select>
    </div>
    <br>
    <div class="container">
        <div class="text-center">
            {!! app('captcha')->render(); !!}
            <button type="submit" class="btn login-btn form-button" value="דווח!">תביאו לי קפה!</button>
        </div>
    </div>
    </form>
    <script>
        function getCoffeeAlert() {
            return confirm("הפעולה הבאה תפתח את המכונה ותחייב אתכם בסכום המחיר של קפה. האם להמשיך?");
        }
    </script>

@endsection

@section('page-scripts')

@endsection