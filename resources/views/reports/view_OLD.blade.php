@extends('layouts.master')
<link href="{!! asset('css/view.css') !!}" media="all" rel="stylesheet" type="text/css" />

@section('content')

    <div class="container">
        <div class="row justify-content-center position-relative" style="bottom:30px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center"><b> דיווח מספר {{ $report->id }} </b></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-form-label to-the-right">
                                בניין:

                                @if($report->station_id == 1)
                                    {{ "פומנטו" }}
                                @elseif($report->station_id == 2)
                                    {{ "ווסטון" }}
                                @else
                                    {{ "כלכלה" }}
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-form-label to-the-right">
                                סטטוס:
                                @if($report->status == 0)
                                    <span style="color: red"> פתוח (דרוש טיפול) </span>
                                @else
                                    <span style="color: limegreen"> סגור (טופל עי"
                                        {{\App\Http\Controllers\ReportController::findUser($report->closing_user_id)->first_name}}
                                        {{\App\Http\Controllers\ReportController::findUser($report->closing_user_id)->last_name}})
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-form-label to-the-right">
                                דווח על ידי:
                                <span class="blue">
            {{\App\Http\Controllers\ReportController::findUser($report->opening_user_id)->first_name}}
                                    {{\App\Http\Controllers\ReportController::findUser($report->opening_user_id)->last_name}}
            </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-form-label to-the-right">
                                מועד:
                                <span class="blue">
            {{$report->created_at}}
            </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-form-label to-the-right">
                                סיבת הדיווח:
                                <span class="blue"> {{$report->type}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-form-label to-the-right">
                                תיאור:
                                <span class="blue">
                {{$report->desc}} </span>
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="img-responsive " href="{{env('APP_URL')}}/pictures/{{$report->picture}}" ><img src="{{env('APP_URL')}}/pictures/{{$report->picture}}" alt="report picture" width="150px" height="150px"></a>
                        </div>
                        <div>
                            {{ Form::open(['route' => ['report.close', $report->id]]) }}
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-form-label to-the-right form-group">
                                    <textarea class="form-control" rows="4" cols="25" name="comment" placeholder="הכנס תגובה/הערות לסגירת הדוח"
                                    <?php if($report->status == 1){
                                        echo 'disabled';
                                    }echo'>'.$report->comment;?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-form-label to-the-right">
                                    <input hidden name="report_id" value="{{$report->id}}">
                                    @if($report->status == 0)
                                        <button type="submit" class="btn login-btn width78" value="סגור דיווח">סגור דיווח!</button>
                                </div>
                            </div>
                            @endif
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{----}}
    {{--@include('sweet::alert')--}}
@endsection

@section('page-scripts')
    <script>
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading");},
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
@endsection
