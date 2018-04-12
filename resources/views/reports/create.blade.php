<!DOCTYPE html>
<html dir="rtl">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <h1>דווח על בעיה בעמדה</h1>

    @if(session('message'))
        <div>{{ session('message') }}</div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST">
        @csrf

        <div>
            <label>סוג</label><br>
            <select name="type">
                <option value="חסר משהו">חסר משהו</option>
                <option value="יש תקלה">יש תקלה</option>
                <option value="לא נקי">לא נקי</option>
                <option value="אחר">אחר</option>
            </select>
        </div>

        <br>

        <div>
            <label>עמדה</label><br>
            <select name="station">
                <option value="1">פומנטו</option>
                <option value="2">ווסטון</option>
                <option value="3">כלכלה</option>
            </select>
        </div>

        <br>

        <div>
            <label>פרטים נוספים</label><br>
            <textarea rows="4" cols="50" name="message" placeholder="נא לשמור על שפה תקינה, עד 50 תווים"></textarea><br>
            <span id="characters">0</span><span>/50</span>
        </div>
        <br>
        <div>
            <input type="submit" value="דווח!">
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type='text/javascript'>
        $("textarea").keyup(function(){
            $("#characters").text($(this).val().length);
        });
    </script>
    @include('sweet::alert')
</html>