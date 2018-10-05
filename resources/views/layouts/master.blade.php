<!DOCTYPE html>
    <html dir="rtl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
            <link href="{{env('APP_URL')}}" media="all" rel="stylesheet" type="text/css" />
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

    <body>
        <!-- Navigation -->
        <a  class="menu-toggle rounded part-of-nav" id="display-side-menu" href="#">
            <i class="fa fa-bars part-of-nav"></i>
        </a>
        <nav   id="sidebar-wrapper" class="part-of-nav">
            <ul class="sidebar-nav part-of-nav">
                <li class="sidebar-brand part-of-nav">
                    <a class="js-scroll-trigger part-of-nav" href="{{ route('home') }}">קפה אמון</a>
                </li>
                <li class="sidebar-nav-item part-of-nav">
                    <a class="js-scroll-trigger part-of-nav" href="{{ route('home') }}">דף הבית</a>
                </li>
                <li class="sidebar-nav-item part-of-nav">
                    <a class="js-scroll-trigger part-of-nav" href="{{ route('reports.create') }}">דיווח על תקלה</a>
                </li>
                <li class="sidebar-nav-item part-of-nav">
                    <a class="js-scroll-trigger part-of-nav" href="{{ route('station') }}">עדכון משמרות</a>
                </li>
                <li class="sidebar-nav-item part-of-nav">
                    <a class="js-scroll-trigger part-of-nav" href="{{ route('report.view.all') }}">צפייה בכל הדיווחים</a>
                </li>
            </ul>
        </nav>

        <header class="master-head" id="page-top">
            <span>
                <a href="{{route('home')}}" title="Home Page"><i class="fas fa-home back-to-home"></i></a>
            </span>
            <div class="round-div"></div>
            <div class="container text-center my-auto">
                <a href="{{route('home')}}" title="Home Page" style="text-decoration: none"><h3 id="navtext">חזק, על בסיס אמון</h3></a>
            </div>
            <div class="overlay"></div>
        </header>

        <main>
            <div class="container content text-right">
                <br>
                @yield('content')
                <br>
                <br>
            </div>
        </main>


        <footer class="footer">
            <div class="row">
                <div class="col copyright">
                    <p>Made by MTA-Coffee Team &copy; 2018</p>
                </div>
            </div>
        </footer>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>

        <!-- jQuery, Popper.js, Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.compatibility.js"></script>

        <!-- Index JavaScript -->
        <script type="text/javascript" src="{!! asset('js/index.js') !!}"></script>
        @yield('page-scripts')
        @include('sweet::alert')

        <script>
            $("#display-side-menu").click(function() {
                var x = $("#displayChange");
                if (x.css("display") === "none") {
                    x.fadeIn(400);
                } else {
                    x.fadeOut(400);
                }
            });
        </script>
    </body>
</html>