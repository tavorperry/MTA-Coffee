@extends('layouts.master')

@section('content')

<div class="container">
    <div>
        <h2 class="service-description">דיווחים פתוחים</h2>
        @foreach($notifications as $notification)
            @if($notification->read_at == NULL)
                <div class="alert alert-warning" role="alert">
                    <b>{{ $notification->data['type'] }}</b>
                    בניין: {{ $notification->data['station'] }}
                    תיאור:{{ $notification->data['description'] }}
                    נפתח ע"י:{{ $notification->data['user']['first_name'] }} {{ $notification->data['user']['last_name'] }}
                    <b>{{ \App\Http\Controllers\NotificationController::calcTime($notification) }}</b>
                    <a href="../reports/view/{{ $notification->data['report_id'] }}" class="alert-link">לינק לדיווח</a>
                </div>
            @endif
        @endforeach
        <hr>
        <h2 class="service-description">דיווחים סגורים</h2>
        @foreach($notifications as $notification)
            @if($notification->read_at != NULL)
                <div class="alert alert-secondary" role="alert">
                    <b>{{ $notification->data['type'] }}</b>
                    בניין: {{ $notification->data['station'] }}
                    תיאור:{{ $notification->data['description'] }}
                    נפתח ע"י:{{ $notification->data['user']['first_name'] }} {{ $notification->data['user']['last_name'] }}
                    <b>{{ \App\Http\Controllers\NotificationController::calcTime($notification) }}</b>
                    <a href="../reports/view/{{ $notification->data['report_id'] }}" class="alert-link">לינק לדיווח</a>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection