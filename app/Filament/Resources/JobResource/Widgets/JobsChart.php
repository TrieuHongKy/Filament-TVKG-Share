<?php

namespace App\Filament\Resources\JobResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class JobsChart extends ChartWidget
{
    public function __construct()
    {
        static::$heading = 'Số lượng công việc trong năm ' . Date::now()->year;
    }

    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;

        $jobCounts = \DB::table('jobs')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month');

        $labels = [];
        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $labels[] = Carbon::create()->month($month)->locale('vi_VN')->monthName;
            $data[] = $jobCounts[$month] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Số Lượng Công Việc '. $currentYear,
                    'data' => $data,
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
