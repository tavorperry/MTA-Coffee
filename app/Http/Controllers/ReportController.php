<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PointsController;


class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // GET /reports/create
    public function create()
    {
        return view('reports.create');
    }

    // POST /reports
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);


        $report = new Report();
        $report->user_id = auth()->id();
        $report->station_id = $request->get('station');
        $report->type = $request->get('type');
        $report->desc = $request->get('message');

        $isReported = $report->save();


        if ($isReported) {
            PointsController::AddPoints(20,$report->user_id);
            $request->session()->flash('message', 'Created Successfully');
        } else {
            $request->session()->flash('message', 'There is an error!');
        }

        return redirect()->route('reports.create');
    }
}
