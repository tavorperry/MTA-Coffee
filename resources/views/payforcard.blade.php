@extends('layouts.master')

@section('page-style')
    <link href="{!! asset('css/payforcard.css') !!}" media="all" rel="stylesheet" type="text/css" />
@endsection

{{--<html lang="heb" dir="rtl">--}}
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    {{--<style>--}}
        {{--.width100{--}}
              {{--width: 100%;--}}
          {{--}--}}
        {{--.width50{--}}
            {{--width: 50%;--}}
            {{--margin: auto !important;--}}
            {{--text-align: center !important;--}}
            {{--direction: ltr; !important;--}}
            {{--float: left; !important;--}}
        {{--}--}}

        {{--h1{--}}
            {{--text-align: center;--}}
        {{--}--}}
        {{--textarea{--}}
            {{--text-align: center;--}}
            {{--margin: auto;--}}
        {{--}--}}
    {{--</style>--}}

    {{--<meta charset="utf-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <!-- PayPal js file -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <!-- Latest compiled and minified CSS -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Sweet Alerts -->
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>--}}
</head>



@section('content')
<body>
<h1 class="service-description">באיזה סכום ברצונך להטעין את הכרטיס הנטען?</h1>

<hr>

<br>
<p class="container" dir="rtl">
    <input type="text" name="total" class="form-control bfh-number" value="10" data-min="5" data-max="25">
<br>
<div class="btn-group btn-group-toggle row width100" data-toggle="buttons">
    <label class="btn btn-primary col width50 active">
        <input type="radio" name="havecard" autocomplete="off" value="Yes" checked> יש ברשותי כבר כרטיס
    </label>
    <label class="btn btn-primary col width50">
        <input type="radio" name="havecard" autocomplete="off" value="No"> רוצה להזמין כרטיס חדש
    </label>
</div>
<br>
<br>
<div class="button" id="displayChange">
    <div id="paypal-button" ></div>
</div>

@endsection

@section('page-scripts')



<script>
    function getTotal () {
        var total = $('input[type="text"][name="total"]').val();
        if(total > 0)
            return total;
        else return 10; //This is a default value if the user didn't enter nothing
    }
    function getHaveCareVal() {
        var havecard = $('input[type="radio"][name="havecard"]:checked').val();
            return havecard;
    }
</script>
<script>
    $(document).ready(function () {
        if(typeof jQuery=="undefined"){
            alert("jQuery id undefined");
        } else {
            var total=10;
            var price = 1;
            paypal.Button.render({
                env: 'sandbox', //'production' Or 'sandbox'
                style: {
                    label: 'pay',
                    size:  'responsive', // small | medium | large | responsive
                    shape: 'rect',   // pill | rect
                    color: 'gold'   // gold | blue | silver | black
                },

                client: {
                    sandbox:'AbHx3unTKagITRdRsL7Is4HfDD4rQB5kdDXf4xSKrGVK9JjIIyWagnFw7W42QsAWYAjn0pONpQrFe3Fq',
                    production: 'xxxxxxxxx'
                },

                commit: true, // Show a 'Pay Now' button
                payment: function(data, actions) {
                    total = getTotal();
                    return actions.payment.create({
                        payment: {
                            transactions: [
                                {
                                    amount: { total: (total*price), currency: 'ILS' }
                                }
                            ]
                        },
                        experience: {
                            input_fields: {
                                no_shipping: 1
                            }
                        }
                    });
                },
                onCancel: function(data, actions) {
                    /*
                     *Buyer cancelled the payment
                     */
                    alert("Buyer cancelled the payment");

                },

                onError: function(err) {
                    /*
                     * An error occurred during the transaction
                     */
                    alert("An error occurred during the transaction " + err);
                },
                onAuthorize: function(data, actions) {
                    return actions.payment.execute().then(function(payment) {
                        var payerData = payment.payer.payer_info;
                        //From here till End its sending payerData data to the Controller
                        var data = {
                            email: payerData.email,
                            first_name: payerData.first_name,
                            last_name: payerData.last_name,
                            total_payment: Number(getTotal()*price),
                            coffee_or_card: 'Card',
                            havecard: getHaveCareVal()
                        };
                        $.ajax({
                            method: "POST",
                            url: location.href,
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(InvoiceID) {
                                console.log("Invoice No. " + InvoiceID + " Created");
                                alert("תודה ! התשלום התקבל ומספר הקבלה במערכת שלנו הינו: " + InvoiceID);
                            }
                        });
                        //End
                        // The payment is complete!
                    });
                }

            }, '#paypal-button');
        }
    });
</script>
@endsection

@include('sweet::alert')
