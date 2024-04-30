<?php

namespace App\Filament\Business\Resources;

use App\Enums\UserType;
use App\Filament\Business\Resources\UserResource\Pages;
use App\Filament\Business\Resources\UserResource\RelationManagers;
use Filament\Tables\Table;
use App\Models\Company;
use App\Models\Major;
use App\Models\Resume;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Hồ Sơ';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Họ & Tên')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->label('Địa chỉ email')
                                    ->email()
                                    ->unique(User::class, 'email', fn ($record) => $record)
                                    ->required()
                                    ->readOnly(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Số điện thoại')
                                    ->nullable()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                                Forms\Components\TextInput::make('address')
                                    ->label('Địa chỉ')
                                    ->nullable(),
                                Forms\Components\Hidden::make('password')
                                    ->default(Hash::make(Str::random(12)))
                                    ->required()
                                    ->hiddenOn(['edit', 'view']),
                                Forms\Components\Select::make('user_type')
                                    ->label('Loại tài khoản')
                                    ->required()
                                    ->searchable()
                                    ->options(UserType::class)
                                    ->live()
                                    ->afterStateUpdated(fn (Select $component) => $component
                                        ->getContainer()
                                        ->getComponent('dynamicTypeFields')
                                        ->getChildComponentContainer()
                                        ->fill())
                                    ->columnSpanFull()
                                    ->disabled(),
                                Forms\Components\Grid::make()
                                    ->schema(fn (Get $get): array => match ($get('user_type')) {
                                        'candidate' => [
                                            Forms\Components\Fieldset::make('Thông tin ứng viên')
                                                ->relationship('candidates')
                                                ->schema([
                                                    Forms\Components\Select::make('major_id')
                                                        ->label('Chuyên ngành')
                                                        ->options(Major::all()->pluck('name', 'id')),
                                                    Forms\Components\Select::make('resume_id')
                                                        ->label('Hồ sơ')
                                                        ->options(Resume::all()->pluck('name', 'id')),
                                                ]),
                                        ],
                                        'company' => [
                                            Forms\Components\Fieldset::make('Thông tin công ty')
                                                ->relationship('companies')
                                                ->schema([
                                                    Forms\Components\TextInput::make('company_name')
                                                        ->required()
                                                        ->label('Tên công ty')
                                                        ->live(onBlur: true)
                                                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                            if ($operation !== 'create') {
                                                                return;
                                                            }

                                                            $set('slug', Str::slug($state));
                                                        })
                                                        ->maxLength(255),
                                                    Forms\Components\TextInput::make('slug')
                                                        ->required()
                                                        ->label('Đường dẫn tĩnh')
                                                        ->disabled()
                                                        ->dehydrated()
                                                        ->unique(Company::class, 'slug', ignoreRecord: true),
                                                    Forms\Components\FileUpload::make('company_logo')
                                                        ->required()
                                                        ->label('Ảnh đại diện'),
                                                    Forms\Components\FileUpload::make('banner')
                                                        ->required()
                                                        ->label('Ảnh bìa'),
                                                    Forms\Components\TextInput::make('company_address')
                                                        ->required()
                                                        ->label('Địa chỉ công ty')
                                                        ->maxLength(255),
                                                    Forms\Components\TextInput::make('tax_code')
                                                        ->required()
                                                        ->label('Mã số thuế')
                                                        ->maxLength(10),
                                                    Forms\Components\RichEditor::make('company_description')
                                                        ->required()
                                                        ->label('Mô tả công ty')
                                                        ->columnSpanFull(),
                                                    Forms\Components\TextInput::make('website')
                                                        ->required()
                                                        ->label('Trang web công ty'),
                                                    Forms\Components\TextInput::make('company_size')
                                                        ->required()
                                                        ->label('Quy mô')
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('company_type')
                                                        ->required()
                                                        ->label('Loại hình công ty'),
                                                    Forms\Components\TextInput::make('company_industry')
                                                        ->required()
                                                        ->label('Ngành nghề kinh doanh')
                                                ]),
                                        ],
                                        default => [],
                                    })
                                    ->key('dynamicTypeFields')

                            ])
                            ->columns(2),
                    ])->columnSpan(2),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\DatePicker::make('email_verified_at')
                                    ->label('Xác thực email')
                                    ->readOnly()
                                    ->nullable()
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('roles')
                                    ->label('Vai trò')
                                    ->relationship('roles', 'name')
                                    ->searchable()
                                    ->required()
                                    ->preload()
                                    ->disabled()
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Ảnh')
                                    ->image()
                                    ->disk(config('images.disk', 'public'))
                                    ->directory(config('images.directory', 'users'))
                                    ->required(),
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Placeholder::make('Thời Gian Tạo:')
                                    ->content(fn (
                                        ?User $record
                                    ): string => $record ? $record->created_at->diffForHumans() : '-'),
                                Placeholder::make('Thời Gian Cập Nhật Mới Nhất:')
                                    ->content(fn (
                                        ?User $record
                                    ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ])
                    ])
            ])
            ->columns(3);
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
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
