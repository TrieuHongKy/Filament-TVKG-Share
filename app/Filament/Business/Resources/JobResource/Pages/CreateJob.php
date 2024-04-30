<?php

namespace App\Filament\Business\Resources\JobResource\Pages;

use App\Filament\Business\Resources\JobResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

    protected function getRedirectUrl(): string
    {
        $recipient = auth()->user();

        $data = $this->record;

        Notification::make()
            ->title('Tin tuyển dụng mới đã được tạo bởi ' . $recipient['name'] . ' ['.$recipient['id'].']')
            ->body('Tin tuyển dụng '.strtoupper($data['name']).' - ID: '.strtoupper($data['id']).' đã được tạo thành công.')
            ->sendToDatabase(User::role(['super_admin', 'moderator', 'admin'])->get());

        return $this->getResource()::getUrl('index');
    }
}
