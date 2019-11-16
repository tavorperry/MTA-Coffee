@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
        <?php
            //$user = auth::user();
                $user = \App\User::getUserById(3); //TODO: Delete
            $first_name = $user->first_name;
            $last_name = $user->last_name;

            //TODO: if failed -> give message
        ?>
            <div class="container">
                <div class="row justify-content-center position-relative" style="bottom:30px">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header text-center"><b>אישור הטענה</b></div>
                            <div class="card-body container">
                                <table>
                                    <tr style="width: 100%">
                                        <td style="width: 40%">
                                            שם:
                                        </td>
                                        <td style="width: 59%">
                                        <span style="color: limegreen">
                                            {{$first_name}} {{$last_name}}
                                </span>
                                        </td>
                                    <tr>
                                        <td>
                                            סכום:
                                        </td>
                                        <td>
                                    <span style="color: limegreen">
                                        {{$sum}} ש"ח
                                        </span>
                                        </td>
                                    <tr>
                                        <td>
                                            יתרה מעודכנת:
                                        </td>
                                        <td>
                                            <span style="color: limegreen"> {{$user->wallet->balance}} ש"ח </span>
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