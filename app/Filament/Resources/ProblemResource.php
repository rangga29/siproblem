<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProblemResource\Pages;
use App\Models\Problem;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProblemResource extends Resource
{
    protected static ?string $model = Problem::class;

    protected static ?string $label = 'Data Permasalahan';
    protected static ?string $navigationLabel = 'Data Permasalahan';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                TextInput::make('pr_name')
                    ->label('Nama Permasalahan')
                    ->required(),
                Hidden::make('pr_ucode')
                    ->default(Str::random(20))
                    ->unique(Problem::class, 'pr_ucode', ignoreRecord: true),
                Select::make('dp_id')
                    ->label('Nama Unit')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'department',
                        titleAttribute: 'dp_name',
                        modifyQueryUsing: function (Builder $query) {
                            if (auth()->user()->role === 'Administrator') {
                                return $query->where('dp_spr', true);
                            } else {
                                return $query->where('dp_spr', true)->where('id', auth()->user()->dp_id);
                            }
                        },
                    ),
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
            Tables\Columns\TextColumn::make('department.dp_name')
                ->label('Unit')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('pr_name')
                ->label('Name')
                ->searchable()
                ->sortable(),
        ];

        if ($user->role === 'Administrator') {
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
                    ->label('Unit')
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'department',
                        titleAttribute: 'dp_name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('dp_spr', true),
                    ),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->modal()
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->slideOver()
                        ->stickyModalHeader(),
                    DeleteAction::make()
                        ->action(fn (Problem $record) => $record->delete())
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-o-trash')
                        ->modalHeading('Hapus Data Permasalahan')
                        ->modalDescription('Apakah yakin ingin menghapus data?')
                        ->modalSubmitActionLabel('Ya'),
                ])
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->role === 'Administrator') {
                    return $query;
                } else {
                    return $query->where('dp_id', auth()->user()->dp_id);
                }
            })
            ->recordAction(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProblems::route('/'),
        ];
    }
}
