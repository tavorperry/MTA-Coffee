<?php $auth_user = Auth::user() ?>
@extends('layouts.index')

@section('user-welcome')
    @if($auth_user)
        <section>
            <h1 class="d-inline">{{ $auth_user->first_name. ' ' .$auth_user->last_name }}</h1>
            <?php $level = $auth_user->getLevel() ?>
        </section>
        <div class="mt-4 mb-2">
            @if($level == '10s')
                <i class="fas fa-trophy user-level user-level-top"></i>
            @else
                <i class="fas fa-trophy user-grey"></i>
                @for($i=1; $i<=9-$level; $i++)
                    <i class="fas fa-coffee user-grey"></i>
                @endfor
                @for($i=0; $i<$level; $i++)
                    <i class="fas fa-coffee user-level"></i>
                @endfor
            @endif
        </div>
        <h3>נקודות:&nbsp;{{ $auth_user->points }}</h3>
    @else
        <h1>קפה אמון</h1>
        <h3>חזק, על בסיס אמון</h3>
    @endif
@endsection

@section('content')
    @if($auth_user)
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
        </div>
        <div class="row">
            <a href="{{ route('report.view.all') }}" class="btn menu-btn col"><i class="far fa-envelope menu-btn-icon"></i><br>
                כל הדיווחים
            </a>
            <a href="{{ route('station') }}" class="btn menu-btn col"><i class="far fa-calendar-alt menu-btn-icon"></i><br>
                התנדבות
            </a>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mt-5">
            @csrf
            <a>
                <button type="submit" class="btn login-btn">התנתקות</button>
            </a>
        </form>
    @else
        <h2 class="service-description text-center">השירותים שלנו :)</h2>
        <hr width="50%">
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-4 text-center">
                    <div class="service-icon">
                        <i class="far fa-flag"></i>
                    </div>
                    <h3>התראות</h3>
                    <p class="lead mb-0">קבל התראות מדיווחים של משתמשים אחרים וקבל נקודות!</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-4 text-center">
                    <div class="service-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>דווח!</h3>
                    <p class="lead mb-0">דווח על תקלות בעמדה וצבור נקודות!</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-5 mb-lg-0 mb-lg-3 text-center">
                    <div class="service-icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <h3>התנדבות</h3>
                    <p class="lead mb-0">שבץ עצמך מתי שאתה רוצה וקבל התראות על דיווחים מותאמים</p>
                </div>
            </div>
        </div>
        @endif
@endsection
@section('page-script')

@endsection