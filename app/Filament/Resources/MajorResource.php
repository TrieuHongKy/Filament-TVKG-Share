<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MajorResource\Pages;
use App\Filament\Resources\MajorResource\RelationManagers;
use App\Models\Degree;
use App\Models\Major;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MajorResource extends Resource
{
    protected static ?string $model = Major::class;

    protected static ?string $navigationLabel = 'Chuyên Ngành';
    protected static ?string $navigationGroup = 'Tổng Quan';

    protected static ?string $label = 'chuyên ngành';
    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Chuyên ngành')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        })
                        ->maxLength(100),
                    Forms\Components\TextInput::make('short_name')
                        ->label('Tên viết tắt')
                        ->required()
                        ->maxLength(10),
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
                                ->unique(Major::class, 'slug', ignoreRecord: true),
                        ]),
                    Forms\Components\Section::make()
                        ->schema([
                            Placeholder::make('Thời Gian Tạo:')
                                ->content(fn (
                                    ?Major $record
                                ): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Placeholder::make('Thời Gian Cập Nhật Mới Nhất:')
                                ->content(fn (
                                    ?Major $record
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Chuyên ngành')
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_name')
                    ->label('Tên viết tắt')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMajors::route('/'),
            'create' => Pages\CreateMajor::route('/create'),
            'edit' => Pages\EditMajor::route('/{record}/edit'),
        ];
    }
}
