<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link href="{{env('APP_URL')}}/css/index.css" media="all" rel="stylesheet" type="text/css" />
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
<a class="menu-toggle rounded part-of-nav" href="#">
    <i class="fa fa-bars part-of-nav"></i>
</a>
<nav id="sidebar-wrapper">
    <ul class="sidebar-nav part-of-nav">
        <li class="sidebar-brand part-of-nav">
            <a class="js-scroll-trigger part-of-nav">קפה אמון</a>
        </li>
        <li class="sidebar-nav-item part-of-nav">
            <a class="js-scroll-trigger part-of-nav" href="{{ route('home') }}">דף הבית</a>
        </li>
        <li class="sidebar-nav-item part-of-nav">
            <a class="js-scroll-trigger part-of-nav" href="{{ route('profile') }}">הפרופיל שלי</a>
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
        <li class="sidebar-nav-item part-of-nav">
            <a class="js-scroll-trigger part-of-nav" href="{{ route('contact-us') }}">צור קשר</a>
        </li>
        @if(Auth::user())
            <li class="sidebar-nav-item part-of-nav">
                <a class="js-scroll-trigger part-of-nav" href="{{ route('logout') }}">התנתקות</a>
            </li>
        @else
            <li class="sidebar-nav-item part-of-nav">
                <a class="js-scroll-trigger part-of-nav" href="{{ route('register') }}">הרשמה</a>
            </li>
            <li class="sidebar-nav-item part-of-nav">
                <a class="js-scroll-trigger part-of-nav" href="{{ route('login') }}">התחברות</a>
            </li>
        @endif
    </ul>
</nav>

<header class="master-head" id="page-top">
    <div class="notification-bar">
        @if(!Auth::user())
            <a href="{{ route('login') }}" class="btn btn-secondary active login-btn-top" role="button" aria-pressed="true">התחבר/י</a>
            <a href="{{ route('register') }}" class="btn btn-secondary active login-btn-top" role="button" aria-pressed="true">הרשם/י</a>
        @endif
    </div>
    <div class="container text-center my-auto pb-4">
        @yield('user-welcome')
    </div>
    <div class="overlay"></div>
    <div class="round-div"></div>
</header>

<main class="func-buttons" style="position: relative;top: 50px;">
    <div class="container">
        @yield('content')
    </div>
</main>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>

<!-- jQuery, Popper.js, Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.compatibility.js"></script>
<!-- Index JavaScript -->
<script type="text/javascript" src="{{env('APP_URL')}}/js/index.js"></script>

@include('sweet::alert')
</body>
</html>