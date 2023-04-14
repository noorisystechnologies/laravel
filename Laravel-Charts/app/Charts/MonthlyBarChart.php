<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyBarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {

            return $this->chart->barChart()
                        ->setTitle('San Francisco vs Boston.')
                        ->setSubtitle('Wins during season 2021.')
                        ->addData('Active Developer', [\App\Models\User::where('id', '>', 10)->count(), \App\Models\User::where('id', '>', 20)->count(), \App\Models\User::where('id', '>', 30)->count(), \App\Models\User::where('id', '>', 40)->count(), \App\Models\User::where('id', '>', 50)->count(), \App\Models\User::where('id', '>', 60)->count()])
                        ->addData('Passive Developer', [\App\Models\User::where('id', '>', 60)->count(), \App\Models\User::where('id', '>', 50)->count(), \App\Models\User::where('id', '>', 40)->count(), \App\Models\User::where('id', '>', 30)->count(), \App\Models\User::where('id', '>', 20)->count(), \App\Models\User::where('id', '>', 10)->count()])
                        ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
    }
}
