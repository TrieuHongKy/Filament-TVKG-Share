<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoryStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListCategories::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Tổng Danh Mục', number_format($this->getPageTableQuery()->count())),
            Stat::make('Danh Mục Khả Dụng', number_format($this->getPageTableQuery()->where('status', '=', '1')->count())),
            Stat::make('Danh Mục Không Khả Dụng', number_format($this->getPageTableQuery()->where('status', '=', '0')->count())),

        ];
    }
}
