@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
        <?php
            $user = auth::user();
            $first_name = $user->first_name;
            $last_name = $user->last_name;
        ?>
            <div class="container">
                <div class="row justify-content-center position-relative" style="bottom:30px">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header text-center"><b>הטענה נכשלה</b></div>
                            <div class="card-body container">
                                <br>
                                יש תקלה עם כרטיס האשראי שלך. אנא נסה שנית
                            </div>
                        </div>
                        <button onclick="window.location.href = '{{env("APP_URL")}}'"> אישור ומעבר לתפריט הראשי </button>
                    </div>
                </div>
            </div>

        <script>
            alert("לידיעתך, כרטיסך אינו חויב");
        </script>

@endsection

@section('page-scripts')

@endsection