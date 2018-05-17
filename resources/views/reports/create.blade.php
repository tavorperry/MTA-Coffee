@extends('layouts.master')

@section('page-style')
    <link href="{!! asset('css/create.css') !!}" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <h1 class="service-description text-center">דווח על בעיה בעמדה</h1>
    <hr>
    @if(session('message'))
        <div>{{ session('message') }}</div>
    @endif
    {{ Form::open(['route' => ['reports.store'],'files' => true]) }}
        @csrf

        <div class=" text-center">
            <label><h3 class="service-description">עמדה</h3></label><br>
            <select id="check" name="station">
                <option value="1">פומנטו</option>
                <option value="2">ווסטון</option>
                <option value="3">כלכלה</option>
            </select>
        </div>

        <br>

        <div class=" text-center">
            <label><h3 class="service-description">סוג</h3></label><br>

            <select name="type">
                <option value="חסר משהו">חסר משהו</option>
                <option value="יש תקלה">יש תקלה</option>
                <option value="לא נקי">לא נקי</option>
                <option value="אחר">אחר</option>
            </select>

        </div>


        <br>

        <div class=" text-center">
            <label><h3 class="service-description">פרטים נוספים</h3></label><br>
            <textarea rows="4" cols="30" name="message" placeholder="נא לשמור על שפה תקינה, עד 50 תווים"></textarea><br>
            <span id="characters">0</span><span>/50</span>
        </div>

        <br>

        <div class=" text-center">
            <label><h3 class="service-description">הוסף תמונה</h3></label><br>
            <input type="file" name="picture">
        </div>
        <br>
        <div class=" text-center">
            {{--<input type="submit" value="דווח!">--}}
            <button type="submit" class="btn login-btn" value="דווח!">דווח!</button>
        </div>
    {!! Form::close() !!}

@endsection

@section('page-scripts')
    <script type='text/javascript'>
        $("textarea").keyup(function(){
            $("#characters").text($(this).val().length);
        });
    </script>
@endsection