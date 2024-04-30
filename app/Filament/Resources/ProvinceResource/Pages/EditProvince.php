<?php

namespace App\Filament\Resources\ProvinceResource\Pages;

use App\Filament\Resources\ProvinceResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditProvince extends EditRecord
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $recipient = auth()->user();

        $data = $this->record;

        Notification::make()
            ->title('Cấp tỉnh đã được sửa bởi ' . $recipient['name'] . ' ['.$recipient['id'].']')
            ->body('Cấp tỉnh '.strtoupper($data['name']).' - ID: '.strtoupper($data['id']).' đã được sửa thành công.')
            ->sendToDatabase(User::role(['super_admin', 'moderator', 'admin'])->get());

        return $this->getResource()::getUrl('index');
    }
}
