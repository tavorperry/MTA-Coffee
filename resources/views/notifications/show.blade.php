@extends('layouts.master')

@section('content')

<div class="container">
    <div>
        <h2 class="service-description text-center">דיווחים פתוחים</h2>
        @if(empty($notifications))
            <h5 class="text-center">הידד! אין דיווחים פתוחים</h5>
        @else
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
        @endif
        <hr>
        <h2 class="service-description text-center">דיווחים סגורים</h2>
        @if(empty($notifications))
            <h5 class="text-center">הידד! אין דיווחים סגורים</h5>
        @else
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
        @endif
    </div>
</div>
@endsection