<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\Widgets\CategoryStats;
use App\Models\Category;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationLabel = 'Danh mục';
    protected static ?string $navigationGroup = 'Tổng Quan';

    protected static ?string $label = 'danh mục';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Select::make('parent_id')
                        ->label('Danh mục')
                        ->searchable()
                        ->relationship('parent', 'name'),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Tên')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        })
                        ->maxLength(255),
                    Forms\Components\Toggle::make('status')
                        ->label('Trạng thái'),
                    Forms\Components\FileUpload::make('image')
                        ->label('Ảnh')
                        ->image(),
                    Forms\Components\RichEditor::make('description')
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
                                     ->helperText('Đường dẫn tĩnh được sinh ra tự động !')
                                     ->maxLength(255)
                                     ->dehydrated()
                                     ->unique(Category::class, 'slug', ignoreRecord: true),
                             ]),
                         Forms\Components\Section::make()
                             ->schema([
                                 Placeholder::make('Thời Gian Tạo:')
                                     ->content(fn (
                                         ?Category $record
                                     ): string => $record ? $record->created_at->diffForHumans() : '-'),
                                 Placeholder::make('Thời Gian Cập Nhật Mới Nhất:')
                                     ->content(fn (
                                         ?Category $record
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
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Danh mục')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Đường dẫn tỉnh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                ->label('Ảnh'),
                Tables\Columns\IconColumn::make('status')
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

    public static function getWidgets(): array
    {
        return [
            CategoryStats::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
