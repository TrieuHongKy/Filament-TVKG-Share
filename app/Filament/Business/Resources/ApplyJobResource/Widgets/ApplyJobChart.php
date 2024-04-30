<?php

namespace App\Filament\Business\Resources\ApplyJobResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class ApplyJobChart extends ChartWidget
{
    public function __construct()
    {
        static::$heading = 'Số lượng hồ sơ ứng tuyển trong năm ' . Date::now()->year;
    }

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;

        $currentUser = auth()->user();

        if ($currentUser) {
            $currentUserId = $currentUser['id'];

            $applyJobCount = \DB::table('apply_jobs')
                ->join('jobs', 'apply_jobs.job_id', '=', 'jobs.id')
                ->join('companies', 'jobs.company_id', '=', 'companies.id')
                ->selectRaw('MONTH(apply_jobs.created_at) as month, COUNT(*) as count')
                ->whereYear('apply_jobs.created_at', $currentYear)
                ->where('companies.user_id', '=', $currentUserId)
                ->groupBy('month')
                ->pluck('count', 'month');

            $labels = [];
            $jobCount = [];
            for ($month = 1; $month <= 12; $month++) {
                $labels[] = Carbon::create()->month($month)->locale('vi_VN')->monthName;
                $jobCount[] = $applyJobCount[$month] ?? 0;
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Số Lượng Ứng Viên ' . $currentYear,
                        'data' => $jobCount,
                        'borderColor' => '#27d4f1',
                        'fill' => 'start',
                    ],
                ],
                'labels' => $labels,
            ];
        }

        return [
            'datasets' => [],
            'labels' => [],
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}
