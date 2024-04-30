<?php

namespace App\Filament\Business\Resources;

use App\Filament\Business\Resources\PaymentHistoryResource\Pages;
use App\Filament\Business\Resources\PaymentHistoryResource\RelationManagers;
use App\Models\PaymentHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentHistoryResource extends Resource
{
    protected static ?string $model = PaymentHistory::class;
    protected static ?string $navigationLabel = 'Lịch sử thanh toán';

    protected static ?string $navigationGroup = 'Quản Lý Thanh Toán';

    protected static ?string $label = 'Lịch sử thanh toán';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->label('Mã thanh toán')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('order_desc')
                    ->label('Dịch vụ thanh toán')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-currency-dollar')
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Mã thanh toán')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_desc')
                    ->label('Dịch vụ thanh toán')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Giá')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Thời gian tạo')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Thời gian cập nhật')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentHistories::route('/'),
        ];
    }
}
