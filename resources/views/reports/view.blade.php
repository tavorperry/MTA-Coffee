<html dir="rtl">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<h1><b><u> דיווח מספר {{ $report->id }}:</b> </u></h1>
<h4>בניין
    @if($report->station_id == 1)
        {{ "פומנטו" }}
    @elseif($report->station_id == 2)
        {{ "ווסטון" }}
    @else
        {{ "כלכלה" }}
    @endif
</h4>
<h4> <u>דווח על ידי </u>
    {{$report->user->first_name}} {{$report->user->last_name}}
    ב
    {{$report->created_at}}
</h4>
<br>
<h4><u>{{$report->type}}:</u></h4>
<h4> {{$report->desc}} </h4>
<a href="../../../pictures/{{$report->picture}}"><img src="../../../pictures/{{$report->picture}}" alt="report picture" width="300px" height="300px"></a>
{{--After Uploading to PRD we need to change the links to {{public_path('pictures').'/'.$report->picture}}--}}

<br><br>
<div>
    {{!! Form::open(['route' => ['reports.close']]); !!}}

    <textarea rows="4" cols="50" name="message" placeholder="הכנס תגובה/הערות"></textarea><br>
    <span id="characters">0</span><span>/50</span>
    <input type="submit" value="סגור דיווח">
    {{ Form::close() }}
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
@include('sweet::alert')
</body>
</html>