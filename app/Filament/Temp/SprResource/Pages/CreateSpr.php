<?php

namespace App\Filament\Temp\SprResource\Pages;

use App\Filament\Temp\SprResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSpr extends CreateRecord
{
    protected static string $resource = SprResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
