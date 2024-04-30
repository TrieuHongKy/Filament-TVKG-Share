<?php

namespace App\Filament\Business\Resources;

use App\Enums\ApplyJobStatus;
use App\Filament\Business\Resources\ApplyJobResource\Pages;
use App\Filament\Business\Resources\ApplyJobResource\RelationManagers;
use App\Filament\Table\Action\FailedAction;
use App\Filament\Table\Action\SuccessAction;
use App\Models\ApplyJob;
use App\Models\Candidate;
use App\Models\JobDetail;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApplyJobResource extends Resource
{
    protected static ?string $model = ApplyJob::class;

    protected static ?string $navigationLabel = 'Hồ sơ ứng tuyển';

    protected static ?string $navigationGroup = 'Quản Lý Việc Làm';

    protected static ?string $label = 'Hồ sơ ứng tuyển';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('job_id')
                            ->label('Công việc')
                            ->options(JobDetail::all()->pluck('title', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('candidate_id')
                            ->label('Ứng viên')
                            ->options(
                                Candidate::join('users', 'candidates.user_id', '=', 'users.id')
                                    ->get(['candidates.id', 'users.name as user_name'])
                                    ->pluck('user_name', 'id')
                            )
                            ->searchable()
                            ->required(),
                    ])
                ->columnSpan(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options(ApplyJobStatus::class)
                            ->searchable()
                    ])
                ->columnSpan(1)
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-document-text')
            ->columns([
                Tables\Columns\TextColumn::make('detail.title')
                    ->label('Công việc')
                    ->sortable(),
                Tables\Columns\TextColumn::make('candidate.user.name')
                    ->label('Ứng viên')
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->searchable()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                SuccessAction::make(),
                FailedAction::make()
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Model $record): bool => $record->status === ApplyJobStatus::Pending,
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        Split::make([
                            Grid::make(2)
                                ->schema([
                                    Group::make([
                                        TextEntry::make('candidate.user.name')
                                            ->label('Tên ứng viên:'),
                                        TextEntry::make('candidate.user.email')
                                            ->label('Địa chỉ email:'),
                                        TextEntry::make('candidate.user.phone')
                                            ->label('Số điện thoại:'),
                                        TextEntry::make('candidate.user.address')
                                            ->label('Địa chỉ:'),
                                    ]),
                                    Group::make([
                                        TextEntry::make('candidate.candidateEducations.education.education_name')
                                            ->label('Học vấn:'),
                                        TextEntry::make('candidate.languages.name')
                                            ->label('Ngôn ngữ:'),
                                        TextEntry::make('candidate.majors.name')
                                            ->label('Chuyên ngành:'),
                                        TextEntry::make('candidate.skills.name')
                                            ->label('Kỹ năng:')
                                    ]),
                                ]),
                            ImageEntry::make('candidate.user.image')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from('lg'),
                    ]),
                Section::make('Công việc ứng tuyển')
                    ->schema([
                        Split::make([
                            Grid::make(2)
                                ->schema([
                                    Group::make([
                                        TextEntry::make('detail.title')
                                            ->label('Tên công việc:'),
                                        TextEntry::make('detail.slug')
                                            ->label('Đường dẫn tĩnh:'),
                                    ]),
                                    Group::make([
                                        TextEntry::make('status')
                                            ->label('Trạng thái')
                                            ->badge(),
                                    ]),
                                ]),
                        ])->from('lg'),
                    ])
                    ->collapsible(),
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
            'view' => Pages\ViewApplyJob::route('/{record}'),
            'index' => Pages\ListApplyJobs::route('/'),
        ];
    }
}
