<?php

namespace App\Filament\Resources\WardResource\Pages;

use App\Filament\Resources\WardResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateWard extends CreateRecord
{
    protected static string $resource = WardResource::class;

    protected function getRedirectUrl(): string
    {
        $recipient = auth()->user();

        $data = $this->record;

        Notification::make()
            ->title('Cấp xã mới đã được tạo bởi ' . $recipient['name'] . ' ['.$recipient['id'].']')
            ->body('Cấp xã '.strtoupper($data['name']).' - ID: '.strtoupper($data['id']).' đã được tạo thành công.')
            ->sendToDatabase(User::role(['super_admin', 'moderator', 'admin'])->get());

        return $this->getResource()::getUrl('index');
    }
}
