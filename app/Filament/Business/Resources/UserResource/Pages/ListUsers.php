<?php

namespace App\Filament\Business\Resources\UserResource\Pages;

use App\Filament\Business\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
