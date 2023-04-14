<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyRadarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\RadarChart
    {
        return $this->chart->radarChart()
            ->setTitle('Individual Player Stats.')
            ->setSubtitle('Season 2021.')
            ->setDataset('Stats', [ \App\Models\User::where('id', '<=', 20)->count(),
            \App\Models\User::where('id', '>', 20)->count()])
            ->setXAxis(['Active Developer', 'Blocked Developer'])
            ->setMarkers(['#303F9F'], 7, 10);
    }
}
