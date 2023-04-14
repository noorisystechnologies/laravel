<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\MonthlyUsersChart;
use App\Charts\MonthlyRadarChart;
use App\Charts\MonthlyDonutChart;
use App\Charts\MonthlyRadialbarChart;
use App\Charts\MonthlyPolarAreaChart;
use App\Charts\MonthlyLineChart;
use App\Charts\MonthlyAreaChart;
use App\Charts\MonthlyBarChart;
use App\Charts\MonthlyHorizontalBarChart;
use App\Charts\MonthlyHeatMapChart;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MonthlyUsersChart $chart)
    {
       
        return view('index', ['chart' => $chart->build()]);
    }
    public function radar(MonthlyRadarChart $chart)
    {
       
        return view('radar', ['chart' => $chart->build()]);
    }
    public function donut(MonthlyDonutChart $chart)
    {
       
        return view('radar', ['chart' => $chart->build()]);
    }
    public function radial(MonthlyRadialbarChart $chart)
    {
       
        return view('radial', ['chart' => $chart->build()]);
    }
    public function polararea(MonthlyPolarAreaChart $chart)
    {
       
        return view('polararea', ['chart' => $chart->build()]);
    }
    public function line(MonthlyLineChart $chart)
    {
       
        return view('line', ['chart' => $chart->build()]);
    }
    public function area(MonthlyAreaChart $chart)
    {
       
        return view('area', ['chart' => $chart->build()]);
    }
    public function bar(MonthlyBarChart $chart)
    {
       
        return view('bar', ['chart' => $chart->build()]);
    }
    public function HorizontalBar(MonthlyHorizontalBarChart $chart)
    {
       
        return view('Horizontalbar', ['chart' => $chart->build()]);
    }
    public function HeatMap(MonthlyHeatMapChart $chart)
    {
       
        return view('HeatMap', ['chart' => $chart->build()]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
