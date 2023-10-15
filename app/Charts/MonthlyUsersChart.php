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

    public function build(): array
    {
        // return $this->chart->pieChart()
        //     ->setTitle('Top 3 scorers of the team.')
        //     ->setSubtitle('Season 2021.')
        //     ->addData([40, 50, 30])
        //     ->setLabels(['Player 7', 'Player 10', 'Player 9'])
        //     ->toVue();
        return $this->chart->areaChart()
            ->setTitle('Monthly Users')
            ->addArea('Active users', [10, 30, 25])
            ->addArea('Inactive users', [5, 15, 35])
            ->setColors(['#ffc63b', '#ff6384'])
            ->toVue();
    }
}
