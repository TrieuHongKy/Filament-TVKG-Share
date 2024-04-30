<?php

namespace App\Filament\Business\Resources\ApplyJobResource\Pages;

use App\Filament\Business\Resources\ApplyJobResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListApplyJobs extends ListRecords
{

    protected static string $resource = ApplyJobResource::class;

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        $userId = Auth::id();

        $query->whereHas('job', function ($jobQuery) use ($userId) {
            $jobQuery->whereHas('company', function ($companyQuery) use ($userId) {
                $companyQuery->where('user_id', $userId);
            });
        })->where('status','pending');


        return $query;
    }
}
