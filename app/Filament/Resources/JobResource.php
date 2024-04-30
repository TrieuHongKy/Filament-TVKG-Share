<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Models\District;
use App\Models\Job;
use App\Models\JobDetail;
use App\Models\Ward;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Việc làm';

    protected static ?string $navigationGroup = 'Công Việc';

    protected static ?string $label = 'việc làm';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->relationship('detail')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Tiêu đề tin tuyển dụng')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                        if ($operation !== 'create') {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn tĩnh')
                                    ->required()
                                    ->helperText('Đường dẫn tĩnh được sinh ra tự động !')
                                    ->maxLength(255)
                                    ->dehydrated()
                                    ->unique(JobDetail::class, 'slug', ignoreRecord: true),
                                Forms\Components\TextInput::make('address')
                                    ->label('Số nhà / Đường / Khu vực')
                                    ->required(),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Mô tả công việc')
                                    ->required()
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Select::make('province_id')
                                            ->relationship('province', 'name')
                                            ->label('Tỉnh / Thành Phố')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->live(),
                                        Forms\Components\Select::make('district_id')
                                            ->label('Huyện / Quận / Thị Xã')
                                            ->required()
                                            ->searchable()
                                            ->live()
                                            ->preload()
                                            ->options(function (Get $get) {
                                                $provinceId = $get('province_id');

                                                if ($provinceId) {
                                                    $districts = District::where('province_id', $provinceId)->pluck('name', 'id')->toArray();
                                                    return $districts;
                                                }

                                                return [];
                                            }),
                                        Forms\Components\Select::make('ward_id')
                                            ->relationship('ward', 'name')
                                            ->label('Xã / Phường / Thị Trấn')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->live()
                                            ->options(function (Get $get) {
                                                $districtId = $get('district_id');

                                                if ($districtId) {
                                                    $wards = Ward::where('district_id', $districtId)->pluck('name', 'id')->toArray();
                                                    return $wards;
                                                }

                                                return [];
                                            }),

                                    ])
                                    ->columns(3),
                            ]),
                        Forms\Components\Section::make()
                            ->relationship('requirements')
                            ->schema([
                                Forms\Components\Select::make('major_id')
                                    ->label('Chuyên ngành')
                                    ->relationship('major', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('degree_id')
                                    ->label('Bằng cấp')
                                    ->relationship('degree', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('experience_id')
                                    ->label('Kinh nghiệm')
                                    ->relationship('experience', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                            ])
                            ->columns(3),
                        Forms\Components\Section::make()
                            ->relationship('salary')
                            ->schema([
                                Forms\Components\TextInput::make('min_salary')
                                    ->label('Tiền lương thấp nhất')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),
                                Forms\Components\TextInput::make('max_salary')
                                    ->label('Tiền lương cao nhất')
                                    ->numeric()
                                    ->required()
                                    ->gt('min_salary'),
                                Forms\Components\TextInput::make('fixed_salary')
                                    ->label('Tiền lương cố định')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                            ])
                            ->columns(3),
                    ])
                    ->columnSpan(2),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('company_id')
                                    ->label('Công ty')
                                    ->relationship('company', 'company_name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Danh mục')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('job_type_id')
                                    ->label('Loại công việc')
                                    ->relationship('jobType', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('job_status_id')
                                    ->label('Trạng thái công việc')
                                    ->relationship('jobStatus', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                            ]),
                        Forms\Components\Section::make()
                            ->relationship('attribute')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt')
                                    ->default(true)
                                    ->required(),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Nổi bật')
                                    ->default(false)
                                    ->required(),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label('Ngày công khai')
                                    ->required()
                                    ->minDate(now())
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $expiredAt = Carbon::parse($state)->addDays(30)->toDateString();
                                        $set('expired_at', $expiredAt);
                                    }),
                                Forms\Components\DatePicker::make('expired_at')
                                    ->label('Ngày hết hạn')
                                    ->required()
                                    ->readOnly(),
                            ]),
                    ])
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('detail.title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detail.description')
                    ->label('Mô tả')
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.company_name')
                    ->label('Công ty')
                    ->sortable(),
                Tables\Columns\TextColumn::make('requirements.major.name')
                    ->label('Công việc')
                    ->sortable(),
                Tables\Columns\TextColumn::make('requirements.experience.name')
                    ->label('Kinh nghiệm')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Danh mục')
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
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
