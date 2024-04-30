<?php

namespace App\Filament\Table\Action;

use App\Mail\ActionMail;
use App\Models\ApplyJob;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;


class FailedAction extends Action {

    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'Từ Chối';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-x-mark');

        $this->requiresConfirmation();

        $this->color('danger');

        $this->action(function (): void {
            $this->process(function (array $data, Model $record, Table $table) {
                    $record->update(['status' => 'failed',]);
                Mail::to($record->candidate->user->email)
                    ->send(new ActionMail($record));
            });
        });

        $this->success();
    }

}
