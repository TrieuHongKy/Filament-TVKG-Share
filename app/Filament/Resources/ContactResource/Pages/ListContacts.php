<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

public function getTabs(): array
{
    return [
        'Chưa phản hồi'=>ListRecords\Tab::make()->query(fn ($query)=>$query->where('status','pending')),
        'Đã phản hồi'=>ListRecords\Tab::make()->query(fn ($query)=>$query->where('status','success'))
    ];
}
}
