@extends('layouts.master')

@section('content')
 <div class="container">
  <div class="row justify-content-center position-relative" style="bottom:30px">
    <div class="col-md-8">
     <div class="card">
      <div class="card-header text-center"><b>באיזה בניין אני נמצא בדרך כלל? </b></div>
       <div class="card-body container">
          <div class="col-12">
            <a href="{{ action("StationShiftController@edit", "1") }}" class="btn btn-info btn-block" role="button"> פומנטו - בניין 1</a>
          </div>
          <br>
          <div class="col-12">
           <a href="{{ action("StationShiftController@edit", "2") }}" class="btn btn-info btn-block" role="button">ווסטון - בניין 2</a>
          </div>
          <br>
          <div class="col-12">
            <a href="{{ action("StationShiftController@edit", "3") }}" class="btn btn-info btn-block" role="button">כלכלה - בניין 3</a>
          </div>
       </div>
     </div>
    </div>
  </div>
 </div>
@endsection