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
    <link href="{!! asset('css/index.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <title>MTAcoffee</title>
  </head>

  <body>
  <!-- Navigation -->
  <a class="menu-toggle rounded" href="#">
    <i class="fa fa-bars"></i>
  </a>
  <nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-brand">
        <a class="js-scroll-trigger" href="{{ route('home') }}">קפה אמון</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="{{ route('home') }}">חזור לדף הבית</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="{{ route('pay') }}">שלם על קפה</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="{{ route('payforcard') }}">הטען כרטיס</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="{{ route('reports.create') }}">דיווח על תקלה</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="{{ route('station') }}">עדכון משמרות</a>
      </li>
    </ul>
  </nav>

  <header class="master-head" id="page-top">
    <div class="notification-bar">
    </div>
    <div class="container text-center my-auto" style="padding-bottom: 60px;">
      @if(Auth::user())
        <h1>{{ Auth::user()->first_name. ' ' .Auth::user()->last_name }}</h1>
        <!-- ADD LEVEL TAG -->
        <h2>נקודות:&nbsp;{{ Auth::user()->points }}</h2>
      @else
        <h1>קפה אמון</h1>
        <h3>חזק, על בסיס אמון</h3>
      @endif
    </div>
    <div class="overlay"></div>
    <div class="round-div"></div>
  </header>

  <main class="func-buttons" style="position: relative;top: 50px;">
    <div class="container">
        @if(Auth::user())
        <div class="row">
          <a href="{{ route('notifications.show') }}" class="btn menu-btn col"> <i class="far fa-flag menu-btn-icon"></i><br>
            התראות
            <span class="badge badge-pill badge-danger" style="position: absolute;
    top: 10%;
    right: 70%;">
              {{ count($unread_notifications) }}
            </span>
          </a>
          <a href="{{ route('reports.create') }}" class="btn menu-btn col"><i class="fas fa-exclamation-triangle menu-btn-icon"></i><br>
            דווח!
          </a>
          <a href="{{ route('station') }}" class="btn menu-btn col"><i class="far fa-calendar-alt menu-btn-icon"></i><br>
            משמרות
          </a>
        </div>
        <div class="row">
          <a href="{{ route('pay') }}" class="btn menu-btn col"><i class="far fa-credit-card menu-btn-icon"></i><br>
            שלם עכשיו
          </a>
          <a href="{{ route('pay') }}" class="btn menu-btn col"><i class="far fa-envelope menu-btn-icon"></i><br>
            צור קשר
          </a>
          <a href="{{ route('payforcard') }}" class="btn menu-btn col"><i class="far fa-id-card menu-btn-icon"></i><br>
            הזמן כרטיס
          </a>
        </div>
          <form action="{{ route('logout') }}" method="POST" style="text-align: right; margin-top: 100px">
            @csrf
            <input type="hidden" class="deviceUserId" name="device_id">
            <button type="submit">LOGOUT</button>
            </a>
          </form>
        </div>
        @else
        <hr>
        <h2 class="service-description text-center">השירותים שלנו</h2>
        <div class="row">
          <button type="button" href="{{ route('notifications.show') }}" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="קבל התרעות מדיווחים של משתמשים אחרים וקבל נקודות!"> <i class="far fa-flag menu-btn-icon"></i><br>
            התרעות
          </button>
          <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="קבל התרעות מדיווחים של משתמשים אחרים וקבל נקודות!"><i class="fas fa-exclamation-triangle menu-btn-icon"></i><br>
            דווח!
          </button>
          <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="קבל התרעות מדיווחים של משתמשים אחרים וקבל נקודות!"><i class="far fa-calendar-alt menu-btn-icon"></i><br>
            משמרות
          </button>
        </div>
        <div class="row">
          <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="bottom" data-content="קבל התרעות מדיווחים של משתמשים אחרים וקבל נקודות!"><i class="far fa-credit-card menu-btn-icon"></i><br>
            שלם עכשיו
          </button>
          <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="bottom" data-content="קבל התרעות מדיווחים של משתמשים אחרים וקבל נקודות!"><i class="far fa-envelope menu-btn-icon"></i><br>
            צור קשר
          </button>
          <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="bottom" data-content="קבל התרעות מדיווחים של משתמשים אחרים וקבל נקודות!"><i class="far fa-id-card menu-btn-icon"></i><br>
            הזמן כרטיס
          </button>
        </div>
        <div class="to-the-right">
          <form action="{{ route('login.google') }}">
            @csrf
            <input type="hidden" class="deviceUserId" name="device_id">
            <button type="submit" class="google-signin-btn" style="">GOOGLE</button>
          </form>

          <p><a href="{{ route('login') }}">לחץ כאן להתחברות</a></p>
          <p><a href="{{ route('register') }}">לחץ כאן להרשמה</a></p>
        </div>
        @endif
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
  <script type="text/javascript" src="{!! asset('js/index.js') !!}"></script>
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>

  <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
          OneSignal.init({
              appId: "3a5c67a0-1c84-41ee-946f-5a8509e90a78",
          });
      });
  </script>
  @include('sweet::alert')
  </body>
</html>