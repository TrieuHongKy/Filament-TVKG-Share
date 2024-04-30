<?php

namespace App\Filament\Business\Resources;

use App\Filament\Business\Resources\JobResource\Pages;
use App\Filament\Business\Resources\JobResource\RelationManagers;
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

    protected static ?string $navigationLabel = 'Việc làm';

    protected static ?string $navigationGroup = 'Quản Lý Việc Làm';

    protected static ?string $label = 'việc làm';

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

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
                                    ->required(),
                                Forms\Components\Select::make('degree_id')
                                    ->label('Bằng cấp')
                                    ->relationship('degree', 'name')
                                    ->required(),
                                Forms\Components\Select::make('experience_id')
                                    ->label('Kinh nghiệm')
                                    ->relationship('experience', 'name')
                                    ->required()
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
                        Forms\Components\Hidden::make('company_id')
                            ->default(fn() => DB::table('companies')
                                ->where('user_id', auth()->id())
                                ->value('id'))
                    ])
                ->columnSpan(2),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Danh mục')
                                    ->relationship('category', 'name')
                                    ->required()
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('job_type_id')
                                    ->label('Loại công việc')
                                    ->relationship('jobType', 'name')
                                    ->required()
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('job_status_id')
                                    ->label('Trạng thái công việc')
                                    ->relationship('jobStatus', 'name')
                                    ->required()
                            ]),
                        Forms\Components\Section::make()
                            ->relationship('attribute')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt')
                                    ->default(true)
                                    ->disabled()
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
                Tables\Columns\IconColumn::make('attribute.is_featured')
                    ->label('Nổi bật')
                    ->sortable()
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
                Tables\Actions\Action::make('Nổi Bật')

                    ->action(function ($record) {
                        $currentRowId = $record->getKey();

                        session(['current_row_id' => $currentRowId]);

                        return redirect('business/payment');
                    })
                    ->icon('heroicon-o-fire')
                    ->color(\Filament\Support\Colors\Color::Orange)
                    ->requiresConfirmation()
                    ->modalHeading('Tin Nổi Bật!')
                    ->modalDescription('Đây là chức năng tin nổi bật, tin tuyển dụng của bạn sẽ xuất hiện tại khu vực riêng dành cho tin nổi bật, việc này có thể giúp tin tuyển dụng của bạn tiếp cận với nhiều ứng viên hơn.')
                    ->modalSubmitActionLabel('Thanh Toán (20.000đ)')
                    ->modalIcon('heroicon-o-fire')
                    ->modalIconColor(\Filament\Support\Colors\Color::Orange)
                    ->hidden(
                        function ($record) {
                            return $record->attribute->is_featured === 1;
                        }
                    ),
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
