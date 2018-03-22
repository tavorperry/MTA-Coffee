<html dir="rtl">
<head>
    <title></title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>המשמרות שלך</h1>
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
    </h2>
</body>
</html>