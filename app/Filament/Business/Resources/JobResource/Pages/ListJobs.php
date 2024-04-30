<?php

namespace App\Filament\Business\Resources\JobResource\Pages;

use App\Filament\Business\Resources\JobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListJobs extends ListRecords
{
    protected static string $resource = JobResource::class;


    protected function getTableQuery(): Builder
    {
        $query = static::getResource()::getEloquentQuery();

        $query->whereHas('company', function ($companyQuery) {
            $userId = Auth::id();

            $companyQuery->where('user_id', $userId);
        });

        $tabs = $this->getTabs();

        if (
            filled($this->activeTab) &&
            array_key_exists($this->activeTab, $tabs)
        ) {
            $tabs[$this->activeTab]->modifyQuery($query);
        }

        return $query;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
