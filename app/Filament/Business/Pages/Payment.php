<?php

namespace App\Filament\Business\Pages;

use Filament\Pages\Page;

class Payment extends Page
{

    protected ?string $heading = 'Thanh Toán';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.business.pages.outstanding-payment';
}
