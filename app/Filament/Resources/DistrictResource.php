<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DistrictResource\Pages;
use App\Filament\Resources\DistrictResource\RelationManagers;
use App\Models\District;
use App\Models\Major;
use App\Models\Province;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static ?string $navigationLabel = 'Cấp Huyện';
    protected static ?string $navigationGroup = 'Đơn Vị Hành Chính';
    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'cấp huyện';
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Select::make('province_id')
                        ->label('Mã cấp tỉnh')
                        ->searchable()
                        ->relationship('province','name')
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Tên')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        })
                        ->maxLength(255),
                ])
                ->columnSpan(2),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn tĩnh')
                                    ->required()
                                    ->helperText('Đường dẫn tĩnh được sinh ra tự động !')
                                    ->maxLength(255)
                                    ->dehydrated()
                                    ->unique(District::class, 'slug', ignoreRecord: true),
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Placeholder::make('Thời Gian Tạo:')
                                    ->content(fn (
                                        ?District $record
                                    ): string => $record ? $record->created_at->diffForHumans() : '-'),
                                Placeholder::make('Thời Gian Cập Nhật Mới Nhất:')
                                    ->content(fn (
                                        ?District $record
                                    ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ])
                    ])
                    ->columnSpan(1)
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('province_id')
                    ->label('Mã tỉnh')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Đường dẫn tĩnh')
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\WardsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDistricts::route('/'),
            'create' => Pages\CreateDistrict::route('/create'),
            'edit' => Pages\EditDistrict::route('/{record}/edit'),
        ];
    }
}
