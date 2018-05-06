<html lang="heb">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .width100{
            width: 100%;
        }
        .width30{
            width: 30%;
        }
        .button{
            text-align: center;
            margin: auto;
            width: 80%;
        }
        h1{
            text-align: center;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- PayPal js file -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Sweet Alerts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
</head>
<body>

<h1>?כמה כוסות תרצה לשתות</h1>

<br>
<p class="container">
<div class="btn-group btn-group-toggle row width100" data-toggle="buttons">
    <label class="btn btn-primary col width30">
        <input type="radio" name="total" autocomplete="off" value="1" checked> 1
    </label>
    <label class="btn btn-primary col width30">
        <input type="radio" name="total" autocomplete="off" value="2"> 2
    </label>
    <label class="btn btn-primary col width30">
        <input type="radio" name="total" autocomplete="off" value="3"> 3
    </label>
    <br>
    <label class="btn btn-primary col width30">
        <input type="radio" name="total" autocomplete="off" value="4"> 4
    </label>
    <label class="btn btn-primary col width30">
        <input type="radio" name="total" autocomplete="off" value="5"> 5
    </label>
    <label class="btn btn-primary col width30">
        <input type="radio" name="total" autocomplete="off" value="6"> 6
    </label>
</div>
<br>
    <div class="button">
<div id="paypal-button"></div>
</div>
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
                alert("התשלום התקבל!");
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
                        alert("Thank You " + payerData.first_name + " " + payerData.last_name + ". Invoice No." + InvoiceID + " Created");
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
</body>
@include('sweet::alert')
</html>