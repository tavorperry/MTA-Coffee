<!DOCTYPE html>
<html dir="rtl">
<head>
    <style>
        .blue {
            color: blue;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <h1 class="service-description text-center"><b> דיווח מספר {{ $report->id }}: </b></h1>
</head>
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
        <u>מועד פתיחת הדיווח:</u>
        <span class="blue">
            {{$report->created_at}}
            </span>
        <h4></h4>
        <h4>
            <u>סיבת הדיווח:</u>
            <span class="blue"> {{$report->type}}</span>
        </h4>
            <u>תיאור:</u>
            <span class="blue">
                {{$report->desc}}
            </span>
        <h4>
                <?php
                if($report->picture != null){
                    $link= 'http://vmedu151.mtacloud.co.il/pictures/'.$report->picture;
                echo "<u> <a href=".$link."> לחץ כאן על מנת לעבור לתמונה המצורפת </u> </a>";
                }
                ?>
        </h4>
            <a href="http://vmedu151.mtacloud.co.il/reports/view/{{$report->id}}"><img src="https://www.dropbox.com/s/ytx3hj3aox0omkl/Go%20to%20report.png?raw=1" alt="לחץ כאן לעבור לדיווח "> </a>
    </div>
</body>
</html>

