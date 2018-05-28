@extends('layouts.master')

@section('page-style')
    <link href="{!! asset('css/view_all_open.css') !!}" media="all" rel="stylesheet" type="text/css" />
@endsection
<head>    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        @media only screen and (max-width: 600px) {
            .clear_in_mobile{
                display: none;
            }
        }
    </style>

@section('content')
  <div  id="displayChange">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <div class="text-center">
    <h1 class="service-description">כל הדיווחים</h1>
        <hr>
        <h2 class="service-description">בחר סינון</h2>
    <div class="btn-group btn-group-toggle width100"  data-toggle="buttons">
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

    <br>

    <?php $reports = \App\Http\Controllers\ReportController::getAllReports() ?>
        <div class="table-responsive">
            <table class="text-center table table-striped">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">עמדה</th>
                    <th scope="col" class="clear_in_mobile">סוג</th>
                    <th scope="col" class="clear_in_mobile">תיאור</th>
                    <th scope="col" class="clear_in_mobile">מועד דיווח</th>
                    <th scope="col" class="clear_in_mobile">תמונה</th>
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
                        <td class="clear_in_mobile">
                            {{$report->type}}
                        </td>
                        <td class="clear_in_mobile">
                            {{$report->desc}}
                        </td>
                        <td class="clear_in_mobile">
                            {{$report->created_at}}
                        </td>
                        <td class="clear_in_mobile">
                            <img src="../../pictures/{{$report->picture}}" alt="report picture" width="70px" height="70px">
                        </td>
                        <td>
                            <a href="/reports/view/{{$report->id}}"><span id="status_id_{{$report->id}}"> {{$report->status}}</span> </a>
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

<script>
    $( document ).ready(function() {
        $("#display-side-menu").css("padding-top", "15px");
    });
</script>

@endsection
