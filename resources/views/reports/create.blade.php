@extends('layouts.master')

@section('page-style')
    <link href="{{env('APP_URL')}}/css/create.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <h2 class="service-description text-center">דווח על בעיה בעמדה</h2>
    <hr>
    @if(session('message'))
        <div>{{ session('message') }}</div>
    @endif
    {{ Form::open(['route' => ['reports.store'],'files' => true]) }}
        @csrf

        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">עמדה</h4></label>
            <select  class="form-control col-9" id="check" name="station">
                <option value="1">פומנטו</option>
                <option value="2">ווסטון</option>
                <option value="3">כלכלה</option>
            </select>
            @if ($errors->has('station'))
                <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>נראה שמידע מסויים שונה לא כראוי, אנא נסו שוב</strong>
                </span>
            @endif
        </div>
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">סוג</h4></label>
            <select class="form-control col-9" name="type">
                <option value="חסר משהו">חסר משהו</option>
                <option value="יש תקלה">יש תקלה</option>
                <option value="לא נקי">לא נקי</option>
                <option value="אחר">אחר</option>
            </select>
            @if ($errors->has('type'))
                <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>נראה שמידע מסויים שונה לא כראוי, אנא נסו שוב</strong>
                </span>
            @endif
        </div>
        <br><br>
        <div class="row">
            <label class="to-the-right col-3"><h4 class="service-description">פרטים נוספים</h4></label>
            <textarea rows="4" cols="30" id="message" type="text" class="col-9 form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" value="{{ old('message') }}" required placeholder="פרטו בקצרה על הליקוי, עד 50 תווים"></textarea>
            @if ($errors->has('message'))
                <span class="invalid-feedback" style="display: block !important; text-align: center">
                    <strong>אנא הקלידו מעט פרטים כדי שהמתנדבים שלנו יוכלו לעזור :)</strong>
                </span>
            @endif
        </div>
    <div class="text-center">
        <span id="characters">0</span><span>/50</span>
    </div>
<br>
    <div class="row">
        <h4 class="service-description to-the-right col-3">הוסף תמונה</h4>
        <div class="input-group mb-3 col-9">
            <div class="custom-file">
                    <input id="inputGroupFile01" type="file" class="custom-file-input form-control{{ $errors->has('picture') ? ' is-invalid' : '' }}" name="picture" value="{{ old('picture') }}" autofocus onchange="$('#upload-file-info').replaceWith('<b>!File selected</b>');">>
                <label class="custom-file-label text-left" for="inputGroupFile01"><span id="upload-file-info"></span></label>
            </div>
            @if ($errors->has('picture'))
                <span class="invalid-feedback" style="display: block !important;">
                    <strong>{{ $errors->first('picture') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <br>
        <div class="container">
            <div class="text-center">
                {{--<input type="submit" value="דווח!">--}}
                <button type="submit" class="btn login-btn" value="דווח!">דווח!</button>
            </div>
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