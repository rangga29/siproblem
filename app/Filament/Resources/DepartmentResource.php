<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $label = 'Data Bagian';
    protected static ?string $navigationLabel = 'Data Bagian';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                TextInput::make('dp_code')
                    ->label('Kode Bagian')
                    ->required()
                    ->unique(Department::class, 'dp_code', ignoreRecord: true),
                TextInput::make('dp_name')
                    ->label('Nama Bagian')
                    ->required()
                    ->unique(Department::class, 'dp_name', ignoreRecord: true),
                TextInput::make('dp_group')
                    ->label('Nama Grup Bagian'),
                Toggle::make('dp_spr')
                    ->label('Ketersediaan SPR')
                    ->default(true),
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
            TextColumn::make('dp_code')
                ->label('Kode')
                ->searchable()
                ->sortable(),
            TextColumn::make('dp_name')
                ->label('Nama')
                ->searchable()
                ->sortable(),
            TextColumn::make('dp_group')
                ->label('Grup')
                ->searchable()
                ->sortable(),
            IconColumn::make('dp_spr')
                ->label('SPR')
                ->boolean(),
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
                Filter::make('dp_spr')
                    ->label('SPR Aktif')
                    ->query(fn (Builder $query): Builder => $query->where('dp_spr', true))
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->modal()
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->slideOver()
                        ->stickyModalHeader(),
                    DeleteAction::make()
                        ->action(fn (Department $record) => $record->delete())
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-o-trash')
                        ->modalHeading('Hapus Bagian')
                        ->modalDescription('Apakah yakin ingin menghapus data?')
                        ->modalSubmitActionLabel('Ya'),
                ])
            ])
            ->recordAction(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDepartments::route('/'),
        ];
    }
}
