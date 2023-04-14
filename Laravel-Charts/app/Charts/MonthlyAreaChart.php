<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyAreaChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        return $this->chart->areaChart()
            ->setTitle('Sales during 2021.')
            ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Physical sales', [\App\Models\User::where('id', '>', 60)->count(), \App\Models\User::where('id', '>', 50)->count(), \App\Models\User::where('id', '>', 40)->count(), \App\Models\User::where('id', '>', 30)->count(), \App\Models\User::where('id', '>', 20)->count(), \App\Models\User::where('id', '>', 10)->count()])
            ->addData('Digital sales', [\App\Models\User::where('id', '>', 10)->count(), \App\Models\User::where('id', '>', 20)->count(), \App\Models\User::where('id', '>', 30)->count(), \App\Models\User::where('id', '>', 40)->count(), \App\Models\User::where('id', '>', 50)->count(), \App\Models\User::where('id', '>', 60)->count()])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
    }
}
