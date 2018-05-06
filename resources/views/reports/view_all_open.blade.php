<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Sweet Alerts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>



    <style>
        table tr{
            border-style: solid;
        }
        td ,th{
            border-style: solid;
            border-width: thin;
            border-color: grey;
        }
        .width100{
            width: 100%;
        }
        .width33{
            width: 33.3333333333%;
        }
        .width25{
            width: 25%;
        }
        input{
            position:absolute;top:0;right:0;
        }
    </style>

</head>
<div class="text-center">
<h1>כל הדיווחים</h1>
    <h2>בחר סינון</h2>
<div class="btn-group btn-group-toggle width100" data-toggle="buttons">
    <label class="btn btn-primary width33 active">
        <input type="radio" id="" name="status" autocomplete="off" checked> הכל
    </label>
    <label class="btn btn-primary width33">
        <input type="radio" id="פתוח" name="status" autocomplete="off"> פתוח
    </label>
    <label class="btn btn-primary width33">
        <input type="radio" id="סגור" name="status" autocomplete="off"> סגור
    </label>
</div>
    <br>
<div class="btn-group btn-group-toggle width100" data-toggle="buttons">
    <label class="btn btn-primary col width25 active">
        <input type="radio" id="" name="station" autocomplete="off" checked> הכל
    </label>
    <label class="btn btn-primary col width25">
        <input type="radio" id="פומנטו" name="station" autocomplete="off" > פומנטו
    </label>
    <label class="btn btn-primary col width25">
        <input type="radio" id="ווסטון" name="station" autocomplete="off"> ווסטון
    </label>
    <label class="btn btn-primary col width25">
        <input type="radio" id="כלכלה" name="station" autocomplete="off"> כלכלה
    </label>
</div>
</div>

<?php $reports = \App\Http\Controllers\ReportController::getAllReports() ?>
<table class="text-center table table-striped">
    <tr>
        <th scope="col">#</th>
        <th scope="col">עמדה</th>
        <th scope="col">סוג</th>
        <th scope="col">תיאור</th>
        <th scope="col">מועד דיווח</th>
        <th scope="col">תמונה</th>
        <th scope="col">סטטוס</th>
    </tr>
    @foreach($reports as $report)
        <tr>
            <td scope="row">
                {{$report->id}}
            </td>
            <td id="station_id_{{$report->id}}">
                {{$report->station_id}}
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
                <img src="../../pictures/{{$report->picture}}" alt="report picture" width="70px" height="70px">
            </td>
            <td id="status_id_{{$report->id}}">
                {{$report->status}}
            </td>
        </tr>
        <script>
            //Replace the station numbers with names
            var Id = ("#station_id_{{$report->id}}").toString();
            var replaced = $(Id).html().replace('1','פומנטו');
            $(Id).html(replaced);
            var replaced = $(Id).html().replace('2','ווסטון');
            $(Id).html(replaced);
            var replaced = $(Id).html().replace('3','כלכלה');
            $(Id).html(replaced);

            //Replace the status numbers(boolean) with text
            var status_id = ("#status_id_{{$report->id}}").toString();
            var replaced_status = $(status_id).html().replace('0','פתוח');
            $(status_id).html(replaced_status);
            var replaced_status = $(status_id).html().replace('1','סגור');
            $(status_id).html(replaced_status);

        </script>
    @endforeach
</table>
</div>
<script>
    $('input[type="radio"]').change(function () {
        var name = $('input[name="status"]:checked').prop('id') || '';
        var position = $('input[name="station"]:checked').prop('id') || '';
        $('tr').hide();
        $('tr:contains(' + name + ')').show();
        $('tr').not(':contains(' + position + ')').hide();
    });

</script>
</body>
</html>
