<?php

namespace App\Filament\Temp;

use App\Models\Department;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $label = 'Data Bagian';
    protected static ?string $navigationLabel = 'Data Bagian';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('dp_code')
                            ->label('Kode Bagian')
                            ->required()
                            ->unique(Department::class, 'dp_code', ignoreRecord: true),
                        TextInput::make('dp_name')
                            ->label('Nama Bagian')
                            ->required()
                            ->unique(Department::class, 'dp_name', ignoreRecord: true),
                        TextInput::make('dp_group')
                            ->label('Grup Bagian'),
                        Toggle::make('dp_spr')
                            ->label('Ketersediaan SPR')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, \stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                    $livewire->getTablePage() - 1
                                ))
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
                IconColumn::make('dp_spr')
                    ->label('SPR')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('dp_spr')
                    ->label('SPR Aktif')
                    ->query(fn (Builder $query): Builder => $query->where('dp_spr', true))
            ])
            ->actions([
                EditAction::make()
                    ->slideOver(),
                DeleteAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => \App\Filament\Temp\DepartmentResource\Pages\ListDepartments::route('/'),
            'create' => \App\Filament\Temp\DepartmentResource\Pages\CreateDepartment::route('/create'),
            'edit' => \App\Filament\Temp\DepartmentResource\Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
