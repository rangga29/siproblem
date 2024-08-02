<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Data User';
    protected static ?string $navigationLabel = 'Data User';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('nik')
                        ->label('NIK')
                        ->required()
                        ->unique(User::class, 'nik', ignoreRecord: true),
                    TextInput::make('name')
                        ->label('Nama')
                        ->required(),
                    TextInput::make('password')
                        ->label('Password')
                        ->required()
                        ->password()
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord),
                    Select::make('dp_id')
                        ->label('Bagian')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('department', 'dp_name'),
                    Select::make('role')
                        ->label('Jabatan')
                        ->options([
                            'Direktorat' => 'Direktorat',
                            'Kabag' => 'Kabag',
                            'Staff' => 'Staff'
                        ]),
                ])
        ]);
    }

    public static function getColumns(): array
    {
        $user = auth()->user();

        $columns = [
            TextColumn::make('No')->state(
                static function (Tables\Contracts\HasTable $livewire, \stdClass $rowLoop): string {
                    return (string) (
                        $rowLoop->iteration + ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                    );
                }
            ),
            TextColumn::make('nik')
                ->label('NIK')
                ->searchable(),
            TextColumn::make('name')
                ->label('Nama')
                ->searchable(),
            TextColumn::make('department.dp_name')
                ->label('Bagian')
                ->searchable(),
            TextColumn::make('role')
                ->label('Jabatan')
                ->searchable(),
        ];

        if ($user->role === 'Administrator' || $user->department->dp_name === 'SISFO') {
            $columns[] = TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true);
            $columns[] = TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true);
        }

        return $columns;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getColumns())
            ->filters([
                SelectFilter::make('dp_id')
                    ->label('Bagian')
                    ->relationship('department', 'dp_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('role')
                    ->label('Jabatan')
                    ->options([
                        'Direktorat' => 'Direktorat',
                        'Kabag' => 'Kabag',
                        'Staff' => 'Staff'
                    ]),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->modal()
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->slideOver()
                        ->stickyModalHeader(),
                    DeleteAction::make()
                        ->action(fn (User $record) => $record->delete())
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-o-trash')
                        ->modalHeading('Hapus User')
                        ->modalDescription('Apakah yakin ingin menghapus User?')
                        ->modalSubmitActionLabel('Ya'),
                ])
            ])
            ->recordAction(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
