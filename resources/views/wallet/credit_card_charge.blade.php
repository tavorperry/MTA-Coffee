@extends('layouts.master')
@section('page-style')
@endsection

@section('content')
    <h2 class="service-description text-center">הטענת ארנק דיגיטלי בכרטיס אשראי</h2>
    <hr>
    @if(session('message'))
        <?php
        $email = session()->get('email');
        $amount = session()->get('amount');
        $comment = session()->get('comment');
        $user = App\User::getUserByEmail($email);
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $chargerUser = Illuminate\Support\Facades\Auth::user();
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
        @else
    {{ Form::open(['route' => ['wallet.confirmCreditCardCharge']])}}
    @csrf
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">סכום להטענה</h4></label>
        <input id="amount" name="amount" type="number" class="col-9 form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" min="{{env("MINIMUM_AMOUNT_TO_MANUALLY_CHARGE")}}" max="{{env('MAXIMUM_AMOUNT_TO_MANUALLY_CHARGE')}}" required placeholder="סכום להטענה">
        </input>
        @if ($errors->has('amount'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו סכום תקין להטענה</strong>
                </span>
        @endif
    </div>
    <br>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">מספר כרטיס אשראי</h4></label>
        <input id="creditCardNumber" name="creditCardNumber" type="text" class="col-9 form-control{{ $errors->has('creditCardNumber') ? ' is-invalid' : '' }}" value="{{ old('creditCardNumber') }}" required placeholder="מספר כרטיס אשראי" maxlength="16" minlength="16">
        </input>
        @if ($errors->has('creditCardNumber'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו מספר אשראי תקין</strong>
                </span>
        @endif
    </div>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">חודש</h4></label>
        <select id="month" name="month" class="col-9 form-control{{ $errors->has('month') ? ' is-invalid' : '' }}" value="{{ old('month') }}" required>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        @if ($errors->has('month'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו תוקף אשראי תקין</strong>
                </span>
        @endif
    </div>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">שנה</h4></label>
        <select id="year" name="year" class="col-9 form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{ old('year') }}" required>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
        </select>
        @if ($errors->has('year'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו תוקף אשראי תקין</strong>
                </span>
        @endif
    </div>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">3 ספרות בגב כרטיס</h4></label>
        <input id="cvv" name="cvv" type="text" class="col-9 form-control{{ $errors->has('cvv') ? ' is-invalid' : '' }}" value="{{ old('cvv') }}" required maxlength="3" minlength="3" placeholder="CVV">
        </input>
        @if ($errors->has('cvv'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו CVV תקין</strong>
                </span>
        @endif
    </div>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">ת"ז של בעל הכרטיס</h4></label>
        <input id="tz" name="tz" type="text" class="col-9 form-control{{ $errors->has('tz') ? ' is-invalid' : '' }}" value="{{ old('tz') }}" required maxlength="9" minlength="9" placeholder="תז">
        </input>
        @if ($errors->has('tz'))
            <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו ת"ז תקין</strong>
                </span>
        @endif
    </div>
    <div class="row">
        <label class="to-the-right col-3"><h4 class="service-description">הערות נוספות</h4></label>
        <input id="comment" name="comment" type="text" maxlength="50" class="col-9 form-control" placeholder="הערות נוספות(עד 50 תווים)" >

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
            @if(env('APP_ENV') == 'local')
                {!! app('captcha')->render(); !!}
            @endif
            <button type="submit" class="btn login-btn" value="דווח!">הטען!</button>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>g-recaptcha-response</strong>
                </span>
                @endif
        </div>
    </div>
    {!! Form::close() !!}
    @endif

@endsection

@section('page-scripts')
    <script type="text/javascript">
        function legalTz(num) {
            console.log(num);
            var tot = 0;
            var tz = new String(num);
            for (i=0; i<8; i++)
            {
                x = (((i%2)+1)*tz.charAt(i));
                if (x > 9)
                {
                    x =x.toString();
                    x=parseInt(x.charAt(0))+parseInt(x.charAt(1))
                }
                tot += x;
            }

            if ((tot+parseInt(tz.charAt(8)))%10 == 0) {
                return true;
            } else {

                alert("תז לא תקין")
                return false;
            }
        }
    </script>

@endsection