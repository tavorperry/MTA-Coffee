@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
    @if(session('message'))
        <?php
        $email = session()->get('email');
        $amount = session()->get('amount');
        $comment = session()->get('comment');
        $errorDesc = session()->get('ErrorDesc');
        $currentBalance = session()->get('currentBalance');
        $isDepositSucceed = session()->get('isDepositSucceed');
        $code = session()->get('Code');
        $user = App\User::getUserByEmail($email);
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $chargerUser = Illuminate\Support\Facades\Auth::user();
        ?>
        @if(!$isDepositSucceed && $code == '000')
            <h2 style="color: black">
                חיוב בוצע אך טעינה נכשלה!!!
                <br>
                אנא צלם הודעה זו ופנה למנהלי מערכת קפה אמון לצורך בירור וזיכוי!
                <br>
                תודה וסליחה על אי הנעימות
                <br>
                {{$email}}
            </h2>
        @else
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
                                        {{$amount}} ש"ח
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
                                            סטטוס:
                                        </td>
                                        <td>
                                            <span style="color: limegreen">{{$errorDesc}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            הערה:
                                        </td>
                                        <td>
                                            <span style="color: limegreen"> {{$comment}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            יתרה מעודכנת:
                                        </td>
                                        <td>
                                            <span style="color: limegreen"> {{$currentBalance}} ש"ח </span>
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
        @endif
    @else


    <h2 class="service-description text-center">הטען ארנק לסטודנט</h2>
    <hr>
    @if(session('message'))
        <div>{{ session('message') }}</div>
    @endif
    {{ Form::open(['route' => ['wallet.confirmCharge']])}}
    @csrf
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">אימייל של הסטודנט להטענה</h4></label>
        <input id="email" name="email" type="email" class="col-9 form-control required" required placeholder="אימייל" ></input>
        @if ($errors->has('email'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>האימייל לא נמצא במערכת</strong>
                </span>
        @endif
    </div>
    <br>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">סכום</h4></label>
        <input id="amount" name="amount" type="number" class="col-9 form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" min="{{env("MINIMUM_AMOUNT_TO_MANUALLY_CHARGE")}}" max="{{env('MAXIMUM_AMOUNT_TO_MANUALLY_CHARGE')}}" required placeholder="סכום להטענה">
        </input>
        @if ($errors->has('amount'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו סכום תקין</strong>
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
    @endif

@endsection

@section('page-scripts')

@endsection