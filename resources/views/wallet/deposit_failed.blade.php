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
                            <div class="card-header text-center"><b>טעינה נכשלה!!</b></div>
                            <div class="card-body container">
                                <table>
                                    <tr style="width: 100%">
                                        <td style="width: 40%">
                                            שם:
                                        </td>
                                        <td style="width: 59%">
                                        <span style="color: red">
                                            {{$first_name}} {{$last_name}}
                                </span>
                                        </td>
                                    <tr>
                                        <td>
                                            סכום:
                                        </td>
                                        <td>
                                    <span style="color: red">
                                        {{$sum}} ש"ח
                                        </span>
                                        </td>
                                    <tr>
                                        <td>
                                            יתרה מעודכנת:
                                        </td>
                                        <td>
                                            <span style="color: red"> {{$user->wallet->balance}} ש"ח </span>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </div>
                        </div>
                        <button onclick="window.location.href = '{{env("APP_URL")}}'"> אישור ומעבר לתפריט הראשי </button>
                    </div>
                </div>
            </div>
    <script>
        alert("כרטיסך חיוב אך יש תקלה אצלנו במערכת! אנא צור קשא איתנו כדי לקבל זיכוי. תודה וסליחה!");
    </script>

@endsection

@section('page-scripts')

@endsection