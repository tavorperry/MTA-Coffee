@extends('layouts.master')
{{--<link href="{{env('APP_URL')}}/css/view.css" media="all" rel="stylesheet" type="text/css" />--}}

@section('content')

<?php
    $request = request();
    $email = $name = $request->input('email');
    $amount = $name = $request->input('amount');
    $comment = $name = $request->input('comment');
    $user = App\User::getUserByEmail($email);
    $first_name = $user->first_name;
    $last_name = $user->last_name;
    $chargerUser = Illuminate\Support\Facades\Auth::user(); //if this is xsenia for example...
?>

    <div class="container">
        <div class="row justify-content-center position-relative" style="bottom:30px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center"><b>אישור הטענה</b></div>
                    <div class="card-body container">
                        <table>
                            <tr style="width: 100%">
                                <td style="width: 30%">
                                    שם הסטודנט:
                                </td>
                                <td style="width: 69%">
                                        <span style="color: limegreen">
                                            {{$first_name}} {{$last_name}}
                                </span>
                                </td>
                            <tr>
                                <td>
                                    סכום הטענה:
                                </td>
                                <td>
                                    <span style="color: limegreen">
                                        {{$amount}}
                                        </span>
                                </td>
                            <tr>
                                <td>
                                    מטעין:
                                </td>
                                <td>
                                    <span style="color: limegreen"> {{$chargerUser->first_name}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    הערה נוספת:
                                </td>
                                <td>
                                    <span style="color: limegreen"> {{$comment}}</span>
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
@endsection

@section('page-scripts')
@endsection
