<?php

namespace App\Filament\Business\Resources\UserResource\Pages;

use App\Filament\Business\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function authorizeAccess(): void
    {
        static::authorizeResourceAccess();

        $recordUserId = $this->getRecord()->getAttribute('id');

        if (Auth::id() != $recordUserId) {
            abort(403, 'Unauthorized action.');
        }

        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }
}
