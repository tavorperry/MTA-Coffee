
<html lang="heb">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
</div>
    <br>
    <div class="btn-group btn-group-toggle row width100" data-toggle="buttons">
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
</div>

    <script>
        function getTotal () {
            var total = $('input[type="radio"][name="total"]:checked').val();
            return total;
        }
</script>


{{--
<script>


    // Render the PayPal button

    paypal.Button.render({

        // Pass in the Braintree SDK

        braintree: braintree,

        // Pass in your Braintree authorization key

        client: {
            sandbox: paypal.request.get('/demo/checkout/api/braintree/client-token/'),
            production: '<insert production auth key>'
        },

        // Set your environment

        env: 'sandbox', // sandbox | production

        // Wait for the PayPal button to be clicked

        payment: function(data, actions) {

            // Make a call to create the payment

            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '0.01', currency: 'USD' }
                        }
                    ]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {

            // Call your server with data.nonce to finalize the payment

            console.log('Braintree nonce:', data.nonce);

            // Get the payment and buyer details

            return actions.payment.get().then(function(payment) {
                console.log('Payment details:', payment);
            });
        }

    }, '#paypal-button-container');




</script>






--}}
















{{--//Normal Paypal - no Braintree
//from here to ENDNormal--}}
<script>
    //I added this to try getting the ajax workng
/*    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });*/

    paypal.Button.render({
        env: 'sandbox', //'production' Or 'sandbox'
        style: {
            label: 'paypal',
            size:  'responsive',    // small | medium | large | responsive
            shape: 'rect',     // pill | rect
            color: 'blue',     // gold | blue | silver | black
            tagline: false
        },



        client: {
            sandbox:'AbHx3unTKagITRdRsL7Is4HfDD4rQB5kdDXf4xSKrGVK9JjIIyWagnFw7W42QsAWYAjn0pONpQrFe3Fq',
            production: 'xxxxxxxxx'
        },

        commit: true, // Show a 'Pay Now' button
        payment: function(data, actions) {
            var price = 2;
            total=2; //This is default value if the user didn't choose any button
            total = getTotal();
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: (total*price), currency: 'ILS' }
                        }
                    ]
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
            alert("An error occurred during the transaction ");
            alert(err);
        },
        onAuthorize: function(data, actions) {
            console.log($(this).data("data"));
            console.log(data);
            return actions.payment.execute().then(function(payment) {
                var payerData = payment.payer.payer_info;
                console.log(payerData);
                alert("Thank You " + payerData.first_name + " " + payerData.last_name);


               //From here till End I am working on sending payerData to the Controller
                /*var data = payerData ;
                $.ajax({
                    type: "POST",
                    url: 'JStoPHP',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        console.log("Value added " + data);
                    }
                });*/
                //End

                // The payment is complete!
                // You can now show a confirmation message to the customer
                var payer = data.payer;
                console.log(payer);
            });
        }

    }, '#paypal-button');
</script>
{{--//ENDnormal--}}
</body>
</html>
