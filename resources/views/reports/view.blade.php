@extends('layouts.master')
<link href="{!! asset('css/view.css') !!}" media="all" rel="stylesheet" type="text/css" />

@section('content')
        <h1 class="service-description text-center"><b> דיווח מספר {{ $report->id }}: </b></h1>
    <div class="text-center">
        <h4><u>בניין:</u>
            <span class="blue">
            @if($report->station_id == 1)
                    {{ "פומנטו" }}
                @elseif($report->station_id == 2)
                    {{ "ווסטון" }}
                @else
                    {{ "כלכלה" }}
                @endif
            </span>
        </h4>
        <h4>
            <u>סטטוס:</u>
            @if($report->status == 0)
                <span style="color: red"> פתוח (דרוש טיפול) </span>
            @else
                <span style="color: limegreen"> סגור (טופל עי"
                    {{\App\Http\Controllers\ReportController::findUser($report->closing_user_id)->first_name}}
                    {{\App\Http\Controllers\ReportController::findUser($report->closing_user_id)->last_name}})
                </span>
            @endif
        </h4>
        <h4>
            <u>דווח על ידי </u>
            <span class="blue">
            {{\App\Http\Controllers\ReportController::findUser($report->opening_user_id)->first_name}}
                {{\App\Http\Controllers\ReportController::findUser($report->opening_user_id)->last_name}}
            </span>
        </h4>
        <u>תאריך:</u>
        <span class="blue">
            {{$report->created_at}}
            </span>
        <h4></h4>
        <h4>
            <u>סיבת הדיווח:</u>
            <span class="blue"> {{$report->type}}</span>
        </h4>
        <h4>
            <u>תיאור:</u>
            <span class="blue">
                {{$report->desc}} </span>
        </h4>
        <a href="{{env('APP_URL')}}/pictures/{{$report->picture}}" ><img src="{{env('APP_URL')}}/pictures/{{$report->picture}}" alt="report picture" width="300px" height="300px"></a>
        <br><br>
        <div>
            {{ Form::open(['route' => ['report.close', $report->id]]) }}
            @csrf
            <h4><u>תגובת סוגר הדוח:</u></h4>
            <textarea rows="4" cols="35" name="comment" placeholder="הכנס תגובה/הערות"
            <?php if($report->status == 1){
                echo 'disabled';
            }echo'>'.$report->comment;?></textarea>
            <br>
            <input hidden name="report_id" value="{{$report->id}}">
            @if($report->status == 0)
            <div class="container">
                <button type="submit" class="btn login-btn width78" value="סגור דיווח">סגור דיווח!</button>
            </div>
            @endif
            {{ Form::close() }}
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
