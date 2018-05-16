@extends('layouts.index')

@section('content')
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
        <h2 class="service-description text-center">השירותים שלנו - לחץ וקבל הסבר על כל שירות :)</h2>
        <div class="row">
            <button type="button" href="{{ route('notifications.show') }}" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="קבל התרעות מדיווחים של משתמשים אחרים וקבל נקודות!"> <i class="far fa-flag menu-btn-icon"></i><br>
                התרעות
            </button>
            <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="דווח על תקלות בעמדה וצבור נקודות!"><i class="fas fa-exclamation-triangle menu-btn-icon"></i><br>
                דווח!
            </button>
            <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="שבץ עצמך מתי שאתה רוצה וקבל התראות על דיווחים מותאמים"><i class="far fa-calendar-alt menu-btn-icon"></i><br>
                משמרות
            </button>
        </div>
        <div class="row">
            <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="bottom" data-content="שלם בקלות על המוצרים שאתה לוקח מעמדת קפה אמון"><i class="far fa-credit-card menu-btn-icon"></i><br>
                שלם עכשיו
            </button>
            <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="bottom" data-content="לכל שאלה, בעיה והצעות שיפור/שימור - אנחנו זמינים!"><i class="far fa-envelope menu-btn-icon"></i><br>
                צור קשר
            </button>
            <button type="button" class="btn menu-btn col" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="bottom" data-content="הזמן כרטיס נטען לעמדה והוא יחכה לך באגודת הסטודנטים"><i class="far fa-id-card menu-btn-icon"></i><br>
                הזמן כרטיס
            </button>
        </div>
        <div class="to-the-right">
            <form action="{{ route('login.google') }}">
                @csrf
                <input type="hidden" class="deviceUserId" name="device_id">
                <button type="submit" class="google-signin-btn" style="">GOOGLE</button>
            </form>

            <p><a href="{{ route('login') }}">לחץ כאן להתחברות/הרשמה</a></p>
        </div>
        @endif
@endsection