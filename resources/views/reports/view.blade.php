<html dir="rtl">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            .blue {
                color: blue;
            }
        </style>
    </head>
<body>
<h1><b><u> דיווח מספר {{ $report->id }}: </u></b></h1>
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
    ב-
    <span class="blue">
    {{$report->created_at}}
    </span>
</h4>
<br>
<h4>
    <u>סיבת הדיווח:</u>
    <span class="blue"> {{$report->type}}</span>
</h4>
<h4>
    <u>תיאור:</u>
    <span class="blue">
        {{$report->desc}} </span>
</h4>
<a href="../../../public/pictures/{{$report->picture}}"><img src="../../../public/pictures/{{$report->picture}}" alt="report picture" width="300px" height="300px"></a>
{{--After Uploading to PRD we need to change the links to {{public_path('pictures').'/'.$report->picture}}--}}
<br><br>
<div>
    {{ Form::open(['route' => ['report.close', $report->id]]) }}
    @csrf
    <h4><u>תגובת סוגר הדוח:</u></h4>
    <textarea rows="4" cols="50" name="comment" placeholder="הכנס תגובה/הערות"
    <?php if($report->status == 1){
        echo 'disabled';
    }echo'>'.$report->comment;?></textarea>
    <br>
    <input hidden name="report_id" value="{{$report->id}}">
    @if($report->status == 0)
    <input type="submit" value="סגור דיווח">
    @endif
    {{ Form::close() }}
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
@include('sweet::alert')
</body>
</html>
