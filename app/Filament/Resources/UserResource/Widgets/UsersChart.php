<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Enums\UserType;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class UsersChart extends ChartWidget
{
    public function __construct()
    {
        static::$heading = 'Số lượng người dùng trong năm ' . Date::now()->year;
    }

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;

        $userCandidateCounts = \DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->where('user_type', '=', UserType::Candidate)
            ->groupBy('month')
            ->pluck('count', 'month');


        $userCompanyCounts = \DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->where('user_type', '=', UserType::Company)
            ->groupBy('month')
            ->pluck('count', 'month');

        $userCounts = \DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month');

        $labels = [];
        $userData = [];
        $candidateData = [];
        $companyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $labels[] = Carbon::create()->month($month)->locale('vi_VN')->monthName;
            $candidateData[] = $userCandidateCounts[$month] ?? 0;
            $companyData[] = $userCompanyCounts[$month] ?? 0;
            $userData[] = $userCounts[$month] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Số Lượng Ứng Viên 2023',
                    'data' => $candidateData,
                    'borderColor' => '#27d4f1',
                    'fill' => 'start',
                ],
                [
                    'label' => 'Số Lượng Công Ty 2023',
                    'data' => $companyData,
                    'fill' => 'start',
                ],
                [
                    'label' => 'Số Lượng Người Dùng 2023',
                    'data' => $userData,
                    'borderColor' => '#c33919',
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
