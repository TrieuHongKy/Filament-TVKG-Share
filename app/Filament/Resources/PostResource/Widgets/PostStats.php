<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use Carbon\Traits\Date;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class PostStats extends BaseWidget
{
    protected function getTablePage(): Post
    {
        return new Post();
    }

    protected function getStats(): array
    {
        $tablePage = $this->getTablePage();

        return [
            Stat::make('Tổng Số Bài Viết ', number_format($tablePage->get()->count())),
            Stat::make('Tổng Số Đã Công Bố', $tablePage->where('published_at', '<=', now())->count())
        ];
    }
}
