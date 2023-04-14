<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyHeatMapChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HeatMapChart
    {
        return $this->chart->heatMapChart()
            ->setTitle('Basic radar chart')
            ->addData('Active Developer', [\App\Models\User::where('id', '>', 10)->count(), \App\Models\User::where('id', '>', 20)->count(), \App\Models\User::where('id', '>', 30)->count(), \App\Models\User::where('id', '>', 40)->count(), \App\Models\User::where('id', '>', 50)->count(), \App\Models\User::where('id', '>', 60)->count()])
            ->addHeat('Passive Developer', [\App\Models\User::where('id', '>', 60)->count(), \App\Models\User::where('id', '>', 50)->count(), \App\Models\User::where('id', '>', 40)->count(), \App\Models\User::where('id', '>', 30)->count(), \App\Models\User::where('id', '>', 20)->count(), \App\Models\User::where('id', '>', 10)->count()])
            ->setMarkers(['#FFA41B', '#4F46E5'], 7, 10)
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
    }
}
