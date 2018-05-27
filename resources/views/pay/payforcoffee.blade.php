@extends('layouts.master')

@section('page-style')
    <link href="{!! asset('css/pay.css') !!}" media="all" rel="stylesheet" type="text/css" />
@endsection
<head>
    <!-- PayPal js file -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
        <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
@section('content')
<h1 class="service-description">על כמה כוסות תרצה לשלם?</h1>
<hr>
<div class="container">
    <div class=" btn-group-toggle row" data-toggle="buttons">
        <label class="btn btn-info col-4 btn-block first_button">
            <input type="radio" name="total" autocomplete="off" value="1" checked> 1
        </label>
        <label class="btn btn-info col-4 btn-block">
            <input type="radio" name="total" autocomplete="off" value="2"> 2
        </label>
        <label class="btn btn-info col-4 btn-block">
            <input type="radio" name="total" autocomplete="off" value="3"> 3
        </label>

        <label class="btn btn-info col-4 btn-block">
            <input type="radio" name="total" autocomplete="off" value="4"> 4
        </label>
        <label class="btn btn-info col-4 btn-block">
            <input type="radio" name="total" autocomplete="off" value="5"> 5
        </label>
        <label class="btn btn-info col-4 btn-block">
            <input type="radio" name="total" autocomplete="off" value="6"> 6
        </label>
    </div>
</div>

<br>
<div class="paypalbutton" id="displayChange">
<div id="paypal-button"></div>
</div>
<div class="modal"></div>
@endsection
@section('page-scripts')
<script>
    function getTotal () {
        var total = $('input[type="radio"][name="total"]:checked').val();
        return total;
    }
</script>

<script>
    $(document).ready(function () {
        if(typeof jQuery=="undefined"){
            alert("jQuery id undefined");
        } else {
    var total;
    var price = 2;

    paypal.Button.render(
        {
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
                console.log("Payment accepted");
                var payerData = payment.payer.payer_info;
               //From here till End its sending payerData data to the Controller
                var data = {
                    email: payerData.email,
                    first_name: payerData.first_name,
                    last_name: payerData.last_name,
                    total_payment: Number(getTotal()*price),
                    coffee_or_card: 'Coffee',
                    havecard: null
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
                        window.location.replace("/"); //redirect to main page
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
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }
    });
</script>
@endsection

