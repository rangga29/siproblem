<?php

namespace App\Filament\Temp;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Data User';
    protected static ?string $navigationLabel = 'Data User';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->unique(User::class, 'nik', ignoreRecord: true),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord),
                        Forms\Components\Select::make('dp_id')
                            ->label('Department')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('department', 'dp_name'),
                        Forms\Components\Select::make('role')
                            ->label('Religion')
                            ->options([
                                'Direktorat' => 'Direktorat',
                                'Kabag' => 'Kabag',
                                'Staff' => 'Staff'
                            ]),
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
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.dp_name')
                    ->label('Department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Jabatan')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => \App\Filament\Temp\UserResource\Pages\ListUsers::route('/'),
            'create' => \App\Filament\Temp\UserResource\Pages\CreateUser::route('/create'),
            'edit' => \App\Filament\Temp\UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
