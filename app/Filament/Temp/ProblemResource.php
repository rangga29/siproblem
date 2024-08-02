<?php

namespace App\Filament\Temp;

use App\Filament\Admin\Resources\DepartmentResource\Pages;
use App\Filament\Admin\Resources\DepartmentResource\RelationManagers;
use App\Models\Problem;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProblemResource extends Resource
{
    protected static ?string $model = Problem::class;

    protected static ?string $label = 'Data Permasalahan';
    protected static ?string $navigationLabel = 'Data Permasalahan';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('pr_name')
                            ->label('Nama Permasalahan')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if($operation !== 'create') { return; }
                                $set('pr_ucode', Str::random(20));
                            }),
                        Forms\Components\TextInput::make('pr_ucode')
                            ->label('Kode Permasalahan')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->unique(Problem::class, 'pr_ucode', ignoreRecord: true),
                        Forms\Components\Select::make('dp_id')
                            ->label('Department')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship(
                                name: 'department',
                                titleAttribute: 'dp_name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('dp_spr', true),
                            )
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->state(
                    static function (Tables\Contracts\HasTable $livewire, \stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                    $livewire->getTablePage() - 1
                                ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('pr_name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.dp_name')
                    ->label('Department')
                    ->searchable(),
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Temp\ProblemResource\Pages\ListProblems::route('/'),
            'create' => \App\Filament\Temp\ProblemResource\Pages\CreateProblem::route('/create'),
            'edit' => \App\Filament\Temp\ProblemResource\Pages\EditProblem::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
