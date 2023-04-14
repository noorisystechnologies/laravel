<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyRadialbarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\RadialChart
    {
        return $this->chart->radialChart()
            ->setTitle('Passing effectiveness.')
            ->setSubtitle('Barcelona city vs Madrid sports.')
            ->setDataset([\App\Models\User::where('id', '<=', 80)->count(),
            \App\Models\User::where('id', '>', 80)->count()])
            ->setLabels(['Blocked Developer', 'Active Developer'])
            ->setColors(['#D32F2F', '#03A9F4']);
    }
}
