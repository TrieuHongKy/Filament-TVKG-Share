<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ApplyJobStatus: string implements HasLabel, HasColor {

    case Pending = 'pending';
    case Failed  = 'failed';
    case Success  = 'success';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'Đợi Duyệt',
            self::Failed => 'Từ Chối',
            self::Success => 'Đã Duyệt',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Failed => 'danger',
            self::Success => 'primary',
        };
    }
}
