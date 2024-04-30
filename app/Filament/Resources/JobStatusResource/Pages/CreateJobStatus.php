<?php

namespace App\Filament\Resources\JobStatusResource\Pages;

use App\Filament\Resources\JobStatusResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateJobStatus extends CreateRecord
{
    protected static string $resource = JobStatusResource::class;

    protected function getRedirectUrl(): string
    {
        $recipient = auth()->user();

        $data = $this->record;

        Notification::make()
            ->title('Trạng thái công việc mới đã được tạo bởi ' . $recipient['name'] . ' ['.$recipient['id'].']')
            ->body('Trạng thái công việc '.strtoupper($data['name']).' - ID: '.strtoupper($data['id']).' đã được tạo thành công.')
            ->sendToDatabase(User::role(['super_admin', 'moderator', 'admin'])->get());

        return $this->getResource()::getUrl('index');
    }
}
