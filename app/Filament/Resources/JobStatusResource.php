<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobStatusResource\Pages;
use App\Filament\Resources\JobStatusResource\RelationManagers;
use App\Models\JobStatus;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class JobStatusResource extends Resource
{
    protected static ?string $model = JobStatus::class;

    protected static ?string $navigationLabel = 'Trạng thái công việc';

    protected static ?string $navigationGroup = 'Công Việc';

    protected static ?string $label = 'trạng thái công việc';

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên trạng thái công việc')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            })
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Trạng thái hoạt động')
                            ->required()
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
                                    ->unique(JobStatus::class, 'slug', ignoreRecord: true),
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Placeholder::make('Thời Gian Tạo:')
                                    ->content(fn (
                                        ?JobStatus $record
                                    ): string => $record ? $record->created_at->diffForHumans() : '-'),
                                Placeholder::make('Thời Gian Cập Nhật Mới Nhất:')
                                    ->content(fn (
                                        ?JobStatus $record
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
                    ->label('Tên trạng thái')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Đường dẫn tĩnh')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Trạng thái')
                    ->boolean(),
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
            'index' => Pages\ListJobStatuses::route('/'),
            'create' => Pages\CreateJobStatus::route('/create'),
            'edit' => Pages\EditJobStatus::route('/{record}/edit'),
        ];
    }
}
