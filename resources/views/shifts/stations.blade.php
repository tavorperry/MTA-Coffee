@extends('layouts.master')

@section('content')
        <h1 class="service-description">המשמרות שלך</h1>
        @if(\App\Http\Controllers\StationShiftController::isUserHasShifts())
            <h2>עמדה:
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
            </h2>

            <hr>

            <h2>משמרות:
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
                        {{ $shift->start_shift }}:00-
                        {{ $shift->end_shift }}:00
                    </li>
                </ul>
            @endforeach
            @else
                <h4>אין משמרות, לא חבל על הנקודות?</h4>
            @endif
        </h2>

        <h1 class="service-description">עדכן משמרות</h1>
        <a href="{{ action("StationShiftController@edit", "1") }}" class="btn btn-info" role="button">פומנטו - בניין 1</a>
        <a href="{{ action("StationShiftController@edit", "2") }}" class="btn btn-info" role="button">ווסטון - בניין 2</a>
        <a href="{{ action("StationShiftController@edit", "3") }}" class="btn btn-info" role="button">כלכלה - בניין 3</a>

@endsection

