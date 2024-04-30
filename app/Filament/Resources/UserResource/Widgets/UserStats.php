<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Enums\UserType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends BaseWidget
{

    protected function getTablePage(): User
    {
        return new User();
    }
    protected function getStats(): array
    {
        $tablePage = $this->getTablePage();
        return [
            Stat::make('Tổng Số Thành Viên', number_format($tablePage->count())),
            Stat::make('Tổng Số Ứng Viên', number_format($tablePage->where('user_type','=',UserType::Candidate)->count())),
            Stat::make('Tổng Số Công Ty', number_format($tablePage->where('user_type','=',UserType::Company)->count())),
        ];
    }
}
