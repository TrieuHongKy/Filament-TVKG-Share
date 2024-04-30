<?php

namespace App\Filament\Table\Action;

use App\Mail\ActionMail;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;


class SuccessAction extends Action {

    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'Chấp Nhận';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-check');

        $this->color('success');

        $this->action(function (): void {
            $this->process(function (array $data, Model $record, Table $table) {
                $record->update(['status' => 'success',]);
                Mail::to($record->candidate->user->email)
                    ->send(new ActionMail($record));
            });
        });

        $this->success();
    }

}
