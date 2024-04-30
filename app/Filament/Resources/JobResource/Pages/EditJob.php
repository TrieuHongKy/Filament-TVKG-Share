<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditJob extends EditRecord
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function getRedirectUrl(): string
    {
        $recipient = auth()->user();

        $data = $this->record;

        Notification::make()
            ->title('Tin tuyển dụng đã được sửa bởi ' . $recipient['name'] . ' ['.$recipient['id'].']')
            ->body('Tin tuyển dụng '.strtoupper($data['name']).' - ID: '.strtoupper($data['id']).' đã được sửa thành công.')
            ->sendToDatabase(User::role(['super_admin', 'moderator', 'admin'])->get());

        return $this->getResource()::getUrl('index');
    }
}
