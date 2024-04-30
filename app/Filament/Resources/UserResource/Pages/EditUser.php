<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        $recipient = auth()->user();

        $data = $this->record;

        Notification::make()
            ->title('Người dùng đã được cập nhật bởi ' . $recipient['name'] . ' ['.$recipient['id'].']')
            ->body('Người dùng '.strtoupper($data['name']).' - ID: '.strtoupper($data['id']).' đã được cập nhật thành công.')
            ->sendToDatabase(User::role(['super_admin', 'moderator', 'admin'])->get());

        return $this->getResource()::getUrl('index');
    }
}
