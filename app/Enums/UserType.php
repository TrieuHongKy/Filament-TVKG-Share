<?php

declare(strict_types = 1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UserType: string implements HasLabel, HasIcon, HasColor{

    case Candidate = 'candidate';
    case Company = 'company';

    public function getLabel()
    : string{
        return match ($this) {
            self::Candidate => 'Ứng viên',
            self::Company => 'Công ty',
        };
    }

    public function getIcon()
    : string{
        return match ($this) {
            self::Candidate => 'heroicon-o-user-circle',
            self::Company => 'heroicon-o-building-office-2',
        };
    }

    public function getColor()
    : string{
        return match ($this) {
            self::Candidate => 'primary',
            self::Company => 'secondary',
        };
    }
}
