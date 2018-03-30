<html dir="rtl">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <h1>באיזו עמדה תרצה להשתבץ?</h1>
    <a href="{{ action("StationShiftController@edit", "1") }}" class="btn btn-info" role="button">פומנטו - בניין 1</a>
    <a href="{{ action("StationShiftController@edit", "2") }}" class="btn btn-info" role="button">ווסטון - בניין 2</a>
    <a href="{{ action("StationShiftController@edit", "3") }}" class="btn btn-info" role="button">כלכלה - בניין 3</a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    @include('sweet::alert')
</body>
</html>