@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
    @if(isset($error) && $error == true)
        <b> הסכום חייב להיות בין 10 ל 100 </b>
    @else
    <h2 class="service-description text-center">הטענת ארנק דיגיטלי בכרטיס אשראי</h2>
    <hr>
    <div style="height:560px" class="embed-responsive embed-responsive-1by1">
        <iframe class="embed-responsive-item" src="https://direct.tranzila.com/test/iframenew.php?lang=il&cred_type=1&u71=1&sum={{$amount}}" scrolling="no"> </iframe>
    </div>
    @endif

@endsection

@section('page-scripts')
@endsection