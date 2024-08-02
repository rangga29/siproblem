<?php

namespace App\Filament\Temp\SprResource\Pages;

use App\Filament\Temp\SprResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSprs extends ListRecords
{
    protected static string $resource = SprResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
