<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\EducationResource\Pages;
use App\Filament\Resources\EducationResource\RelationManagers;
use App\Models\Degree;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;


    protected static ?string $navigationLabel = 'Cơ Sở Giáo Dục';
    protected static ?string $navigationGroup = 'Tổng Quan';

    protected static ?string $label = 'giáo dục';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('education_name')
                            ->required()
                            ->label('Tên trường')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('major')
                            ->label('Chuyên ngành')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('institution')
                            ->required()
                            ->label('Tổ chức')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->label('Thành phố')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->label('Quốc gia')
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('description')
                            ->label('Mô tả')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2)
                    ->columns(2),
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\DatePicker::make('start_date')
                                        ->label('Ngày bắt đầu')
                                        ->required(),
                                    Forms\Components\DatePicker::make('end_date')
                                        ->label('Ngày kết thúc')
                                        ->required(),
                            ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Placeholder::make('Thời Gian Tạo:')
                                        ->content(fn (
                                            ?Education $record
                                        ): string => $record ? $record->created_at->diffForHumans() : '-'),
                                    Placeholder::make('Thời Gian Cập Nhật Mới Nhất:')
                                        ->content(fn (
                                            ?Education $record
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
                Tables\Columns\TextColumn::make('education_name')
                    ->label('Tên')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Ngày bắt đầu')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Ngày kết thúc')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('major')
                    ->label('Chuyên ngành')
                    ->searchable(),
                Tables\Columns\TextColumn::make('institution')
                    ->label('Tổ chức')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Thành phố')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Quốc gia')
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}
