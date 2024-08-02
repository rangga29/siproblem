<?php

namespace App\Filament\Temp;

use App\Filament\Resources\SprResource\Pages;
use App\Models\SPR;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SprResource extends Resource
{
    protected static ?string $model = SPR::class;

    protected static ?string $label = 'Data SPR';
    protected static ?string $navigationLabel = 'Data SPR';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Temp\SprResource\Pages\ListSprs::route('/'),
            'create' => \App\Filament\Temp\SprResource\Pages\CreateSpr::route('/create'),
            'edit' => \App\Filament\Temp\SprResource\Pages\EditSpr::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['sender']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['sender.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->sender) {
            $details['Sender'] = $record->sender->name;
        }

        return $details;
    }
}
