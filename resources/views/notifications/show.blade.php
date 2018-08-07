@extends('layouts.master')

@section('page-style')
    <link href="{!! asset('css/notifications.css') !!}" media="all" rel="stylesheet" type="text/css"
          xmlns="http://www.w3.org/1999/html"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{env('APP_URL')}}/js/notifications.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@endsection

@section('content')
<div class="container">
    <div>
        <h2 class="service-description text-center">דיווחים פתוחים</h2>
        @if(empty($notifications))
            <h5 class="text-center">הידד! אין דיווחים</h5>
        @else
            <div class="">
                <table class="text-center table table-striped">
                    <tr>
                        <th scope="col">בניין</th>
                        <th scope="col" class="clear_in_mobile">סוג</th>
                        <th scope="col" class="">מועד דיווח</th>
                        <th scope="col" class="">תמונה</th>
                      {{--  <th scope="col" class="">סטטוס</th>--}}
                    </tr>
            @foreach($notifications as $notification)
                @if($notification->read_at == NULL)
                            <tr class="main-tr">
                                <td scope="row">
                                    <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                        <span id="station_id_{{$notification->data['report_id']}}">
                                            {{ $notification->data['station'] }}
                                    </span></a>
                                </td>
                                <td class="clear_in_mobile">
                                    <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                    {{ $notification->data['type'] }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                    {{ \App\Http\Controllers\NotificationController::calcTime($notification) }}
                                    </a>
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
        @endif
        <hr>
        <h2 class="service-description text-center">דיווחים סגורים</h2>
        @if(empty($notifications))
            <h5 class="text-center">הידד! אין דיווחים</h5>
        @else
                    <div class="table-responsive">
                        <table class="text-center table table-striped">
                            <tr>
                                <th scope="col">בניין</th>
                                <th scope="col" class="clear_in_mobile">סוג</th>
                                <th scope="col" class="">מועד דיווח</th>
                                <th scope="col" class="">תמונה</th>
                              {{--  <th scope="col" class="">סטטוס</th>--}}
                            </tr>
            @foreach($notifications as $notification)
                @if($notification->read_at != NULL)
                        <tr class="main-tr">
                            <td scope="row">
                                <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                        <span id="station_id_{{$notification->data['report_id']}}">
                                            {{ $notification->data['station'] }}
                                    </span></a>
                            </td>
                            <td class="clear_in_mobile">
                                <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                    {{ $notification->data['type'] }}
                                </a>
                            </td>
                            <td>
                                <a href="{{env('APP_URL')}}/reports/view/{{$notification->data['report_id']}}">
                                    {{ \App\Http\Controllers\NotificationController::calcTime($notification) }}
                                </a>
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