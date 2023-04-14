<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyPolarAreaChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PolarAreaChart
    {
        return $this->chart
            ->polarAreaChart()
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->setDataset([
                \App\Models\User::where('id', '<=', 80)->count(),
                \App\Models\User::where('id', '>', 80)->count()
            ])
            ->setLabels(['Active Developer', 'Blocked Developer']);
    }
}
