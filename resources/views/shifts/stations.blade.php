@extends('layouts.master')

@section('content')
        <h1 class="service-description">המשמרות שלך</h1>
        @if(\App\Http\Controllers\StationShiftController::isUserHasShifts())
            <h4>עמדה:
                @foreach (Auth::user()->shifts as $shift)
                    @if($shift->station_id == 1)
                        {{ "פומנטו" }}
                    @elseif($shift->station_id == 2)
                        {{ "ווסטון" }}
                    @else
                        {{ "כלכלה" }}
                    @endif
                    @break
                @endforeach
            </h4>

            <hr>

            <h5>משמרות:
            @foreach (Auth::user()->shifts as $shift)
                <ul>
                    <li>
                        <?php $day = $shift->day ?>
                        @if($day == 1)
                            {{ "ראשון" }}
                        @elseif($day == 2)
                            {{ "שני" }}
                        @elseif($day == 3)
                            {{ "שלישי" }}
                        @elseif($day == 4)
                            {{ "רביעי" }}
                        @else
                            {{ "חמישי" }}
                        @endif
                        {{ $shift->start_shift }}:00-{{ $shift->end_shift }}:00
                    </li>
                </ul>
            @endforeach
            @else
                <h4>אין משמרות, לא חבל על הנקודות?</h4>
            @endif
        </h5>
        <h1 class="service-description">עדכן משמרות</h1>

        <div class="container">
            <div class="row">
                <div class="col-4">
                    <a href="{{ action("StationShiftController@edit", "1") }}" class="btn btn-info btn-block" role="button"> פומנטו - בניין 1</a>
                </div>
                <div class="col-4">
                    <a href="{{ action("StationShiftController@edit", "2") }}" class="btn btn-info btn-block" role="button">ווסטון - בניין 2</a>
                </div>
                <div class="col-4">
                    <a href="{{ action("StationShiftController@edit", "3") }}" class="btn btn-info btn-block" role="button">כלכלה - בניין 3</a>
                </div>
            </div>
        </div>
@endsection


