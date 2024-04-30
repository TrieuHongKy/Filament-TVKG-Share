<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WidgetResource\Pages;
use App\Filament\Resources\WidgetResource\RelationManagers;
use App\Models\Widget;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class WidgetResource extends Resource
{
    protected static ?string $model = Widget::class;
    protected static ?string $navigationGroup = 'Tổng Quan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                    Forms\Components\TextInput::make('key')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('title')
                        ->label('Tiêu đề')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        })
                        ->maxLength(255),
                    Forms\Components\TextInput::make('link')
                        ->label('Đường dẫn')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                        ->label('Mô tả')
                        ->maxLength(65535)
                        ->columnSpanFull(),
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
                                    ->unique(Widget::class, 'slug', ignoreRecord: true),
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Placeholder::make('Thời Gian Tạo:')
                                    ->content(fn (
                                        ?Widget $record
                                    ): string => $record ? $record->created_at->diffForHumans() : '-'),
                                Placeholder::make('Thời Gian Cập Nhật Mới Nhất:')
                                    ->content(fn (
                                        ?Widget $record
                                    ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ]),
                        Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->image()
                                ->disk(config('images.disk', 'public'))
                                ->directory(config('images.directory', 'widget'))
                                ->required(),
                        ])
                    ])
                    ->columnSpan(1)
            ])
            ->columns(3);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-rectangle-stack')
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Đường dẫn tĩnh')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                ->label('Ảnh'),
                Tables\Columns\TextColumn::make('link')
                    ->label('Đường dẫn')
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
            'index' => Pages\ListWidgets::route('/'),
            'edit' => Pages\EditWidget::route('/{record}/edit'),
        ];
    }
}
