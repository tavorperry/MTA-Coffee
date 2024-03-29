@extends('layouts.master')

@section('page-style')
    <link href="{{env('APP_URL')}}/css/notifications.css" media="all" rel="stylesheet" type="text/css"
          xmlns="http://www.w3.org/1999/html"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{env('APP_URL')}}/js/notifications.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@endsection
@section('content')
<div class="container">
    <div>
        <?php

        if($notifications->count() > 0){
            if(($notifications[0]->data['station']) == 1)
                $station_name = 'פומנטו';
            if(($notifications[0]->data['station']) == 2)
                $station_name = 'ווסטון';
            if(($notifications[0]->data['station']) == 3)
                $station_name = 'כלכלה';
       echo '<h2 class="service-description text-center preety_font">דיווחים פתוחים - בניין '.$station_name.'</h2>';
        }
        ?>
        @if($notifications->count() <= 0)
            <h2 class=" service-description text-center preety_font">הידד! אין דיווחים</h2>
        @else
            <div>
                <table class="text-center table table-striped">
                    <tr>
                        <th scope="col" class="clear_in_mobile">סוג</th>
                        <th scope="col" class="">מועד דיווח</th>
                        <th scope="col" class="">תמונה</th>
                        <th scope="col">לינק לדיווח</th>
                    </tr>
            @foreach($notifications as $notification)
                @if($notification->read_at == NULL)
                            <tr class="main-tr">
                                <td class="clear_in_mobile">
                                    {{--<a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">--}}
                                    {{$notification->data['type']}}
                                    {{--</a>--}}
                                </td>
                                <td>
                                    {{--<a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">--}}
                                    {{\App\Http\Controllers\NotificationController::calcTime($notification)}}
                                    {{--</a>--}}
                                </td>
                                <td>
                                    @if(!empty($notification->data['picture']))
                                        <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                            <img src="{{env('APP_URL')}}/pictures/{{$notification->data['picture']}}" alt="report picture" class="report_pic">
                                        </a>
                                        @else
                                            <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                                <img src="{{env('APP_URL')}}/pictures/no_pic.png" alt="report picture" class="report_pic">
                                            </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                        לחץ כאן
                                    </a>
                                </td>
{{--                                <td>
                                    <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                        <span id="status_id_{{$notification->data['report_id']}}">
                                            {{$notification->data['status']}}
                                        </span></a>
                                </td>--}}
                            </tr>
            <script>
                $(document).ready(function(){
                    ReplaceStationNumbersWithNames("#station_id_{{$notification->data['report_id']}}");
                  /*  ReplaceStatusNumberWithText("#status_id_{{$notification->data['report_id']}}");*/
                });
            </script>
            @endif
            @endforeach
            </table>
        <hr>
        <h2 class="service-description text-center preety_font">דיווחים סגורים</h2>
                    <div>
                        <table class="text-center table table-striped">
                            <tr>
                                <th scope="col" class="clear_in_mobile">סוג</th>
                                <th scope="col" class="">מועד דיווח</th>
                                <th scope="col" class="">תמונה</th>
                                <th scope="col">לינק לדיווח</th>
                            </tr>
            @foreach($notifications as $notification)
                @if($notification->read_at != NULL)
                        <tr class="main-tr">
                            <td class="clear_in_mobile">
                                {{--<a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">--}}
                                    {{ $notification->data['type'] }}
                               {{-- </a>--}}
                            </td>
                            <td>
                           {{-- <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">--}}
                                    {{ \App\Http\Controllers\NotificationController::calcTime($notification) }}
                               {{-- </a>--}}
                            </td>
                            <td>
                                @if(!empty($notification->data['picture']))
                                    <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                        <img src="{{env('APP_URL')}}/pictures/{{$notification->data['picture']}}" alt="report picture" class="report_pic">
                                    </a>
                                @else
                                    <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                        <img src="{{env('APP_URL')}}/pictures/no_pic.png" alt="report picture" class="report_pic">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                    לחץ כאן
                                </a>
                            </td>
                           {{-- <td>
                                <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                        <span id="status_id_{{$notification->data['report_id']}}">
                                            {{$notification->data['status']}}
                                        </span></a>
                            </td>--}}
                        </tr>
                        <script>
                            $(document).ready(function(){
                                ReplaceStationNumbersWithNames("#station_id_{{$notification->data['report_id']}}");
                               /* ReplaceStatusNumberWithText("#status_id_{{$notification->data['report_id']}}");*/
                            });
                        </script>
                @endif
            @endforeach
            </table>
        @endif
    </div>
</div>
</div>

@endsection