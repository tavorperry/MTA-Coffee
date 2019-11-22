        <?php
            $user = auth::user();
            $first_name = $user->first_name;
            $last_name = $user->last_name;
        ?>


        <html dir="rtl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
            <link href="{{env('APP_URL')}}/css/index.css" media="all" rel="stylesheet" type="text/css" />
            <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Varela+Round" rel="stylesheet">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @yield('page-style')
            <title>MTAcoffee</title>


            <!-- Google Analytics -->
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{env('Google_Analytics_id')}}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config','{{env('Google_Analytics_id')}}');
            </script>

            <!-- End of Google Analytics -->
        </head>
        <body dir="rtl">

        <main class="container">
            <div class="container content text-right">
                <br>


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

                <br>
                <br>
            </div>
        </main>
        </body>
        </html>


    <script>
        alert("כרטיסך חיוב אך יש תקלה אצלנו במערכת! אנא צור קשא איתנו כדי לקבל זיכוי. תודה וסליחה!");
    </script>
