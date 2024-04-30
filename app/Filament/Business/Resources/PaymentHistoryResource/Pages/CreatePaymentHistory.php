<?php

namespace App\Filament\Business\Resources\PaymentHistoryResource\Pages;

use App\Filament\Business\Resources\PaymentHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentHistory extends CreateRecord
{
    protected static string $resource = PaymentHistoryResource::class;
}
