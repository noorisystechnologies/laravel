<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setTitle('Developers.')
            ->setSubtitle('Season 2021.')
            ->setDataset([
                \App\Models\User::where('id', '<=', 80)->count(),
                \App\Models\User::where('id', '>', 80)->count()
            ])
            ->setLabels(['Active Developer', 'Blocked Developer']);
    }
    
}
