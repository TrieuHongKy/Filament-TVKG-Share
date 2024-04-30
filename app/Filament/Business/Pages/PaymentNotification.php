<?php

namespace App\Filament\Business\Pages;

use Filament\Pages\Page;

class PaymentNotification extends Page
{
    protected ?string $heading = 'Thông Báo Thanh Toán';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.business.pages.payment-notification';
}
