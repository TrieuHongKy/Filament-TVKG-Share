<?php

namespace App\Filament\Business\Resources\JobResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class JobChart extends ChartWidget
{
    public function __construct()
    {
        static::$heading = 'Số lượng công việc trong năm ' . Date::now()->year;
    }

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;

        $currentUser = auth()->user();

        if ($currentUser) {
            $currentUserId = $currentUser['id'];

            $currentCompanyId = \DB::table('companies')
                ->where('user_id', $currentUserId)
                ->value('id');

            $jobCount = \DB::table('jobs')
                ->where('company_id', $currentCompanyId)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $currentYear)
                ->groupBy('month')
                ->pluck('count', 'month');

            $labels = [];
            $jobData = [];
            for ($month = 1; $month <= 12; $month++) {
                $labels[] = Carbon::create()->month($month)->locale('vi_VN')->monthName;
                $jobData[] = $jobCount[$month] ?? 0;
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Số Lượng Công Việc ' . $currentYear,
                        'data' => $jobData,
                        'borderColor' => '#27d4f1',
                        'fill' => 'start',
                    ],
                ],
                'labels' => $labels,
            ];
        }

        return [
            'datasets' => [],
            'labels' => []
        ];
    }
    protected function getType(): string
    {
        return 'line';
    }
}
