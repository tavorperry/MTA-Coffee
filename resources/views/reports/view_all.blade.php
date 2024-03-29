@extends('layouts.master')

@section('page-style')
    <link href="{{env('APP_URL')}}/css/view_all_open.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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

    <?php $reports = \App\Http\Controllers\ReportController::getAllReports();
      $reports = $reports->reverse();
      ?>
        <div class="">
            <table class="text-center table table-striped" id="all_reports">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">עמדה</th>
                        <th scope="col" class="clear_in_mobile">סוג</th>
                        <th scope="col" class="clear_in_mobile">תיאור</th>
                        <th scope="col" class="clear_in_mobile">מועד דיווח</th>
                        <th scope="col" class="clear_in_mobile">תמונה</th>
                        <th scope="col">סטטוס</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr class="main-tr">
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
                            <img src="{{env('APP_URL')}}/pictures/{{$report->picture}}" alt="report picture" width="70px" height="70px">
                        </td>
                        <td>
                            <a href="{{env('APP_URL')}}/reports/view/{{$report->id}}"><span id="status_id_{{$report->id}}"> {{$report->status}}</span> </a>
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
                </tbody>
            </table>
        </div>
</div>
<script>
    $('input[type="radio"]').change(function () {
        var name = $('input[name="status"]:checked').prop('id') || '';
        var station = $('input[name="station"]:checked').prop('id') || '';
        $('.main-tr').hide();
        $('.main-tr:contains(' + name + ')').show();
        $('.main-tr').not(':contains(' + station + ')').hide();
    });

</script>

<script>
    $( document ).ready(function() {
        $("#display-side-menu").css("padding-top", "15px");
    });
</script>
{{--  I tried to add DataTables but it doesnt look good.
  I add it and comment it if we will want to use it in the future--}}
  {{--  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>--}}
  {{--<script type="text/javascript">
      $(document).ready(function() {
          $('#all_reports').DataTable( {
              "language": {
                  "processing":   "מעבד...",
                  "lengthMenu":   "הצג _MENU_ פריטים",
                  "zeroRecords":  "לא נמצאו רשומות מתאימות",
                  "emptyTable":   "לא נמצאו רשומות מתאימות",
                  "info": "_START_ עד _END_ מתוך _TOTAL_ רשומות" ,
                  "infoEmpty":    "0 עד 0 מתוך 0 רשומות",
                  "infoFiltered": "(מסונן מסך _MAX_  רשומות)",
                  "infoPostFix":  "",
                  "search":       "חפש:",
                  "url":          "",
                  "paginate": {
                      "first":    "ראשון",
                      "previous": "קודם",
                      "next":     "הבא",
                      "last":     "אחרון"
                  }
              },
              "order": [[ 0, "desc" ]],
              searchPlaceholder: "חפש דיווחים",
              "pageLength": 100,
              "lengthChange": false,
              "dom": '<lf<t>ip>'
          } );
      } );
  </script>--}}

@endsection
