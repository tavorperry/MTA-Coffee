@extends('layouts.master')

@section('page-style')
    <link href="{{env('APP_URL')}}/css/payforcard.css" media="all" rel="stylesheet" type="text/css" />
    <link href="{{env('APP_URL')}}/css/pay.css" media="all" rel="stylesheet" type="text/css" />
@endsection

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PayPal js file -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>



@section('content')

    <body>
<h1 class="service-description">באיזה סכום ברצונך להטעין את הכרטיס הנטען?</h1>
<hr>
<br>
<p class="container" dir="rtl">
    <input type="text" name="total" class="form-control bfh-number" value="10" data-min="5" data-max="25">
<br>
<div class="container">
    <div class=" btn-group-toggle row" data-toggle="buttons">
        <label class="btn btn-info col-6  active">
            <input type="radio" name="havecard" autocomplete="off" value="Yes" checked> יש ברשותי כבר כרטיס
        </label>
        <label class="btn btn-info col-6 ">
            <input type="radio" name="havecard" autocomplete="off" value="No"> רוצה להזמין כרטיס חדש
        </label>
    </div>
</div>
<br>
<br>
<div class="button" id="displayChange">
    <div id="paypal-button" ></div>
</div>
<div class="modal"></div>
@endsection

@section('page-scripts')

<script>
    function getTotal () {
        var total = $('input[type="text"][name="total"]').val();
        if(total > 0)
            return total;
        else return 10; //This is a default value if the user didn't enter nothing
    }
    function getHaveCardVal() {
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
                            havecard: getHaveCardVal()
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
                                //alert("תודה ! התשלום התקבל ומספר הקבלה במערכת שלנו הינו: " + InvoiceID);
                                window.location.replace("/");
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
<script>
    $( document ).ready(function() {
        $("#display-side-menu").css("padding-top", "15px");
    });
</script>
<script>
    $body = $("body");
    $(document).on({
        ajaxStart: function() { $body.addClass("loading");},
        ajaxStop: function() { $body.removeClass("loading"); }
    });
</script>
@endsection



