<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Enums\ApplyJobStatus;
use App\Filament\Resources\ContactResource;
use App\Mail\ContactMail;
use App\Models\Contact;
use Filament\Actions;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;
    protected function getHeaderActions(): array
    {
        return [

        Actions\Action::make('Trả Lời')
            ->icon('heroicon-o-envelope')
            ->form([
                Textarea::make('content')
                    ->label('Nội dung'),
            ])
            ->action(function (array $data,$record): void {
                Contact::where('id',$record['id'])->update(['status'=> ApplyJobStatus::Success,'reply'=>$data['content']]);
                Mail::to($record->email)
                    ->send(new ContactMail($data['content'],$record));
            })
            ->hidden(
                function ($record) {
                    return $record->status === 'success';
                }
            )
    ];
    }
}
