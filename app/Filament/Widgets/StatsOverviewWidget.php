<?php

namespace App\Filament\Widgets;

use App\Models\PaymentHistory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {

        $currentMonth = now()->month;
        $previousMonth = now()->subMonth()->month;

        $newUsersThisMonth = $this->getNewUsersCount($currentMonth);
        $newUsersLastMonth = $this->getNewUsersCount($previousMonth);
        $userPercentageChange = $this->calculatePercentageChange($newUsersLastMonth, $newUsersThisMonth);

        $newJobsThisMonth = $this->getNewJobsCount($currentMonth);
        $newJobsLastMonth = $this->getNewJobsCount($previousMonth);
        $jobPercentageChange = $this->calculatePercentageChange($newJobsLastMonth, $newJobsThisMonth);

        return [
            Stat::make('Doanh thu', number_format(PaymentHistory::sum('amount')) . ' VND')
                ->description('Tổng Doanh Thu'),
            Stat::make('Người dùng mới (tháng '.now()->month.')', number_format($newUsersThisMonth))
                ->description($userPercentageChange . '% ' . ($userPercentageChange >= 0 ? 'Tăng so với tháng trước' : 'Giảm so với tháng trước'))
                ->descriptionIcon($userPercentageChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([$newUsersLastMonth, $newUsersThisMonth])
                ->color($userPercentageChange >= 0 ? 'success' : 'danger'),
            Stat::make('Công việc mới (tháng '.now()->month.')', number_format($newJobsThisMonth))
                ->description($jobPercentageChange . '% ' . ($jobPercentageChange >= 0 ? 'Tăng so với tháng trước' : 'Giảm so với tháng trước'))
                ->descriptionIcon($jobPercentageChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([$newJobsLastMonth, $newJobsThisMonth])
                ->color($jobPercentageChange >= 0 ? 'success' : 'danger'),
        ];
    }

    protected function getNewUsersCount($month)
    {
        return DB::table('users')->whereMonth('created_at', $month)->count();
    }

    protected function getNewJobsCount($month)
    {
        return DB::table('jobs')->whereMonth('created_at', $month)->count();
    }

    protected function calculatePercentageChange($previous, $current)
    {
        if ($previous == 0) {
            return ($current == 0) ? 0 : 100;
        }

        return (($current - $previous) / abs($previous)) * 100;
    }
}
