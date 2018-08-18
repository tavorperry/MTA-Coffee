@extends('layouts.master')

@section('content')
    <?php if(isset($google))
        Alert::message('בשימוש במערכת אני מאשר שקראתי והסכמתי לתנאי השימוש והפרטיות במערכת')->persistent("מאשר");
        ?>
    <div class="container">
        <div class="row justify-content-center position-relative" style="bottom:30px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center"><b>אחרי הכל, עמדות הקפה מתקיימות בזכות המתנדבים </b></div>
                    <div class="card-body container">
                        <div class="row">
                        <div class="col-sm-12 width100">
                            <a href="{{route("select.building")}}" class="btn btn-success" role="button" style="width: 100%">אני רוצה לעזור כשאוכל ולקבל התראות !</a>
                        </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col-sm-12 width100">
                            <a href="{{route('home')}}" class="btn btn-danger" role="button" style="width: 100%">לא מעוניין/ת להתנדב</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection