<html dir="rtl">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        table tr{
            border-style: solid;
        }
        td ,th{
            border-style: solid;
            border-width: thin;
            border-color: grey;
        }
    </style>
</head>
<body>

<h1>כל הדיווחים הפתוחים</h1>
<?php
$reports = \App\Http\Controllers\ReportController::getAllOpenReports() ?>
<table>
    <tr>
        <th>מספר</th>
        <th>סוג</th>
        <th>תיאור</th>
        <th>מועד דיווח</th>
        <th>תמונה</th>
    </tr>
    @foreach($reports as $report)
        <tr>
    <td>
        {{$report->id}}
    </td>
    <td>
        {{$report->type}}
    </td>
    <td>
        {{$report->desc}}
    </td>
    <td>
        {{$report->created_at}}
    </td>
    <td>
        <img src="../../public/pictures/{{$report->picture}}" alt="report picture" width="100px" height="100px">
    </td>
        </tr>
    @endforeach
</table>
</body>
</html>
