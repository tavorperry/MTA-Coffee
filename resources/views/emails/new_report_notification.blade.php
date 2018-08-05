<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <style>
        .blue {
            color: blue;
        }
        *{
            text-align: right;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <h1 class="service-description"><b> דיווח מספר: {{ $report->id }} </b></h1>
</head>
<p dir="rtl">
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
<h4 dir="rtl">
    <u>סטטוס:</u>
    @if($report->status == 0)
        <span style="color: red"> פתוח - דרוש טיפול </span>
    @else
        <span style="color: limegreen"> סגור - טופל עי":

            {{\App\Http\Controllers\ReportController::findUser($report->closing_user_id)->first_name}}
            {{\App\Http\Controllers\ReportController::findUser($report->closing_user_id)->last_name}}

                </span>
    @endif
</h4>
<h4 dir="rtl">
    <u>מועד פתיחת הדיווח:</u>
    <span class="blue">
                {{$report->created_at}}
        </span>
</h4>
<h4 dir="rtl">
    <u>דווח על ידי </u>
    <span class="blue">
            {{\App\Http\Controllers\ReportController::findUser($report->opening_user_id)->first_name}}
        {{\App\Http\Controllers\ReportController::findUser($report->opening_user_id)->last_name}}
            </span>
</h4>
<h4 dir="rtl">
    <u>סיבת הדיווח:</u>
    <span class="blue"> {{$report->type}}</span>
</h4>
<h4 dir="rtl">
    <u>תיאור:</u>
    <span class="blue">
            {{$report->desc}}
        </span>
</h4>
<h4>
    <?php
    if($report->picture != null){
        $link = env('APP_URL')."/pictures/".$report->picture;
        echo "<u> <a href=".$link."> לחץ כאן על מנת לעבור לתמונה המצורפת </u> </a>";
        echo "<img src='.$link.' height='42' width='42'>";
    }
    ?>
</h4>
<a href="{{env('APP_URL')}}/reports/view/{{$report->id}}"><img src="https://www.dropbox.com/s/ytx3hj3aox0omkl/Go%20to%20report.png?raw=1" alt="לחץ כאן לעבור לדיווח "> </a>
</p>
</div>
<div>
    <!-- Email Footer : BEGIN -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
        <tr>
            <td style="padding: 40px 10px; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;">
                <br><br>
                אגודת הסטודנטים<br><span class="unstyle-auto-detected-links">רבנו ירוחם 12, תל אביב<br>03-9292929</span>
                <br><br>
                <a href="{{env('APP_URL')}}/notifications/unsubscribe/{{$user->secret_token}}"> <unsubscribe style="color: #888888; text-decoration: underline;">unsubscribe</unsubscribe> </a>
            </td>
        </tr>
    </table>
    <!-- Email Footer : END -->
</div>
</body>
</html>